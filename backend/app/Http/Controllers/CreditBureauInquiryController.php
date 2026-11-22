<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditBureauInquiryRequest;
use App\Http\Requests\UpdateCreditBureauInquiryRequest;
use App\Http\Resources\CreditBureauInquiryResource;
use App\Models\CreditBureauInquiry;

final class CreditBureauInquiryController extends DomainResourceController
{
    protected string $modelClass = CreditBureauInquiry::class;

    protected string $resourceClass = CreditBureauInquiryResource::class;

    protected string $storeRequestClass = StoreCreditBureauInquiryRequest::class;

    protected string $updateRequestClass = UpdateCreditBureauInquiryRequest::class;

    protected bool $allowDirectWrites = true;
}
