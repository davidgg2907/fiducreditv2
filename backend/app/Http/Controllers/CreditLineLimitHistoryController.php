<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditLineLimitHistoryRequest;
use App\Http\Requests\UpdateCreditLineLimitHistoryRequest;
use App\Http\Resources\CreditLineLimitHistoryResource;
use App\Models\CreditLineLimitHistory;

final class CreditLineLimitHistoryController extends DomainResourceController
{
    protected string $modelClass = CreditLineLimitHistory::class;

    protected string $resourceClass = CreditLineLimitHistoryResource::class;

    protected string $storeRequestClass = StoreCreditLineLimitHistoryRequest::class;

    protected string $updateRequestClass = UpdateCreditLineLimitHistoryRequest::class;

    protected bool $allowDirectWrites = false;
}
