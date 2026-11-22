<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldRule;

final class StorePldRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = PldRule::class;
}
