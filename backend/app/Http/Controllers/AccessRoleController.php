<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

final class AccessRoleController extends Controller
{
    public function catalog(): JsonResponse
    {
        $actions = DB::table('module_actions')->orderBy('permission')
            ->get(['module_id', 'permission', 'name'])->groupBy('module_id');

        $modules = DB::table('access_modules')->orderBy('code')->get()->map(fn (object $module) => [
            'code' => $module->code,
            'name' => $module->name,
            'actions' => $actions->get($module->id, collect())->map(fn (object $action) => [
                'permission' => $action->permission,
                'name' => $action->name,
            ])->all(),
        ]);

        return response()->json(['isSuccess' => true, 'data' => $modules]);
    }

    public function index(): JsonResponse
    {
        return response()->json(['isSuccess' => true, 'data' => Role::orderBy('name')->get(['id', 'name', 'permissions'])]);
    }

    public function show(int $role): JsonResponse
    {
        return response()->json(['isSuccess' => true, 'data' => Role::findOrFail($role)->only(['id', 'name', 'permissions'])]);
    }

    public function destroy(int $role): JsonResponse
    {
        DB::transaction(function () use ($role) {
            $target = Role::lockForUpdate()->findOrFail($role);
            if (User::where('role_id', $target->id)->exists()) {
                throw ValidationException::withMessages(['role' => 'El rol tiene usuarios asignados y no puede eliminarse.']);
            }
            $target->delete();
        }, 3);
        return response()->json(['isSuccess' => true]);
    }

    public function store(Request $request): JsonResponse
    {
        return $this->save($request, new Role, 201);
    }

    public function update(Request $request, int $role): JsonResponse
    {
        return $this->save($request, Role::findOrFail($role), 200);
    }

    public function assign(Request $request, int $user): JsonResponse
    {
        $user = User::findOrFail($user);
        abort_if($user->is_superadmin, 403);
        $data = $request->validate(['role_id' => ['present', 'nullable', 'integer', Rule::exists('roles', 'id')]]);
        DB::transaction(function () use ($user, $data) {
            $target = User::lockForUpdate()->findOrFail($user->id);
            abort_if($target->is_superadmin, 403);
            $target->role()->associate($data['role_id']);
            $target->save();
            app(\\App\\Repositories\\AuthTokenRepository::class)->revokeForUser($target->id);
        }, 3);

        return response()->json(['isSuccess' => true, 'data' => ['userId' => $user->id, 'roleId' => $user->role_id]]);
    }

    private function save(Request $request, Role $role, int $status): JsonResponse
    {
        $nameRule = Rule::unique('roles', 'name');
        if ($role->exists) {
            $nameRule->ignore($role);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', $nameRule],
            'permissions' => ['present', 'array', 'list'],
            'permissions.*' => ['required', 'string', 'max:160', 'distinct'],
        ]);

        // MySQL may compare strings case-insensitively. Match the exact keys used by the Gate.
        $known = DB::table('module_actions')->whereIn('permission', $data['permissions'])->pluck('permission')->all();
        if (array_diff($data['permissions'], $known) !== []) {
            throw ValidationException::withMessages(['permissions' => 'Selecciona acciones con las claves exactas del catálogo.']);
        }

        try {
            $role->fill($data)->save();
        } catch (UniqueConstraintViolationException) {
            throw ValidationException::withMessages(['name' => 'Ya existe un rol con ese nombre.']);
        }

        return response()->json(['isSuccess' => true, 'data' => $role->only(['id', 'name', 'permissions'])], $status);
    }
}
