<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationEvent;

final class UpdateCreditApplicationEventRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationEvent::class;
}
