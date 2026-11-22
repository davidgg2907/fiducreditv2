<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\DemoAccessSeeder;
use Database\Seeders\DemoRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AccessMenuTest extends TestCase
{
    use RefreshDatabase;

    private const PASSWORD = 'Password123456';

    public function test_demo_seeder_requests_a_password_when_none_is_configured(): void
    {
        config(['demo_access.password' => null]);

        $this->artisan('db:seed', ['--class' => DemoAccessSeeder::class])
            ->expectsQuestion('Contraseña para las cuentas demo (mínimo 12 caracteres, máximo 72 bytes)', self::PASSWORD)
            ->assertSuccessful();

        $this->assertSame(
            3,
            User::query()->where('email', 'like', '%@arquetipo.test')->count()
        );
        $this->login(User::where('email', 'mariana.salgado@arquetipo.test')->firstOrFail());
    }

    public function test_demo_users_can_log_in_and_receive_their_own_menu_options(): void
    {
        config(['demo_access.password' => self::PASSWORD]);

        $this->seed(DemoAccessSeeder::class);
        $this->seed(DemoAccessSeeder::class);

        $this->assertDatabaseCount('access_modules', 4);
        $this->assertDatabaseCount('module_actions', 6);
        $this->assertDatabaseCount('menu_items', 5);
        $this->assertSame(
            3,
            Role::query()->whereIn('name', [
                DemoRolesSeeder::COORDINACION,
                DemoRolesSeeder::ANALISTA,
                DemoRolesSeeder::COLABORADOR,
            ])->count()
        );
        $this->assertSame(
            3,
            User::query()->where('email', 'like', '%@arquetipo.test')->count()
        );

        foreach ([
            ['mariana.salgado', DemoRolesSeeder::COORDINACION, ['/home', '/perfil'], true],
            ['diego.valdes', DemoRolesSeeder::ANALISTA, ['/home'], false],
            ['elena.cortes', DemoRolesSeeder::COLABORADOR, ['/perfil'], false],
        ] as [$account, $role, $routes, $canReview]) {
            $user = User::where('email', $account.'@arquetipo.test')->firstOrFail();
            $login = $this->login($user)
                ->assertJsonPath('data.user.role.name', $role)
                ->assertJsonPath('data.user.menu.2.code', 'demo_gestion_personal');

            $this->assertSame($routes, array_column($login->json('data.user.menu.2.children'), 'routerLink'));
            $this->assertSame($canReview, in_array('demo_panel_personal.revisar', $login->json('data.user.permissions'), true));
        }

        $this->login($this->user('sin-rol'))->assertJsonCount(2, 'data.user.menu');
    }

    public function test_seeding_is_repeatable_and_preserves_existing_roles(): void
    {
        $this->seed();
        $totalRoles = Role::query()->count();

        Role::where('name', 'Usuario')->firstOrFail()
            ->update(['permissions' => ['perfil.ver']]);

        $this->seed();

        $this->assertSame($totalRoles, Role::query()->count());

        $this->assertDatabaseCount('access_modules', 2);
        $this->assertDatabaseCount('module_actions', 3);
        $this->assertDatabaseCount('menu_items', 2);
        $this->assertSame(
            1,
            Role::query()->where('name', 'Usuario')->count()
        );
        $this->assertSame(['perfil.ver'], Role::where('name', 'Usuario')->firstOrFail()->permissions);

        $login = $this->login($this->user('ordinary'));
        $login->assertJsonPath('data.user.role', null)
            ->assertJsonPath('data.user.menu.0.code', 'inicio')
            ->assertJsonPath('data.user.menu.1.code', 'perfil');
    }

    public function test_root_can_manage_roles_and_session_only_returns_visible_menu(): void
    {
        $this->travelTo(now()->setTimestamp(59));
        $this->seed();
        $module = DB::table('access_modules')->insertGetId(['code' => 'clientes', 'name' => 'Clientes']);
        $view = DB::table('module_actions')->insertGetId([
            'module_id' => $module, 'permission' => 'clientes.ver', 'name' => 'Consultar clientes',
        ]);
        $edit = DB::table('module_actions')->insertGetId([
            'module_id' => $module, 'permission' => 'clientes.editar', 'name' => 'Editar clientes',
        ]);
        $group = DB::table('menu_items')->insertGetId(['code' => 'operacion', 'label' => 'Operación', 'position' => 30]);
        DB::table('menu_items')->insert([
            ['code' => 'clientes', 'label' => 'Clientes', 'parent_id' => $group, 'module_action_id' => $view, 'route' => '/clientes'],
            ['code' => 'edicion', 'label' => 'Edición', 'parent_id' => $group, 'module_action_id' => $edit, 'route' => '/clientes/editar'],
        ]);

        $ordinary = $this->user('ordinary');
        $ordinaryLogin = $this->login($ordinary);
        $ordinaryLogin->assertJsonCount(2, 'data.user.menu');
        $ordinaryToken = $ordinaryLogin->json('data.tokens.accessToken');
        $roleData = ['name' => 'Lectura', 'permissions' => ['clientes.ver']];
        $this->withToken($ordinaryToken)->postJson('/api/access/roles', $roleData)->assertForbidden();

        $root = $this->user('root');
        $root->forceFill(['is_superadmin' => true, 'mfa_secret' => 'GEZDGNBVGY3TQOJQGEZDGNBVGY3TQOJQ'])->save();
        $rootLogin = $this->login($root, ['mfa_code' => '287082']);
        $rootLogin->assertJsonCount(2, 'data.user.menu.2.children');
        $rootToken = $rootLogin->json('data.tokens.accessToken');

        $this->withToken($rootToken)->getJson('/api/access/catalog')->assertOk()
            ->assertJsonPath('data.0.code', 'clientes');
        $this->postJson('/api/access/roles', ['name' => 'Inválido', 'permissions' => ['clientes.borrar']])
            ->assertUnprocessable();
        $role = $this->postJson('/api/access/roles', $roleData)->assertCreated()->json('data');
        $this->putJson('/api/access/users/'.$root->id.'/role', ['role_id' => $role['id']])->assertForbidden();
        $this->putJson('/api/access/users/'.$ordinary->id.'/role', ['role_id' => $role['id']])->assertOk();

        $this->withToken($ordinaryToken)->getJson('/api/me')->assertOk()
            ->assertJsonPath('data.user.role.name', 'Lectura')
            ->assertJsonCount(1, 'data.user.menu.2.children')
            ->assertJsonPath('data.user.menu.2.children.0.routerLink', '/clientes');

        $this->withToken($rootToken)->putJson('/api/access/roles/'.$role['id'], [
            'name' => 'Lectura', 'permissions' => [],
        ])->assertOk();
        $this->withToken($ordinaryToken)->getJson('/api/me')->assertOk()->assertJsonCount(2, 'data.user.menu');

        $refresh = $ordinaryLogin->getCookie(config('auth_tokens.refresh_cookie_name'), false);
        $this->withCredentials()->withUnencryptedCookie($refresh->getName(), $refresh->getValue())
            ->postJson('/api/login/refresh')->assertOk()
            ->assertJsonPath('data.user.role.id', $role['id'])
            ->assertJsonCount(2, 'data.user.menu');
    }

    private function login(User $user, array $extra = []): \Illuminate\Testing\TestResponse
    {
        return $this->withHeader('X-Auth-Request', '1')->postJson('/api/login', [
            'email' => $user->email, 'password' => self::PASSWORD,
        ] + $extra)->assertOk();
    }

    private function user(string $name): User
    {
        return User::create(['name' => $name, 'email' => $name.'@example.test', 'password' => self::PASSWORD]);
    }
}
