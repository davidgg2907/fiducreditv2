<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationGuarantor;

final class UpdateCreditApplicationGuarantorRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationGuarantor::class;
}
