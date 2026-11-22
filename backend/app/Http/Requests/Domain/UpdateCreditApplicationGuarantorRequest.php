<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationGuarantor;

final class UpdateCreditApplicationGuarantorRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationGuarantor::class;
}
