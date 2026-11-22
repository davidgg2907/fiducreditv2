<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldPolicyRequest;
use App\Http\Requests\UpdatePldPolicyRequest;
use App\Http\Resources\PldPolicyResource;
use App\Models\PldPolicy;

final class PldPolicyController extends DomainResourceController
{
    protected string $modelClass = PldPolicy::class;

    protected string $resourceClass = PldPolicyResource::class;

    protected string $storeRequestClass = StorePldPolicyRequest::class;

    protected string $updateRequestClass = UpdatePldPolicyRequest::class;

    protected bool $allowDirectWrites = true;
}
