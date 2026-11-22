<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldCaseEvent;

final class UpdatePldCaseEventRequest extends DomainWriteRequest
{
    protected string $modelClass = PldCaseEvent::class;
}
