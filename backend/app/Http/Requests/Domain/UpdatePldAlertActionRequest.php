<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldAlertAction;

final class UpdatePldAlertActionRequest extends DomainWriteRequest
{
    protected string $modelClass = PldAlertAction::class;
}
