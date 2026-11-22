<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldBeneficialOwner;

final class UpdatePldBeneficialOwnerRequest extends DomainWriteRequest
{
    protected string $modelClass = PldBeneficialOwner::class;
}
