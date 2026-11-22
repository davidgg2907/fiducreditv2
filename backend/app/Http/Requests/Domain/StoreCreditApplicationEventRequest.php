<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationEvent;

final class StoreCreditApplicationEventRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationEvent::class;
}
