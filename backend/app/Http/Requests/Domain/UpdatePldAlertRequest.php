<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldAlert;

final class UpdatePldAlertRequest extends DomainWriteRequest
{
    protected string $modelClass = PldAlert::class;
}
