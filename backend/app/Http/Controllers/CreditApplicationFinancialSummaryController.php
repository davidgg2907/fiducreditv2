<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditApplicationFinancialSummaryRequest;
use App\Http\Requests\Domain\UpdateCreditApplicationFinancialSummaryRequest;
use App\Http\Resources\Domain\CreditApplicationFinancialSummaryResource;
use App\Models\Domain\CreditApplicationFinancialSummary;

final class CreditApplicationFinancialSummaryController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationFinancialSummary::class;

    protected string $resourceClass = CreditApplicationFinancialSummaryResource::class;

    protected string $storeRequestClass = StoreCreditApplicationFinancialSummaryRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationFinancialSummaryRequest::class;

    protected bool $allowDirectWrites = true;
}
