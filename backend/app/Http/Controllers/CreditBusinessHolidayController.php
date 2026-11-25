<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditBusinessHolidayRequest;
use App\Http\Requests\UpdateCreditBusinessHolidayRequest;
use App\Http\Resources\CreditBusinessHolidayResource;
use App\Services\CreditBusinessHolidayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CreditBusinessHolidayController extends Controller
{
    public function __construct(private readonly CreditBusinessHolidayService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorizeAction($request, 'view');
        $query = $request->validate([
            'search' => ['sometimes', 'string', 'max:150'],
            'per_page' => ['sometimes', 'integer', 'between:1,100'],
            'sort' => ['sometimes', 'string', 'max:80'],
            'direction' => ['sometimes', 'in:asc,desc'],
            'include' => ['sometimes', 'string', 'max:500'],
            'filter' => ['sometimes', 'array'],
            'filter.*' => ['nullable', 'string', 'max:255'],
        ]);

        $records = CreditBusinessHolidayResource::collection($this->service->paginate($query));

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
            'data' => (new CreditBusinessHolidayResource(
                $this->service->find($id, $query['include'] ?? '')
            ))->resolve(),
        ]);
    }

    public function store(StoreCreditBusinessHolidayRequest $request): JsonResponse
    {
        $this->authorizeAction($request, 'write');
        

        abort(405, 'Registra las fechas desde el formulario de calendario.');
    }

    public function update(UpdateCreditBusinessHolidayRequest $request, string $id): JsonResponse
    {
        $this->authorizeAction($request, 'write');
        

        abort(405, 'Edita las fechas desde el formulario de calendario.');
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
