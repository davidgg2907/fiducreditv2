<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldAlertRequest;
use App\Http\Requests\UpdatePldAlertRequest;
use App\Http\Resources\PldAlertResource;
use App\Models\PldAlert;

final class PldAlertController extends DomainResourceController
{
    protected string $modelClass = PldAlert::class;

    protected string $resourceClass = PldAlertResource::class;

    protected string $storeRequestClass = StorePldAlertRequest::class;

    protected string $updateRequestClass = UpdatePldAlertRequest::class;

    protected bool $allowDirectWrites = false;
}
