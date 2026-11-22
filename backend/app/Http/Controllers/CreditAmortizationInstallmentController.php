<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditAmortizationInstallmentRequest;
use App\Http\Requests\UpdateCreditAmortizationInstallmentRequest;
use App\Http\Resources\CreditAmortizationInstallmentResource;
use App\Services\CreditAmortizationInstallmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CreditAmortizationInstallmentController extends Controller
{
    public function __construct(private readonly CreditAmortizationInstallmentService $service)
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

        $records = CreditAmortizationInstallmentResource::collection($this->service->paginate($query));

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
            'data' => (new CreditAmortizationInstallmentResource(
                $this->service->find($id, $query['include'] ?? '')
            ))->resolve(),
        ]);
    }

    public function store(StoreCreditAmortizationInstallmentRequest $request): JsonResponse
    {
        $this->authorizeAction($request, 'write');
        abort(405, 'Requiere una operación transaccional especializada.');

        $record = $this->service->create($request->validated());

        return response()->json([
            'isSuccess' => true,
            'data' => (new CreditAmortizationInstallmentResource($record))->resolve(),
        ], 201);
    }

    public function update(UpdateCreditAmortizationInstallmentRequest $request, string $id): JsonResponse
    {
        $this->authorizeAction($request, 'write');
        abort(405, 'Requiere una operación transaccional especializada.');

        $record = $this->service->update($id, $request->validated());

        return response()->json([
            'isSuccess' => true,
            'data' => (new CreditAmortizationInstallmentResource($record))->resolve(),
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
