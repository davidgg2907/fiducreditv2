<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldPolicyVersionRequest;
use App\Http\Requests\Domain\UpdatePldPolicyVersionRequest;
use App\Http\Resources\Domain\PldPolicyVersionResource;
use App\Models\Domain\PldPolicyVersion;

final class PldPolicyVersionController extends DomainResourceController
{
    protected string $modelClass = PldPolicyVersion::class;

    protected string $resourceClass = PldPolicyVersionResource::class;

    protected string $storeRequestClass = StorePldPolicyVersionRequest::class;

    protected string $updateRequestClass = UpdatePldPolicyVersionRequest::class;

    protected bool $allowDirectWrites = true;
}
