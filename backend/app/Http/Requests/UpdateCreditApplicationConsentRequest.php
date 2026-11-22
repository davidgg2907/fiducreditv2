<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationConsent;

final class UpdateCreditApplicationConsentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationConsent::class;
}
