<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditProductFeeRequest;
use App\Http\Requests\Domain\UpdateCreditProductFeeRequest;
use App\Http\Resources\Domain\CreditProductFeeResource;
use App\Models\Domain\CreditProductFee;

final class CreditProductFeeController extends DomainResourceController
{
    protected string $modelClass = CreditProductFee::class;

    protected string $resourceClass = CreditProductFeeResource::class;

    protected string $storeRequestClass = StoreCreditProductFeeRequest::class;

    protected string $updateRequestClass = UpdateCreditProductFeeRequest::class;

    protected bool $allowDirectWrites = true;
}
