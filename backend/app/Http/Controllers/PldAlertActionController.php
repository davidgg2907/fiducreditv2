<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StorePldAlertActionRequest;
use App\Http\Requests\Domain\UpdatePldAlertActionRequest;
use App\Http\Resources\Domain\PldAlertActionResource;
use App\Models\Domain\PldAlertAction;

final class PldAlertActionController extends DomainResourceController
{
    protected string $modelClass = PldAlertAction::class;

    protected string $resourceClass = PldAlertActionResource::class;

    protected string $storeRequestClass = StorePldAlertActionRequest::class;

    protected string $updateRequestClass = UpdatePldAlertActionRequest::class;

    protected bool $allowDirectWrites = false;
}
