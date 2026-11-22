<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditBureauInquiry;

final class StoreCreditBureauInquiryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBureauInquiry::class;
}
