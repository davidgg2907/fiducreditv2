<?php

namespace App\Http\Requests;

use App\Models\PldScreening;

final class StorePldScreeningRequest extends DomainWriteRequest
{
    protected string $modelClass = PldScreening::class;
}
