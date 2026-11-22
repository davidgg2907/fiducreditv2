<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditClientBankAccountRequest;
use App\Http\Requests\Domain\UpdateCreditClientBankAccountRequest;
use App\Http\Resources\Domain\CreditClientBankAccountResource;
use App\Models\Domain\CreditClientBankAccount;

final class CreditClientBankAccountController extends DomainResourceController
{
    protected string $modelClass = CreditClientBankAccount::class;

    protected string $resourceClass = CreditClientBankAccountResource::class;

    protected string $storeRequestClass = StoreCreditClientBankAccountRequest::class;

    protected string $updateRequestClass = UpdateCreditClientBankAccountRequest::class;

    protected bool $allowDirectWrites = true;
}
