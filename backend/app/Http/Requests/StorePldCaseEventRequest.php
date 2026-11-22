<?php

namespace App\Http\Requests;

use App\Models\PldCaseEvent;

final class StorePldCaseEventRequest extends DomainWriteRequest
{
    protected string $modelClass = PldCaseEvent::class;
}
