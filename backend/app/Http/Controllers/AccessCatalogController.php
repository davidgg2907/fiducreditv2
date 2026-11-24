<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

final class AccessCatalogController extends Controller
{
    public function modules(Request $request): JsonResponse
    {
        $data = $request->validate(['search' => ['sometimes','string','max:150'], 'per_page' => ['sometimes','integer','between:1,100']]);
        $query = DB::table('access_modules');
        if (!empty($data['search'])) {
            $value = '%'.addcslashes(trim($data['search']), '%_\\').'%';
            $query->where(function ($q) use ($value) {
                $q->where('name','like',$value)->orWhere('code','like',$value)
                  ->orWhereExists(fn ($r) => $r->selectRaw('1')->from('module_actions')->whereColumn('module_actions.module_id','access_modules.id')->where('module_actions.name','like',$value));
            });
        }
        return response()->json(['isSuccess' => true, 'data' => $query->orderBy('code')->paginate($data['per_page'] ?? 25)]);
    }

    public function storeModule(Request $request): JsonResponse
    {
        $data = $request->validate(['code' => ['required', 'string', 'max:80', 'alpha_dash', 'unique:access_modules,code'],
            'name' => ['required', 'string', 'max:100']]);
        $id = DB::table('access_modules')->insertGetId($data);
        return response()->json(['isSuccess' => true, 'data' => DB::table('access_modules')->find($id)], 201);
    }

    public function updateModule(Request $request, int $module): JsonResponse
    {
        abort_unless(DB::table('access_modules')->where('id', $module)->exists(), 404);
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:100'],
            'code' => ['sometimes', 'required', 'string', 'alpha_dash', 'max:80', Rule::unique('access_modules', 'code')->ignore($module)],
        ]);
        DB::table('access_modules')->where('id', $module)->update($data);
        return response()->json(['isSuccess' => true, 'data' => DB::table('access_modules')->find($module)]);
    }

    public function deleteModule(int $module): JsonResponse
    {
        abort_unless(DB::table('access_modules')->where('id', $module)->exists(), 404);
        if (DB::table('module_actions')->where('module_id', $module)->exists()) {
            throw ValidationException::withMessages(['module' => 'No se puede eliminar un módulo con acciones.']);
        }
        DB::table('access_modules')->where('id', $module)->delete();
        return response()->json(['isSuccess' => true]);
    }

    public function actions(Request $request): JsonResponse
    {
        $data = $request->validate(['search' => ['sometimes','string','max:150'], 'per_page' => ['sometimes','integer','between:1,100']]);
        $query = DB::table('module_actions');
        if (!empty($data['search'])) {
            $value = '%'.addcslashes(trim($data['search']), '%_\\').'%';
            $query->where(function ($q) use ($value) {
                $q->where('name','like',$value)->orWhere('permission','like',$value)
                  ->orWhereExists(fn ($r) => $r->selectRaw('1')->from('access_modules')->whereColumn('access_modules.id','module_actions.module_id')->where('access_modules.name','like',$value));
            });
        }
        return response()->json(['isSuccess' => true, 'data' => $query->orderBy('permission')->paginate($data['per_page'] ?? 25)]);
    }

    public function storeAction(Request $request): JsonResponse
    {
        $data = $request->validate([
            'module_id' => ['required', 'integer', Rule::exists('access_modules', 'id')],
            'permission' => ['required', 'string', 'max:160', 'regex:/\A[a-z][a-z0-9.-]*\z/', 'unique:module_actions,permission'],
            'name' => ['required', 'string', 'max:100'],
        ]);
        $id = DB::table('module_actions')->insertGetId($data);
        return response()->json(['isSuccess' => true, 'data' => DB::table('module_actions')->find($id)], 201);
    }

    public function updateAction(Request $request, int $action): JsonResponse
    {
        abort_unless(DB::table('module_actions')->where('id', $action)->exists(), 404);
        // Permission identifiers are immutable because roles store exact keys in JSON.
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:100'],
            'module_id' => ['sometimes', 'required', 'integer', Rule::exists('access_modules', 'id')],
        ]);
        DB::table('module_actions')->where('id', $action)->update($data);
        return response()->json(['isSuccess' => true, 'data' => DB::table('module_actions')->find($action)]);
    }

    public function deleteAction(int $action): JsonResponse
    {
        $permission = DB::table('module_actions')->where('id', $action)->value('permission');
        abort_if($permission === null, 404);
        if (DB::table('menu_items')->where('module_action_id', $action)->exists()) {
            throw ValidationException::withMessages(['action' => 'La acción está ligada a una opción del menú.']);
        }
        foreach (\App\Models\Role::query()->get(['permissions']) as $role) {
            if (in_array($permission, $role->permissions ?? [], true)) {
                throw ValidationException::withMessages(['action' => 'La acción está asignada a un rol.']);
            }
        }
        DB::table('module_actions')->where('id', $action)->delete();
        return response()->json(['isSuccess' => true]);
    }

    public function menus(Request $request): JsonResponse
    {
        $data = $request->validate(['search' => ['sometimes','string','max:150'], 'per_page' => ['sometimes','integer','between:1,100']]);
        $query = DB::table('menu_items');
        if (!empty($data['search'])) {
            $value = '%'.addcslashes(trim($data['search']), '%_\\').'%';
            $query->where(function ($q) use ($value) {
                $q->where('code','like',$value)->orWhere('label','like',$value)->orWhere('route','like',$value)
                  ->orWhere('app_code','like',$value)
                  ->orWhereExists(fn ($r) => $r->selectRaw('1')->from('module_actions')->whereColumn('module_actions.id','menu_items.module_action_id')->where('module_actions.name','like',$value));
            });
        }
        return response()->json(['isSuccess' => true, 'data' => $query->orderBy('position')->orderBy('id')->paginate($data['per_page'] ?? 25)]);
    }

    public function storeMenu(Request $request): JsonResponse
    {
        $data = $this->validateMenu($request);
        $id = DB::table('menu_items')->insertGetId($data);
        return response()->json(['isSuccess' => true, 'data' => DB::table('menu_items')->find($id)], 201);
    }

    public function updateMenu(Request $request, int $menu): JsonResponse
    {
        abort_unless(DB::table('menu_items')->where('id', $menu)->exists(), 404);
        $data = $this->validateMenu($request, $menu);
        DB::transaction(function () use ($menu, $data) {
            if (array_key_exists('parent_id', $data) && $data['parent_id'] !== null) {
                $cursor = $data['parent_id'];
                $seen = [];
                while ($cursor !== null) {
                    if ($cursor === $menu || isset($seen[$cursor])) {
                        throw ValidationException::withMessages(['parent_id' => 'La jerarquía del menú no puede contener ciclos.']);
                    }
                    $seen[$cursor] = true;
                    $cursor = DB::table('menu_items')->where('id', $cursor)->value('parent_id');
                }
            }
            DB::table('menu_items')->where('id', $menu)->update($data);
        }, 3);
        return response()->json(['isSuccess' => true, 'data' => DB::table('menu_items')->find($menu)]);
    }

    public function deleteMenu(int $menu): JsonResponse
    {
        abort_unless(DB::table('menu_items')->where('id', $menu)->exists(), 404);
        if (DB::table('menu_items')->where('parent_id', $menu)->exists()) {
            throw ValidationException::withMessages(['menu' => 'No se puede eliminar un menú con opciones hijas.']);
        }
        DB::table('menu_items')->where('id', $menu)->delete();
        return response()->json(['isSuccess' => true]);
    }

    private function validateMenu(Request $request, ?int $id = null): array
    {
        $required = $id === null ? 'required' : 'sometimes';
        return $request->validate([
            'code' => [$required, 'string', 'max:100', 'alpha_dash', Rule::unique('menu_items', 'code')->ignore($id)],
            'label' => [$required, 'string', 'max:100'],
            'parent_id' => ['sometimes', 'nullable', 'integer', Rule::exists('menu_items', 'id')],
            'module_action_id' => ['sometimes', 'nullable', 'integer', Rule::exists('module_actions', 'id')],
            'route' => ['sometimes', 'nullable', 'string', 'max:255', 'regex:/\A\/(?!\/)[a-zA-Z0-9_\/\-]*\z/'],
            'icon' => ['sometimes', 'nullable', 'string', 'max:80'],
            'position' => ['sometimes', 'integer', 'min:0', 'max:100000'],
            'app_code' => ['sometimes', 'nullable', Rule::in(['originacion', 'administracion', 'pld-operacion', 'pld-configuracion', 'configuracion-sistema'])],
        ]);
    }
}
