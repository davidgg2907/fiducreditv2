<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditLoanEventRequest;
use App\Http\Requests\UpdateCreditLoanEventRequest;
use App\Http\Resources\CreditLoanEventResource;
use App\Models\CreditLoanEvent;

final class CreditLoanEventController extends DomainResourceController
{
    protected string $modelClass = CreditLoanEvent::class;

    protected string $resourceClass = CreditLoanEventResource::class;

    protected string $storeRequestClass = StoreCreditLoanEventRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanEventRequest::class;

    protected bool $allowDirectWrites = false;
}
