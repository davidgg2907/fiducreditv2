<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldCaseRequest;
use App\Http\Requests\Domain\UpdatePldCaseRequest;
use App\Http\Resources\Domain\PldCaseResource;
use App\Models\Domain\PldCase;

final class PldCaseController extends DomainResourceController
{
    protected string $modelClass = PldCase::class;

    protected string $resourceClass = PldCaseResource::class;

    protected string $storeRequestClass = StorePldCaseRequest::class;

    protected string $updateRequestClass = UpdatePldCaseRequest::class;

    protected bool $allowDirectWrites = false;
}
