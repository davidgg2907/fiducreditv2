<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditProductFeeRequest;
use App\Http\Requests\UpdateCreditProductFeeRequest;
use App\Http\Resources\CreditProductFeeResource;
use App\Models\CreditProductFee;

final class CreditProductFeeController extends DomainResourceController
{
    protected string $modelClass = CreditProductFee::class;

    protected string $resourceClass = CreditProductFeeResource::class;

    protected string $storeRequestClass = StoreCreditProductFeeRequest::class;

    protected string $updateRequestClass = UpdateCreditProductFeeRequest::class;

    protected bool $allowDirectWrites = true;
}
