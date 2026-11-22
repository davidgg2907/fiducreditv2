<?php

namespace App\Http\Requests;

use App\Models\PldClientProfile;

final class StorePldClientProfileRequest extends DomainWriteRequest
{
    protected string $modelClass = PldClientProfile::class;
}
