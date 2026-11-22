<?php

namespace App\Http\Requests;

use App\Models\PldCaseEvent;

final class UpdatePldCaseEventRequest extends DomainWriteRequest
{
    protected string $modelClass = PldCaseEvent::class;
}
