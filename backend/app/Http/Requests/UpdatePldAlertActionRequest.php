<?php

namespace App\Http\Requests;

use App\Models\PldAlertAction;

final class UpdatePldAlertActionRequest extends DomainWriteRequest
{
    protected string $modelClass = PldAlertAction::class;
}
