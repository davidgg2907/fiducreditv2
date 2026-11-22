<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditLoanEventRequest;
use App\Http\Requests\Domain\UpdateCreditLoanEventRequest;
use App\Http\Resources\Domain\CreditLoanEventResource;
use App\Models\Domain\CreditLoanEvent;

final class CreditLoanEventController extends DomainResourceController
{
    protected string $modelClass = CreditLoanEvent::class;

    protected string $resourceClass = CreditLoanEventResource::class;

    protected string $storeRequestClass = StoreCreditLoanEventRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanEventRequest::class;

    protected bool $allowDirectWrites = false;
}
