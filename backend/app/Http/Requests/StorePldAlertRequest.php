<?php

namespace App\Http\Requests;

use App\Models\PldAlert;

final class StorePldAlertRequest extends DomainWriteRequest
{
    protected string $modelClass = PldAlert::class;
}
