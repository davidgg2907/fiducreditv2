<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldCase;

final class UpdatePldCaseRequest extends DomainWriteRequest
{
    protected string $modelClass = PldCase::class;
}
