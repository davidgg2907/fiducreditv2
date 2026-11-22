<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldBeneficialOwnerRequest;
use App\Http\Requests\UpdatePldBeneficialOwnerRequest;
use App\Http\Resources\PldBeneficialOwnerResource;
use App\Models\PldBeneficialOwner;

final class PldBeneficialOwnerController extends DomainResourceController
{
    protected string $modelClass = PldBeneficialOwner::class;

    protected string $resourceClass = PldBeneficialOwnerResource::class;

    protected string $storeRequestClass = StorePldBeneficialOwnerRequest::class;

    protected string $updateRequestClass = UpdatePldBeneficialOwnerRequest::class;

    protected bool $allowDirectWrites = true;
}
