<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationFinancialSummaryRequest;
use App\Http\Requests\UpdateCreditApplicationFinancialSummaryRequest;
use App\Http\Resources\CreditApplicationFinancialSummaryResource;
use App\Models\CreditApplicationFinancialSummary;

final class CreditApplicationFinancialSummaryController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationFinancialSummary::class;

    protected string $resourceClass = CreditApplicationFinancialSummaryResource::class;

    protected string $storeRequestClass = StoreCreditApplicationFinancialSummaryRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationFinancialSummaryRequest::class;

    protected bool $allowDirectWrites = true;
}
