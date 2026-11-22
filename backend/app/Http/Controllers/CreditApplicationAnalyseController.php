<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationAnalyseRequest;
use App\Http\Requests\UpdateCreditApplicationAnalyseRequest;
use App\Http\Resources\CreditApplicationAnalyseResource;
use App\Models\CreditApplicationAnalyse;

final class CreditApplicationAnalyseController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationAnalyse::class;

    protected string $resourceClass = CreditApplicationAnalyseResource::class;

    protected string $storeRequestClass = StoreCreditApplicationAnalyseRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationAnalyseRequest::class;

    protected bool $allowDirectWrites = true;
}
