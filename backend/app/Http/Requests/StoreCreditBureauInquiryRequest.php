<?php

namespace App\Http\Requests;

use App\Models\CreditBureauInquiry;

final class StoreCreditBureauInquiryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBureauInquiry::class;
}
