<?php

namespace App\Http\Requests;

use App\Models\PldCase;

final class StorePldCaseRequest extends DomainWriteRequest
{
    protected string $modelClass = PldCase::class;
}
