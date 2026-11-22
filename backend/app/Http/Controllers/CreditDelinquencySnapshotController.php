<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditDelinquencySnapshotRequest;
use App\Http\Requests\UpdateCreditDelinquencySnapshotRequest;
use App\Http\Resources\CreditDelinquencySnapshotResource;
use App\Models\CreditDelinquencySnapshot;

final class CreditDelinquencySnapshotController extends DomainResourceController
{
    protected string $modelClass = CreditDelinquencySnapshot::class;

    protected string $resourceClass = CreditDelinquencySnapshotResource::class;

    protected string $storeRequestClass = StoreCreditDelinquencySnapshotRequest::class;

    protected string $updateRequestClass = UpdateCreditDelinquencySnapshotRequest::class;

    protected bool $allowDirectWrites = false;
}
