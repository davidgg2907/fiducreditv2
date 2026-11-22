<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditApplicationFinancialItemRequest;
use App\Http\Requests\Domain\UpdateCreditApplicationFinancialItemRequest;
use App\Http\Resources\Domain\CreditApplicationFinancialItemResource;
use App\Models\Domain\CreditApplicationFinancialItem;

final class CreditApplicationFinancialItemController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationFinancialItem::class;

    protected string $resourceClass = CreditApplicationFinancialItemResource::class;

    protected string $storeRequestClass = StoreCreditApplicationFinancialItemRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationFinancialItemRequest::class;

    protected bool $allowDirectWrites = true;
}
