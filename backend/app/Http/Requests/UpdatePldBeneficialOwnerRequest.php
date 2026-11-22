<?php

namespace App\Http\Requests;

use App\Models\PldBeneficialOwner;

final class UpdatePldBeneficialOwnerRequest extends DomainWriteRequest
{
    protected string $modelClass = PldBeneficialOwner::class;
}
