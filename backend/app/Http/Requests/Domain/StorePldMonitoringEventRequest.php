<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldMonitoringEvent;

final class StorePldMonitoringEventRequest extends DomainWriteRequest
{
    protected string $modelClass = PldMonitoringEvent::class;
}
