<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationEvent;

final class StoreCreditApplicationEventRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationEvent::class;
}
