<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditLineLimitHistoryRequest;
use App\Http\Requests\Domain\UpdateCreditLineLimitHistoryRequest;
use App\Http\Resources\Domain\CreditLineLimitHistoryResource;
use App\Models\Domain\CreditLineLimitHistory;

final class CreditLineLimitHistoryController extends DomainResourceController
{
    protected string $modelClass = CreditLineLimitHistory::class;

    protected string $resourceClass = CreditLineLimitHistoryResource::class;

    protected string $storeRequestClass = StoreCreditLineLimitHistoryRequest::class;

    protected string $updateRequestClass = UpdateCreditLineLimitHistoryRequest::class;

    protected bool $allowDirectWrites = false;
}
