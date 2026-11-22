<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditLine extends Model
{
    use HasUuids;

    protected $table = 'credit_lines';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(CreditCompany::class, 'company_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(CreditClient::class, 'client_id');
    }

    public function originApplication(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class, 'origin_application_id');
    }

    public function productVersion(): BelongsTo
    {
        return $this->belongsTo(CreditProductVersion::class, 'product_version_id');
    }

    public function policy(): BelongsTo
    {
        return $this->belongsTo(CreditLinePolicy::class, 'policy_id');
    }

    public function authorizedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'authorized_by');
    }

    public function creditLineLimitHistory(): HasMany
    {
        return $this->hasMany(CreditLineLimitHistory::class, 'line_id');
    }

    public function creditLineMovements(): HasMany
    {
        return $this->hasMany(CreditLineMovement::class, 'line_id');
    }

    public function creditDrawdowns(): HasMany
    {
        return $this->hasMany(CreditDrawdown::class, 'line_id');
    }

    public function creditContracts(): HasMany
    {
        return $this->hasMany(CreditContract::class, 'line_id');
    }

    public function creditLoans(): HasMany
    {
        return $this->hasMany(CreditLoan::class, 'line_id');
    }

    public function creditPayments(): HasMany
    {
        return $this->hasMany(CreditPayment::class, 'line_id');
    }

    public function pldMonitoringEvents(): HasMany
    {
        return $this->hasMany(PldMonitoringEvent::class, 'line_id');
    }
}
