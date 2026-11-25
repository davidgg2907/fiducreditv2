<?php

namespace App\Models;

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
        return $this->belongsTo(CreditCompany::class, 'company_id');
    }

    public function parentProduct(): BelongsTo
    {
        return $this->belongsTo(CreditProduct::class, 'parent_product_id');
    }

    public function creditProducts(): HasMany
    {
        return $this->hasMany(CreditProduct::class, 'parent_product_id');
    }

    public function creditProductVersions(): HasMany
    {
        return $this->hasMany(CreditProductVersion::class, 'product_id');
    }

    public function currentVersion(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CreditProductVersion::class, 'product_id')
            ->ofMany(['version' => 'max'], fn ($query) => $query->where('active', true));
    }

    public function creditWorkflows(): HasMany
    {
        return $this->hasMany(CreditWorkflow::class, 'product_id');
    }
}
