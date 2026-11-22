<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationFieldRequest;
use App\Http\Requests\UpdateCreditApplicationFieldRequest;
use App\Http\Resources\CreditApplicationFieldResource;
use App\Services\CreditApplicationFieldService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CreditApplicationFieldController extends Controller
{
    public function __construct(private readonly CreditApplicationFieldService $service)
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

        $records = CreditApplicationFieldResource::collection($this->service->paginate($query));

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
            'data' => (new CreditApplicationFieldResource(
                $this->service->find($id, $query['include'] ?? '')
            ))->resolve(),
        ]);
    }

    public function store(StoreCreditApplicationFieldRequest $request): JsonResponse
    {
        $this->authorizeAction($request, 'write');
        

        $record = $this->service->create($request->validated());

        return response()->json([
            'isSuccess' => true,
            'data' => (new CreditApplicationFieldResource($record))->resolve(),
        ], 201);
    }

    public function update(UpdateCreditApplicationFieldRequest $request, string $id): JsonResponse
    {
        $this->authorizeAction($request, 'write');
        

        $record = $this->service->update($id, $request->validated());

        return response()->json([
            'isSuccess' => true,
            'data' => (new CreditApplicationFieldResource($record))->resolve(),
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
        
    }
}
