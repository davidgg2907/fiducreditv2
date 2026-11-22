<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditDelinquencySnapshotRequest;
use App\Http\Requests\Domain\UpdateCreditDelinquencySnapshotRequest;
use App\Http\Resources\Domain\CreditDelinquencySnapshotResource;
use App\Models\Domain\CreditDelinquencySnapshot;

final class CreditDelinquencySnapshotController extends DomainResourceController
{
    protected string $modelClass = CreditDelinquencySnapshot::class;

    protected string $resourceClass = CreditDelinquencySnapshotResource::class;

    protected string $storeRequestClass = StoreCreditDelinquencySnapshotRequest::class;

    protected string $updateRequestClass = UpdateCreditDelinquencySnapshotRequest::class;

    protected bool $allowDirectWrites = false;
}
