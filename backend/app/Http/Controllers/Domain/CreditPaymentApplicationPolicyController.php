<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditPaymentApplicationPolicyRequest;
use App\Http\Requests\Domain\UpdateCreditPaymentApplicationPolicyRequest;
use App\Http\Resources\Domain\CreditPaymentApplicationPolicyResource;
use App\Models\Domain\CreditPaymentApplicationPolicy;

final class CreditPaymentApplicationPolicyController extends DomainResourceController
{
    protected string $modelClass = CreditPaymentApplicationPolicy::class;

    protected string $resourceClass = CreditPaymentApplicationPolicyResource::class;

    protected string $storeRequestClass = StoreCreditPaymentApplicationPolicyRequest::class;

    protected string $updateRequestClass = UpdateCreditPaymentApplicationPolicyRequest::class;

    protected bool $allowDirectWrites = true;
}
