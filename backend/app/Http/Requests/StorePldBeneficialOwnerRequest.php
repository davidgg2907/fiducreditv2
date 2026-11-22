<?php

namespace App\Http\Requests;

use App\Models\PldBeneficialOwner;

final class StorePldBeneficialOwnerRequest extends DomainWriteRequest
{
    protected string $modelClass = PldBeneficialOwner::class;
}
