<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditProductField extends Model
{
    use HasUuids;

    protected $table = 'credit_product_fields';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function productVersion(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditProductVersion::class, 'product_version_id');
    }

    public function customField(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditCustomField::class, 'custom_field_id');
    }
}
