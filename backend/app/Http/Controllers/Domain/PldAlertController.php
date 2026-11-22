<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldAlertRequest;
use App\Http\Requests\Domain\UpdatePldAlertRequest;
use App\Http\Resources\Domain\PldAlertResource;
use App\Models\Domain\PldAlert;

final class PldAlertController extends DomainResourceController
{
    protected string $modelClass = PldAlert::class;

    protected string $resourceClass = PldAlertResource::class;

    protected string $storeRequestClass = StorePldAlertRequest::class;

    protected string $updateRequestClass = UpdatePldAlertRequest::class;

    protected bool $allowDirectWrites = false;
}
