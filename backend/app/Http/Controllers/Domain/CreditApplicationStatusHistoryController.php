<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditApplicationStatusHistoryRequest;
use App\Http\Requests\Domain\UpdateCreditApplicationStatusHistoryRequest;
use App\Http\Resources\Domain\CreditApplicationStatusHistoryResource;
use App\Models\Domain\CreditApplicationStatusHistory;

final class CreditApplicationStatusHistoryController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationStatusHistory::class;

    protected string $resourceClass = CreditApplicationStatusHistoryResource::class;

    protected string $storeRequestClass = StoreCreditApplicationStatusHistoryRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationStatusHistoryRequest::class;

    protected bool $allowDirectWrites = false;
}
