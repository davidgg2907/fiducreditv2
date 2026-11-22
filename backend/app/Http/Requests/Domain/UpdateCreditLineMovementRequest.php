<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLineMovement;

final class UpdateCreditLineMovementRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLineMovement::class;
}
