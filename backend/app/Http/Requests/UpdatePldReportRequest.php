<?php

namespace App\Http\Requests;

use App\Models\PldReport;

final class UpdatePldReportRequest extends DomainWriteRequest
{
    protected string $modelClass = PldReport::class;
}
