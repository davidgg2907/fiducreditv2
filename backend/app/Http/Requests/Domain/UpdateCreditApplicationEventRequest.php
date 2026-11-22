<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationEvent;

final class UpdateCreditApplicationEventRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationEvent::class;
}
