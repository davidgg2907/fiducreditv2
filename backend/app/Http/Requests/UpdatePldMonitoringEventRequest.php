<?php

namespace App\Http\Requests;

use App\Models\PldMonitoringEvent;

final class UpdatePldMonitoringEventRequest extends DomainWriteRequest
{
    protected string $modelClass = PldMonitoringEvent::class;
}
