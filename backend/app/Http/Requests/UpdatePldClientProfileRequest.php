<?php

namespace App\Http\Requests;

use App\Models\PldClientProfile;

final class UpdatePldClientProfileRequest extends DomainWriteRequest
{
    protected string $modelClass = PldClientProfile::class;
}
