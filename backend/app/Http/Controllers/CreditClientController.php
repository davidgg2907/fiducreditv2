<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditClientRequest;
use App\Http\Requests\Domain\UpdateCreditClientRequest;
use App\Http\Resources\Domain\CreditClientResource;
use App\Models\Domain\CreditClient;

final class CreditClientController extends DomainResourceController
{
    protected string $modelClass = CreditClient::class;

    protected string $resourceClass = CreditClientResource::class;

    protected string $storeRequestClass = StoreCreditClientRequest::class;

    protected string $updateRequestClass = UpdateCreditClientRequest::class;

    protected bool $allowDirectWrites = true;
}
