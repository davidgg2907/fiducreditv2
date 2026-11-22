<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldCaseRequest;
use App\Http\Requests\UpdatePldCaseRequest;
use App\Http\Resources\PldCaseResource;
use App\Models\PldCase;

final class PldCaseController extends DomainResourceController
{
    protected string $modelClass = PldCase::class;

    protected string $resourceClass = PldCaseResource::class;

    protected string $storeRequestClass = StorePldCaseRequest::class;

    protected string $updateRequestClass = UpdatePldCaseRequest::class;

    protected bool $allowDirectWrites = false;
}
