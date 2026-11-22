<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldScreeningRequest;
use App\Http\Requests\UpdatePldScreeningRequest;
use App\Http\Resources\PldScreeningResource;
use App\Models\PldScreening;

final class PldScreeningController extends DomainResourceController
{
    protected string $modelClass = PldScreening::class;

    protected string $resourceClass = PldScreeningResource::class;

    protected string $storeRequestClass = StorePldScreeningRequest::class;

    protected string $updateRequestClass = UpdatePldScreeningRequest::class;

    protected bool $allowDirectWrites = false;
}
