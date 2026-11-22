<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldClientProfileRequest;
use App\Http\Requests\UpdatePldClientProfileRequest;
use App\Http\Resources\PldClientProfileResource;
use App\Models\PldClientProfile;

final class PldClientProfileController extends DomainResourceController
{
    protected string $modelClass = PldClientProfile::class;

    protected string $resourceClass = PldClientProfileResource::class;

    protected string $storeRequestClass = StorePldClientProfileRequest::class;

    protected string $updateRequestClass = UpdatePldClientProfileRequest::class;

    protected bool $allowDirectWrites = true;
}
