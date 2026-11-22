<?php

namespace App\Http\Requests;

use App\Models\PldAlertAction;

final class StorePldAlertActionRequest extends DomainWriteRequest
{
    protected string $modelClass = PldAlertAction::class;
}
