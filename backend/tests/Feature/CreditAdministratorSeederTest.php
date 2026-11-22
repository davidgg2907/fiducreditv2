<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\CreditAdministratorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CreditAdministratorSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_implicit_privileged_bootstrap_is_disabled_in_testing(): void
    {
        $this->seed(CreditAdministratorSeeder::class);
        $this->assertDatabaseMissing('users', ['email' => 'administrador@nahuicredit.com']);
        $this->assertSame(0, User::query()->where('is_superadmin', true)->count());
    }
}
