<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPaymentChannel;

final class StoreCreditPaymentChannelRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentChannel::class;
}
