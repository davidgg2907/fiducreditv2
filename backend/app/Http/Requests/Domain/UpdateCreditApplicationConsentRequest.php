<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationConsent;

final class UpdateCreditApplicationConsentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationConsent::class;
}
