<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldBeneficialOwnerRequest;
use App\Http\Requests\Domain\UpdatePldBeneficialOwnerRequest;
use App\Http\Resources\Domain\PldBeneficialOwnerResource;
use App\Models\Domain\PldBeneficialOwner;

final class PldBeneficialOwnerController extends DomainResourceController
{
    protected string $modelClass = PldBeneficialOwner::class;

    protected string $resourceClass = PldBeneficialOwnerResource::class;

    protected string $storeRequestClass = StorePldBeneficialOwnerRequest::class;

    protected string $updateRequestClass = UpdatePldBeneficialOwnerRequest::class;

    protected bool $allowDirectWrites = true;
}
