<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldMonitoringEventRequest;
use App\Http\Requests\UpdatePldMonitoringEventRequest;
use App\Http\Resources\PldMonitoringEventResource;
use App\Models\PldMonitoringEvent;

final class PldMonitoringEventController extends DomainResourceController
{
    protected string $modelClass = PldMonitoringEvent::class;

    protected string $resourceClass = PldMonitoringEventResource::class;

    protected string $storeRequestClass = StorePldMonitoringEventRequest::class;

    protected string $updateRequestClass = UpdatePldMonitoringEventRequest::class;

    protected bool $allowDirectWrites = false;
}
