<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationEventRequest;
use App\Http\Requests\UpdateCreditApplicationEventRequest;
use App\Http\Resources\CreditApplicationEventResource;
use App\Models\CreditApplicationEvent;

final class CreditApplicationEventController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationEvent::class;

    protected string $resourceClass = CreditApplicationEventResource::class;

    protected string $storeRequestClass = StoreCreditApplicationEventRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationEventRequest::class;

    protected bool $allowDirectWrites = false;
}
