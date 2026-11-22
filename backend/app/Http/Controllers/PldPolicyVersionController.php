<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldPolicyVersionRequest;
use App\Http\Requests\UpdatePldPolicyVersionRequest;
use App\Http\Resources\PldPolicyVersionResource;
use App\Services\PldPolicyVersionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PldPolicyVersionController extends Controller
{
    public function __construct(private readonly PldPolicyVersionService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorizeAction($request, 'view');
        $query = $request->validate([
            'per_page' => ['sometimes', 'integer', 'between:1,100'],
            'sort' => ['sometimes', 'string', 'max:80'],
            'direction' => ['sometimes', 'in:asc,desc'],
            'include' => ['sometimes', 'string', 'max:500'],
            'filter' => ['sometimes', 'array'],
            'filter.*' => ['nullable', 'string', 'max:255'],
        ]);

        $records = PldPolicyVersionResource::collection($this->service->paginate($query));

        return response()->json([
            'isSuccess' => true,
            'data' => $records->response()->getData(true),
        ]);
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $this->authorizeAction($request, 'view');
        $query = $request->validate([
            'include' => ['sometimes', 'string', 'max:500'],
        ]);

        return response()->json([
            'isSuccess' => true,
            'data' => (new PldPolicyVersionResource(
                $this->service->find($id, $query['include'] ?? '')
            ))->resolve(),
        ]);
    }

    public function store(StorePldPolicyVersionRequest $request): JsonResponse
    {
        $this->authorizeAction($request, 'write');
        

        $record = $this->service->create($request->validated());

        return response()->json([
            'isSuccess' => true,
            'data' => (new PldPolicyVersionResource($record))->resolve(),
        ], 201);
    }

    public function update(UpdatePldPolicyVersionRequest $request, string $id): JsonResponse
    {
        $this->authorizeAction($request, 'write');
        

        $record = $this->service->update($id, $request->validated());

        return response()->json([
            'isSuccess' => true,
            'data' => (new PldPolicyVersionResource($record))->resolve(),
        ]);
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $this->authorizeAction($request, 'write');

        abort(405, 'Eliminación física deshabilitada para proteger el historial.');
    }

    private function authorizeAction(Request $request, string $operation): void
    {
        $user = $request->user();
        abort_unless($user?->is_superadmin === true, 403);

        abort_unless(
            in_array('pld-data.'.$operation, $user->permissions(), true),
            403,
            'Requiere permiso específico de cumplimiento.'
        );
        
    }
}
