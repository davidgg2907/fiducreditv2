<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditProduct extends Model
{
    use HasUuids;

    protected $table = 'credit_products';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditCompany::class, 'company_id');
    }

    public function parentProduct(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditProduct::class, 'parent_product_id');
    }

    public function creditProducts(): HasMany
    {
        return $this->hasMany(CreditProduct::class, 'parent_product_id');
    }

    public function creditProductVersions(): HasMany
    {
        return $this->hasMany(CreditProductVersion::class, 'product_id');
    }

    public function creditWorkflows(): HasMany
    {
        return $this->hasMany(CreditWorkflow::class, 'product_id');
    }
}
