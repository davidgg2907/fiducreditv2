<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationGuarantorRequest;
use App\Http\Requests\UpdateCreditApplicationGuarantorRequest;
use App\Http\Resources\CreditApplicationGuarantorResource;
use App\Models\CreditApplicationGuarantor;

final class CreditApplicationGuarantorController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationGuarantor::class;

    protected string $resourceClass = CreditApplicationGuarantorResource::class;

    protected string $storeRequestClass = StoreCreditApplicationGuarantorRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationGuarantorRequest::class;

    protected bool $allowDirectWrites = true;
}
