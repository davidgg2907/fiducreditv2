<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldProductPolicyRequest;
use App\Http\Requests\UpdatePldProductPolicyRequest;
use App\Http\Resources\PldProductPolicyResource;
use App\Models\PldProductPolicy;

final class PldProductPolicyController extends DomainResourceController
{
    protected string $modelClass = PldProductPolicy::class;

    protected string $resourceClass = PldProductPolicyResource::class;

    protected string $storeRequestClass = StorePldProductPolicyRequest::class;

    protected string $updateRequestClass = UpdatePldProductPolicyRequest::class;

    protected bool $allowDirectWrites = true;
}
