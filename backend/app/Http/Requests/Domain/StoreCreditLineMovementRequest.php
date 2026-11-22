<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLineMovement;

final class StoreCreditLineMovementRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLineMovement::class;
}
