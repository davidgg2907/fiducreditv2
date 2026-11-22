<?php

namespace App\Http\Requests;

use App\Models\CreditPaymentChannel;

final class UpdateCreditPaymentChannelRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentChannel::class;
}
