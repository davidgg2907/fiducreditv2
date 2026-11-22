<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldCaseEventRequest;
use App\Http\Requests\Domain\UpdatePldCaseEventRequest;
use App\Http\Resources\Domain\PldCaseEventResource;
use App\Models\Domain\PldCaseEvent;

final class PldCaseEventController extends DomainResourceController
{
    protected string $modelClass = PldCaseEvent::class;

    protected string $resourceClass = PldCaseEventResource::class;

    protected string $storeRequestClass = StorePldCaseEventRequest::class;

    protected string $updateRequestClass = UpdatePldCaseEventRequest::class;

    protected bool $allowDirectWrites = false;
}
