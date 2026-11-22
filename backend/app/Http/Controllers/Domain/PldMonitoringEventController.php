<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldMonitoringEventRequest;
use App\Http\Requests\Domain\UpdatePldMonitoringEventRequest;
use App\Http\Resources\Domain\PldMonitoringEventResource;
use App\Models\Domain\PldMonitoringEvent;

final class PldMonitoringEventController extends DomainResourceController
{
    protected string $modelClass = PldMonitoringEvent::class;

    protected string $resourceClass = PldMonitoringEventResource::class;

    protected string $storeRequestClass = StorePldMonitoringEventRequest::class;

    protected string $updateRequestClass = UpdatePldMonitoringEventRequest::class;

    protected bool $allowDirectWrites = false;
}
