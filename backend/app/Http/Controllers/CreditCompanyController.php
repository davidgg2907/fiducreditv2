<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditCompanyRequest;
use App\Http\Requests\Domain\UpdateCreditCompanyRequest;
use App\Http\Resources\Domain\CreditCompanyResource;
use App\Models\Domain\CreditCompany;

final class CreditCompanyController extends DomainResourceController
{
    protected string $modelClass = CreditCompany::class;

    protected string $resourceClass = CreditCompanyResource::class;

    protected string $storeRequestClass = StoreCreditCompanyRequest::class;

    protected string $updateRequestClass = UpdateCreditCompanyRequest::class;

    protected bool $allowDirectWrites = true;
}
