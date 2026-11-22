<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditPayoffQuoteRequest;
use App\Http\Requests\UpdateCreditPayoffQuoteRequest;
use App\Http\Resources\CreditPayoffQuoteResource;
use App\Models\CreditPayoffQuote;

final class CreditPayoffQuoteController extends DomainResourceController
{
    protected string $modelClass = CreditPayoffQuote::class;

    protected string $resourceClass = CreditPayoffQuoteResource::class;

    protected string $storeRequestClass = StoreCreditPayoffQuoteRequest::class;

    protected string $updateRequestClass = UpdateCreditPayoffQuoteRequest::class;

    protected bool $allowDirectWrites = false;
}
