<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationConsent;

final class StoreCreditApplicationConsentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationConsent::class;
}
