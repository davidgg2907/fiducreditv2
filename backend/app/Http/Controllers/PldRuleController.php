<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldRuleRequest;
use App\Http\Requests\UpdatePldRuleRequest;
use App\Http\Resources\PldRuleResource;
use App\Models\PldRule;

final class PldRuleController extends DomainResourceController
{
    protected string $modelClass = PldRule::class;

    protected string $resourceClass = PldRuleResource::class;

    protected string $storeRequestClass = StorePldRuleRequest::class;

    protected string $updateRequestClass = UpdatePldRuleRequest::class;

    protected bool $allowDirectWrites = true;
}
