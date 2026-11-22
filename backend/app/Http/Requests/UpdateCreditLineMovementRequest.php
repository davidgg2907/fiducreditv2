<?php

namespace App\Http\Requests;

use App\Models\CreditLineMovement;

final class UpdateCreditLineMovementRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLineMovement::class;
}
