<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldReportRequest;
use App\Http\Requests\Domain\UpdatePldReportRequest;
use App\Http\Resources\Domain\PldReportResource;
use App\Models\Domain\PldReport;

final class PldReportController extends DomainResourceController
{
    protected string $modelClass = PldReport::class;

    protected string $resourceClass = PldReportResource::class;

    protected string $storeRequestClass = StorePldReportRequest::class;

    protected string $updateRequestClass = UpdatePldReportRequest::class;

    protected bool $allowDirectWrites = false;
}
