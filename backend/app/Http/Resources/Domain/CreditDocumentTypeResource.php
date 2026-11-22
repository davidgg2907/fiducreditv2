<?php

namespace App\Http\Resources\Domain;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreditDocumentTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
