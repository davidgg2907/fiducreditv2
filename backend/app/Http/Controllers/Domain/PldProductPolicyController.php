<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldProductPolicyRequest;
use App\Http\Requests\Domain\UpdatePldProductPolicyRequest;
use App\Http\Resources\Domain\PldProductPolicyResource;
use App\Models\Domain\PldProductPolicy;

final class PldProductPolicyController extends DomainResourceController
{
    protected string $modelClass = PldProductPolicy::class;

    protected string $resourceClass = PldProductPolicyResource::class;

    protected string $storeRequestClass = StorePldProductPolicyRequest::class;

    protected string $updateRequestClass = UpdatePldProductPolicyRequest::class;

    protected bool $allowDirectWrites = true;
}
