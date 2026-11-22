<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldReport;

final class StorePldReportRequest extends DomainWriteRequest
{
    protected string $modelClass = PldReport::class;
}
