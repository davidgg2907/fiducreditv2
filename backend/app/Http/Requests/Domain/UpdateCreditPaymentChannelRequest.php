<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPaymentChannel;

final class UpdateCreditPaymentChannelRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentChannel::class;
}
