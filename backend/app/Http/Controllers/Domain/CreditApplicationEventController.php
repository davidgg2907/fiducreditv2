<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditApplicationEventRequest;
use App\Http\Requests\Domain\UpdateCreditApplicationEventRequest;
use App\Http\Resources\Domain\CreditApplicationEventResource;
use App\Models\Domain\CreditApplicationEvent;

final class CreditApplicationEventController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationEvent::class;

    protected string $resourceClass = CreditApplicationEventResource::class;

    protected string $storeRequestClass = StoreCreditApplicationEventRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationEventRequest::class;

    protected bool $allowDirectWrites = false;
}
