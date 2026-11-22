<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationConsent;

final class StoreCreditApplicationConsentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationConsent::class;
}
