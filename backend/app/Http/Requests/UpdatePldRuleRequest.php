<?php

namespace App\Http\Requests;

use App\Models\PldRule;

final class UpdatePldRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = PldRule::class;
}
