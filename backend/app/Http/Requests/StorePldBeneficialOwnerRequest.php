<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldBeneficialOwner;

final class StorePldBeneficialOwnerRequest extends DomainWriteRequest
{
    protected string $modelClass = PldBeneficialOwner::class;
}
