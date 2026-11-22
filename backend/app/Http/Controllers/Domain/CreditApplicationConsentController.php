<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditApplicationConsentRequest;
use App\Http\Requests\Domain\UpdateCreditApplicationConsentRequest;
use App\Http\Resources\Domain\CreditApplicationConsentResource;
use App\Models\Domain\CreditApplicationConsent;

final class CreditApplicationConsentController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationConsent::class;

    protected string $resourceClass = CreditApplicationConsentResource::class;

    protected string $storeRequestClass = StoreCreditApplicationConsentRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationConsentRequest::class;

    protected bool $allowDirectWrites = true;
}
