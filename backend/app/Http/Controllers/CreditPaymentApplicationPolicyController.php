<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditPaymentApplicationPolicyRequest;
use App\Http\Requests\UpdateCreditPaymentApplicationPolicyRequest;
use App\Http\Resources\CreditPaymentApplicationPolicyResource;
use App\Models\CreditPaymentApplicationPolicy;

final class CreditPaymentApplicationPolicyController extends DomainResourceController
{
    protected string $modelClass = CreditPaymentApplicationPolicy::class;

    protected string $resourceClass = CreditPaymentApplicationPolicyResource::class;

    protected string $storeRequestClass = StoreCreditPaymentApplicationPolicyRequest::class;

    protected string $updateRequestClass = UpdateCreditPaymentApplicationPolicyRequest::class;

    protected bool $allowDirectWrites = true;
}
