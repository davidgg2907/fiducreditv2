<?php

namespace App\Http\Requests;

use App\Models\CreditLineMovement;

final class StoreCreditLineMovementRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLineMovement::class;
}
