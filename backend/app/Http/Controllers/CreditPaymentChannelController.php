<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditPaymentChannelRequest;
use App\Http\Requests\UpdateCreditPaymentChannelRequest;
use App\Http\Resources\CreditPaymentChannelResource;
use App\Models\CreditPaymentChannel;

final class CreditPaymentChannelController extends DomainResourceController
{
    protected string $modelClass = CreditPaymentChannel::class;

    protected string $resourceClass = CreditPaymentChannelResource::class;

    protected string $storeRequestClass = StoreCreditPaymentChannelRequest::class;

    protected string $updateRequestClass = UpdateCreditPaymentChannelRequest::class;

    protected bool $allowDirectWrites = true;
}
