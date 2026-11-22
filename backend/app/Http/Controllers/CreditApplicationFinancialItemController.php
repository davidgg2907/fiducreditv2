<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationFinancialItemRequest;
use App\Http\Requests\UpdateCreditApplicationFinancialItemRequest;
use App\Http\Resources\CreditApplicationFinancialItemResource;
use App\Models\CreditApplicationFinancialItem;

final class CreditApplicationFinancialItemController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationFinancialItem::class;

    protected string $resourceClass = CreditApplicationFinancialItemResource::class;

    protected string $storeRequestClass = StoreCreditApplicationFinancialItemRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationFinancialItemRequest::class;

    protected bool $allowDirectWrites = true;
}
