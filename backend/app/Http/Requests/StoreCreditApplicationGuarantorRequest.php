<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationGuarantor;

final class StoreCreditApplicationGuarantorRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationGuarantor::class;
}
