<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldPolicyRequest;
use App\Http\Requests\Domain\UpdatePldPolicyRequest;
use App\Http\Resources\Domain\PldPolicyResource;
use App\Models\Domain\PldPolicy;

final class PldPolicyController extends DomainResourceController
{
    protected string $modelClass = PldPolicy::class;

    protected string $resourceClass = PldPolicyResource::class;

    protected string $storeRequestClass = StorePldPolicyRequest::class;

    protected string $updateRequestClass = UpdatePldPolicyRequest::class;

    protected bool $allowDirectWrites = true;
}
