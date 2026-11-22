<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditCompanyRequest;
use App\Http\Requests\UpdateCreditCompanyRequest;
use App\Http\Resources\CreditCompanyResource;
use App\Models\CreditCompany;

final class CreditCompanyController extends DomainResourceController
{
    protected string $modelClass = CreditCompany::class;

    protected string $resourceClass = CreditCompanyResource::class;

    protected string $storeRequestClass = StoreCreditCompanyRequest::class;

    protected string $updateRequestClass = UpdateCreditCompanyRequest::class;

    protected bool $allowDirectWrites = true;
}
