<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldClientProfileRequest;
use App\Http\Requests\Domain\UpdatePldClientProfileRequest;
use App\Http\Resources\Domain\PldClientProfileResource;
use App\Models\Domain\PldClientProfile;

final class PldClientProfileController extends DomainResourceController
{
    protected string $modelClass = PldClientProfile::class;

    protected string $resourceClass = PldClientProfileResource::class;

    protected string $storeRequestClass = StorePldClientProfileRequest::class;

    protected string $updateRequestClass = UpdatePldClientProfileRequest::class;

    protected bool $allowDirectWrites = true;
}
