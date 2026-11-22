<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditPaymentChannelRequest;
use App\Http\Requests\Domain\UpdateCreditPaymentChannelRequest;
use App\Http\Resources\Domain\CreditPaymentChannelResource;
use App\Models\Domain\CreditPaymentChannel;

final class CreditPaymentChannelController extends DomainResourceController
{
    protected string $modelClass = CreditPaymentChannel::class;

    protected string $resourceClass = CreditPaymentChannelResource::class;

    protected string $storeRequestClass = StoreCreditPaymentChannelRequest::class;

    protected string $updateRequestClass = UpdateCreditPaymentChannelRequest::class;

    protected bool $allowDirectWrites = true;
}
