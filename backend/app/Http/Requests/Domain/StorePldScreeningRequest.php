<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldScreening;

final class StorePldScreeningRequest extends DomainWriteRequest
{
    protected string $modelClass = PldScreening::class;
}
