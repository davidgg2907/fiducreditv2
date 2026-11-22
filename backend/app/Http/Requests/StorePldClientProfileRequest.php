<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldClientProfile;

final class StorePldClientProfileRequest extends DomainWriteRequest
{
    protected string $modelClass = PldClientProfile::class;
}
