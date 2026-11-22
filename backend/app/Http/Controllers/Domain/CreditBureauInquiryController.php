<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditBureauInquiryRequest;
use App\Http\Requests\Domain\UpdateCreditBureauInquiryRequest;
use App\Http\Resources\Domain\CreditBureauInquiryResource;
use App\Models\Domain\CreditBureauInquiry;

final class CreditBureauInquiryController extends DomainResourceController
{
    protected string $modelClass = CreditBureauInquiry::class;

    protected string $resourceClass = CreditBureauInquiryResource::class;

    protected string $storeRequestClass = StoreCreditBureauInquiryRequest::class;

    protected string $updateRequestClass = UpdateCreditBureauInquiryRequest::class;

    protected bool $allowDirectWrites = true;
}
