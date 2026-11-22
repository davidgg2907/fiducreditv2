<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldPolicyVersionRequest;
use App\Http\Requests\UpdatePldPolicyVersionRequest;
use App\Http\Resources\PldPolicyVersionResource;
use App\Models\PldPolicyVersion;

final class PldPolicyVersionController extends DomainResourceController
{
    protected string $modelClass = PldPolicyVersion::class;

    protected string $resourceClass = PldPolicyVersionResource::class;

    protected string $storeRequestClass = StorePldPolicyVersionRequest::class;

    protected string $updateRequestClass = UpdatePldPolicyVersionRequest::class;

    protected bool $allowDirectWrites = true;
}
