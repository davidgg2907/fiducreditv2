<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRules;
use App\Models\User;
use App\Repositories\AuthTokenRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

final class AccessUserController extends Controller
{
    public function __construct(private AuthTokenRepository $tokens) {}

    public function index(Request $request): JsonResponse
    {
        $data = $request->validate([
            'search' => ['sometimes', 'string', 'max:150'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'is_active' => ['sometimes', 'boolean'],
            'role_id' => ['sometimes', 'integer', 'exists:roles,id'],
        ]);
        $query = User::query()->with('role')->orderBy('id');
        if (isset($data['search'])) {
            $search = addcslashes($data['search'], '%_\\');
            $query->where(fn ($q) => $q->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orWhereHas('role', fn ($role) => $role->where('name', 'like', '%'.$search.'%')));
        }
        if (array_key_exists('is_active', $data)) {
            $query->where('is_active', (bool) $data['is_active']);
        }
        if (isset($data['role_id'])) {
            $query->where('role_id', $data['role_id']);
        }
        $page = $query->paginate($data['per_page'] ?? 25);
        return response()->json(['isSuccess' => true, 'data' => $page->through(fn (User $user) => $this->resource($user))]);
    }

    public function show(int $user): JsonResponse
    {
        return response()->json(['isSuccess' => true, 'data' => $this->resource(User::with('role')->findOrFail($user))]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:12', 'confirmed', PasswordRules::maximumBytes()],
            'role_id' => ['present', 'nullable', 'integer', Rule::exists('roles', 'id')],
        ]);
        $user = DB::transaction(function () use ($data) {
            $user = new User();
            $user->name = $data['name'];
            $user->email = strtolower(trim($data['email']));
            $user->password = $data['password'];
            $user->role_id = $data['role_id'];
            $user->is_superadmin = null;
            $user->is_active = true;
            $user->save();
            return $user->load('role');
        }, 3);
        return response()->json(['isSuccess' => true, 'data' => $this->resource($user)], 201);
    }

    public function update(Request $request, int $user): JsonResponse
    {
        $target = User::findOrFail($user);
        abort_if($target->is_superadmin, 403, 'El superadministrador no puede modificarse desde este módulo.');
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($target->id)],
            'role_id' => ['sometimes', 'nullable', 'integer', Rule::exists('roles', 'id')],
        ]);
        $target = DB::transaction(function () use ($user, $data) {
            $target = User::lockForUpdate()->findOrFail($user);
            abort_if($target->is_superadmin, 403);
            if (isset($data['name'])) $target->name = $data['name'];
            if (isset($data['email'])) $target->email = strtolower(trim($data['email']));
            if (array_key_exists('role_id', $data)) $target->role_id = $data['role_id'];
            $revoke = $target->isDirty('role_id') || $target->isDirty('email');
            if ($target->isDirty('email')) $target->email_verified_at = null;
            $target->save();
            if ($revoke) $this->tokens->revokeForUser($target->id);
            return $target->load('role');
        }, 3);
        return response()->json(['isSuccess' => true, 'data' => $this->resource($target)]);
    }

    public function setStatus(Request $request, int $user): JsonResponse
    {
        $data = $request->validate(['is_active' => ['required', 'boolean']]);
        $target = DB::transaction(function () use ($user, $data) {
            $target = User::lockForUpdate()->findOrFail($user);
            abort_if($target->is_superadmin, 403, 'No se puede suspender al superadministrador.');
            $target->is_active = $data['is_active'];
            $target->save();
            if (!$target->is_active) $this->tokens->revokeForUser($target->id);
            return $target->load('role');
        }, 3);
        return response()->json(['isSuccess' => true, 'data' => $this->resource($target)]);
    }

    private function resource(User $user): array
    {
        return [
            'id' => $user->id, 'name' => $user->name, 'email' => $user->email,
            'is_active' => (bool) $user->is_active, 'is_superadmin' => (bool) $user->is_superadmin,
            'role_id' => $user->role_id, 'role' => $user->role?->only(['id', 'name']),
            'created_at' => $user->created_at?->toIso8601String(),
        ];
    }
}
