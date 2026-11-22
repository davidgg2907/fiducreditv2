<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditProductVersion extends Model
{
    use HasUuids;

    protected $table = 'credit_product_versions';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditProduct::class, 'product_id');
    }

    public function creditProductFees(): HasMany
    {
        return $this->hasMany(CreditProductFee::class, 'product_version_id');
    }

    public function creditProductRules(): HasMany
    {
        return $this->hasMany(CreditProductRule::class, 'product_version_id');
    }

    public function creditProductFields(): HasMany
    {
        return $this->hasMany(CreditProductField::class, 'product_version_id');
    }

    public function creditProductDocuments(): HasMany
    {
        return $this->hasMany(CreditProductDocument::class, 'product_version_id');
    }

    public function creditApplications(): HasMany
    {
        return $this->hasMany(CreditApplication::class, 'product_version_id');
    }

    public function creditLinePolicies(): HasMany
    {
        return $this->hasMany(CreditLinePolicy::class, 'product_version_id');
    }

    public function creditLines(): HasMany
    {
        return $this->hasMany(CreditLine::class, 'product_version_id');
    }

    public function creditProductCalendars(): HasMany
    {
        return $this->hasMany(CreditProductCalendar::class, 'product_version_id');
    }

    public function creditPaymentApplicationPolicies(): HasMany
    {
        return $this->hasMany(CreditPaymentApplicationPolicy::class, 'product_version_id');
    }

    public function pldProductPolicies(): HasMany
    {
        return $this->hasMany(PldProductPolicy::class, 'product_version_id');
    }
}
