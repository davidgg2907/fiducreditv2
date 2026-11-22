<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationStatusHistoryRequest;
use App\Http\Requests\UpdateCreditApplicationStatusHistoryRequest;
use App\Http\Resources\CreditApplicationStatusHistoryResource;
use App\Models\CreditApplicationStatusHistory;

final class CreditApplicationStatusHistoryController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationStatusHistory::class;

    protected string $resourceClass = CreditApplicationStatusHistoryResource::class;

    protected string $storeRequestClass = StoreCreditApplicationStatusHistoryRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationStatusHistoryRequest::class;

    protected bool $allowDirectWrites = false;
}
