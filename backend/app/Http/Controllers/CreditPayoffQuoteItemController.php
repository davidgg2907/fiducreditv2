<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditPayoffQuoteItemRequest;
use App\Http\Requests\Domain\UpdateCreditPayoffQuoteItemRequest;
use App\Http\Resources\Domain\CreditPayoffQuoteItemResource;
use App\Models\Domain\CreditPayoffQuoteItem;

final class CreditPayoffQuoteItemController extends DomainResourceController
{
    protected string $modelClass = CreditPayoffQuoteItem::class;

    protected string $resourceClass = CreditPayoffQuoteItemResource::class;

    protected string $storeRequestClass = StoreCreditPayoffQuoteItemRequest::class;

    protected string $updateRequestClass = UpdateCreditPayoffQuoteItemRequest::class;

    protected bool $allowDirectWrites = false;
}
