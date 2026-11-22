<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationConsentRequest;
use App\Http\Requests\UpdateCreditApplicationConsentRequest;
use App\Http\Resources\CreditApplicationConsentResource;
use App\Models\CreditApplicationConsent;

final class CreditApplicationConsentController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationConsent::class;

    protected string $resourceClass = CreditApplicationConsentResource::class;

    protected string $storeRequestClass = StoreCreditApplicationConsentRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationConsentRequest::class;

    protected bool $allowDirectWrites = true;
}
