<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditApplicationAnalyseRequest;
use App\Http\Requests\Domain\UpdateCreditApplicationAnalyseRequest;
use App\Http\Resources\Domain\CreditApplicationAnalyseResource;
use App\Models\Domain\CreditApplicationAnalyse;

final class CreditApplicationAnalyseController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationAnalyse::class;

    protected string $resourceClass = CreditApplicationAnalyseResource::class;

    protected string $storeRequestClass = StoreCreditApplicationAnalyseRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationAnalyseRequest::class;

    protected bool $allowDirectWrites = true;
}
