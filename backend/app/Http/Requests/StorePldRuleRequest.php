<?php

namespace App\Http\Requests;

use App\Models\PldRule;

final class StorePldRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = PldRule::class;
}
