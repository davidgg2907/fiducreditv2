<?php

namespace App\Http\Requests;

use App\Models\CreditBureauInquiry;

final class UpdateCreditBureauInquiryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBureauInquiry::class;
}
