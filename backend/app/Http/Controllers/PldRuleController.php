<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldRuleRequest;
use App\Http\Requests\Domain\UpdatePldRuleRequest;
use App\Http\Resources\Domain\PldRuleResource;
use App\Models\Domain\PldRule;

final class PldRuleController extends DomainResourceController
{
    protected string $modelClass = PldRule::class;

    protected string $resourceClass = PldRuleResource::class;

    protected string $storeRequestClass = StorePldRuleRequest::class;

    protected string $updateRequestClass = UpdatePldRuleRequest::class;

    protected bool $allowDirectWrites = true;
}
