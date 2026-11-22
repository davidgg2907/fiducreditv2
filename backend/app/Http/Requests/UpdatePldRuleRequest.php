<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldRule;

final class UpdatePldRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = PldRule::class;
}
