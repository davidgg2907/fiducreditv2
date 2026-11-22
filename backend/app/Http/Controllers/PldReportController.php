<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldReportRequest;
use App\Http\Requests\UpdatePldReportRequest;
use App\Http\Resources\PldReportResource;
use App\Models\PldReport;

final class PldReportController extends DomainResourceController
{
    protected string $modelClass = PldReport::class;

    protected string $resourceClass = PldReportResource::class;

    protected string $storeRequestClass = StorePldReportRequest::class;

    protected string $updateRequestClass = UpdatePldReportRequest::class;

    protected bool $allowDirectWrites = false;
}
