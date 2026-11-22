<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditClientBankAccountRequest;
use App\Http\Requests\UpdateCreditClientBankAccountRequest;
use App\Http\Resources\CreditClientBankAccountResource;
use App\Models\CreditClientBankAccount;

final class CreditClientBankAccountController extends DomainResourceController
{
    protected string $modelClass = CreditClientBankAccount::class;

    protected string $resourceClass = CreditClientBankAccountResource::class;

    protected string $storeRequestClass = StoreCreditClientBankAccountRequest::class;

    protected string $updateRequestClass = UpdateCreditClientBankAccountRequest::class;

    protected bool $allowDirectWrites = true;
}
