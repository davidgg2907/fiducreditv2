<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldScreeningRequest;
use App\Http\Requests\Domain\UpdatePldScreeningRequest;
use App\Http\Resources\Domain\PldScreeningResource;
use App\Models\Domain\PldScreening;

final class PldScreeningController extends DomainResourceController
{
    protected string $modelClass = PldScreening::class;

    protected string $resourceClass = PldScreeningResource::class;

    protected string $storeRequestClass = StorePldScreeningRequest::class;

    protected string $updateRequestClass = UpdatePldScreeningRequest::class;

    protected bool $allowDirectWrites = false;
}
