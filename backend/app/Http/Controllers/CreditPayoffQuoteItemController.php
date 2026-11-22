<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditPayoffQuoteItemRequest;
use App\Http\Requests\UpdateCreditPayoffQuoteItemRequest;
use App\Http\Resources\CreditPayoffQuoteItemResource;
use App\Models\CreditPayoffQuoteItem;

final class CreditPayoffQuoteItemController extends DomainResourceController
{
    protected string $modelClass = CreditPayoffQuoteItem::class;

    protected string $resourceClass = CreditPayoffQuoteItemResource::class;

    protected string $storeRequestClass = StoreCreditPayoffQuoteItemRequest::class;

    protected string $updateRequestClass = UpdateCreditPayoffQuoteItemRequest::class;

    protected bool $allowDirectWrites = false;
}
