<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldMonitoringEventRequest;
use App\Http\Requests\UpdatePldMonitoringEventRequest;
use App\Http\Resources\PldMonitoringEventResource;
use App\Services\PldMonitoringEventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PldMonitoringEventController extends Controller
{
    public function __construct(private readonly PldMonitoringEventService $service)
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

        $records = PldMonitoringEventResource::collection($this->service->paginate($query));

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
            'data' => (new PldMonitoringEventResource(
                $this->service->find($id, $query['include'] ?? '')
            ))->resolve(),
        ]);
    }

    public function store(StorePldMonitoringEventRequest $request): JsonResponse
    {
        $this->authorizeAction($request, 'write');
        

        abort(405, 'Requiere servicio transaccional especializado.');

        $record = $this->service->create($request->validated());

        return response()->json([
            'isSuccess' => true,
            'data' => (new PldMonitoringEventResource($record))->resolve(),
        ], 201);
    }

    public function update(UpdatePldMonitoringEventRequest $request, string $id): JsonResponse
    {
        $this->authorizeAction($request, 'write');
        

        abort(405, 'Requiere servicio transaccional especializado.');

        $record = $this->service->update($id, $request->validated());

        return response()->json([
            'isSuccess' => true,
            'data' => (new PldMonitoringEventResource($record))->resolve(),
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
