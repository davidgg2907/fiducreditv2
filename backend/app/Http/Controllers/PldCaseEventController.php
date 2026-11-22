<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldCaseEventRequest;
use App\Http\Requests\UpdatePldCaseEventRequest;
use App\Http\Resources\PldCaseEventResource;
use App\Models\PldCaseEvent;

final class PldCaseEventController extends DomainResourceController
{
    protected string $modelClass = PldCaseEvent::class;

    protected string $resourceClass = PldCaseEventResource::class;

    protected string $storeRequestClass = StorePldCaseEventRequest::class;

    protected string $updateRequestClass = UpdatePldCaseEventRequest::class;

    protected bool $allowDirectWrites = false;
}
