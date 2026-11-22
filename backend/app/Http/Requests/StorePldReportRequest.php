<?php

namespace App\Http\Requests;

use App\Models\PldReport;

final class StorePldReportRequest extends DomainWriteRequest
{
    protected string $modelClass = PldReport::class;
}
