<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Services\Domain\DomainCrudService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class DomainResourceController extends Controller
{
    protected string $modelClass;

    protected string $resourceClass;

    protected string $storeRequestClass;

    protected string $updateRequestClass;

    protected bool $allowDirectWrites = false;

    protected function service(): DomainCrudService
    {
        $serviceClass = 'App\\Services\\Domain\\'
            .class_basename($this->modelClass).'Service';

        return app($serviceClass);
    }

    private function authorizeDomain(string $operation): void
    {
        $user = request()->user();

        abort_unless(
            $user?->is_superadmin === true,
            403,
            'El acceso al dominio exige autorización administrativa.'
        );

        $table = (new $this->modelClass())->getTable();

        if (str_starts_with($table, 'pld_')) {
            abort_unless(
                in_array('pld-data.'.$operation, $user->permissions(), true),
                403,
                'El permiso de cumplimiento es obligatorio.'
            );
        }
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorizeDomain('view');

        $query = $request->validate([
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'between:1,100'],
            'sort' => ['sometimes', 'string', 'max:80'],
            'direction' => ['sometimes', 'in:asc,desc'],
            'filter' => ['sometimes', 'array'],
            'filter.*' => ['nullable', 'string', 'max:255'],
            'include' => ['sometimes', 'string', 'max:500'],
        ]);

        $result = $this->resourceClass::collection(
            $this->service()->paginate($this->modelClass, $query)
        );

        return response()->json([
            'isSuccess' => true,
            'data' => $result->response()->getData(true),
        ]);
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $this->authorizeDomain('view');

        $query = $request->validate([
            'include' => ['sometimes', 'string', 'max:500'],
        ]);

        $model = $this->service()->find(
            $this->modelClass,
            $id,
            $query['include'] ?? ''
        );

        return response()->json([
            'isSuccess' => true,
            'data' => (new $this->resourceClass($model))->resolve(),
        ]);
    }

    public function store(): JsonResponse
    {
        $this->authorizeDomain('write');
        abort_unless($this->allowDirectWrites, 405);

        $data = app($this->storeRequestClass)->validated();
        $model = $this->service()->create($this->modelClass, $data);

        return response()->json([
            'isSuccess' => true,
            'data' => (new $this->resourceClass($model))->resolve(),
        ], 201);
    }

    public function update(string $id): JsonResponse
    {
        $this->authorizeDomain('write');
        abort_unless($this->allowDirectWrites, 405);

        $data = app($this->updateRequestClass)->validated();
        $model = $this->service()->update($this->modelClass, $id, $data);

        return response()->json([
            'isSuccess' => true,
            'data' => (new $this->resourceClass($model))->resolve(),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->authorizeDomain('write');

        abort(405, 'El borrado físico se encuentra deshabilitado.');
    }
}
