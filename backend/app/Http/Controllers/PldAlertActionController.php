<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePldAlertActionRequest;
use App\Http\Requests\UpdatePldAlertActionRequest;
use App\Http\Resources\PldAlertActionResource;
use App\Models\PldAlertAction;

final class PldAlertActionController extends DomainResourceController
{
    protected string $modelClass = PldAlertAction::class;

    protected string $resourceClass = PldAlertActionResource::class;

    protected string $storeRequestClass = StorePldAlertActionRequest::class;

    protected string $updateRequestClass = UpdatePldAlertActionRequest::class;

    protected bool $allowDirectWrites = false;
}
