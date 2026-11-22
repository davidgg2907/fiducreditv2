<?php

namespace App\Http\Requests;

use App\Models\PldCase;

final class UpdatePldCaseRequest extends DomainWriteRequest
{
    protected string $modelClass = PldCase::class;
}
