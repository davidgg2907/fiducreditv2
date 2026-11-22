<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditPayoffQuoteRequest;
use App\Http\Requests\Domain\UpdateCreditPayoffQuoteRequest;
use App\Http\Resources\Domain\CreditPayoffQuoteResource;
use App\Models\Domain\CreditPayoffQuote;

final class CreditPayoffQuoteController extends DomainResourceController
{
    protected string $modelClass = CreditPayoffQuote::class;

    protected string $resourceClass = CreditPayoffQuoteResource::class;

    protected string $storeRequestClass = StoreCreditPayoffQuoteRequest::class;

    protected string $updateRequestClass = UpdateCreditPayoffQuoteRequest::class;

    protected bool $allowDirectWrites = false;
}
