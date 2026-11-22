<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditApplicationGuarantorRequest;
use App\Http\Requests\Domain\UpdateCreditApplicationGuarantorRequest;
use App\Http\Resources\Domain\CreditApplicationGuarantorResource;
use App\Models\Domain\CreditApplicationGuarantor;

final class CreditApplicationGuarantorController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationGuarantor::class;

    protected string $resourceClass = CreditApplicationGuarantorResource::class;

    protected string $storeRequestClass = StoreCreditApplicationGuarantorRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationGuarantorRequest::class;

    protected bool $allowDirectWrites = true;
}
