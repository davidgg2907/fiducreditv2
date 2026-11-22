<?php

namespace App\Http\Requests;

use App\Models\PldScreening;

final class UpdatePldScreeningRequest extends DomainWriteRequest
{
    protected string $modelClass = PldScreening::class;
}
