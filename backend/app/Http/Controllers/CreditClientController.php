<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditClientRequest;
use App\Http\Requests\UpdateCreditClientRequest;
use App\Http\Resources\CreditClientResource;
use App\Models\CreditClient;

final class CreditClientController extends DomainResourceController
{
    protected string $modelClass = CreditClient::class;

    protected string $resourceClass = CreditClientResource::class;

    protected string $storeRequestClass = StoreCreditClientRequest::class;

    protected string $updateRequestClass = UpdateCreditClientRequest::class;

    protected bool $allowDirectWrites = true;
}
