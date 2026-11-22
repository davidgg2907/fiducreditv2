<?php

namespace App\Http\Requests;

use App\Models\CreditPaymentChannel;

final class StoreCreditPaymentChannelRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentChannel::class;
}
