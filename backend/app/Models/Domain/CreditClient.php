<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditClient extends Model
{
    use HasUuids;

    protected $table = 'credit_clients';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditCompany::class, 'company_id');
    }

    public function creditClientAddresses(): HasMany
    {
        return $this->hasMany(CreditClientAddress::class, 'client_id');
    }

    public function creditClientBankAccounts(): HasMany
    {
        return $this->hasMany(CreditClientBankAccount::class, 'client_id');
    }

    public function creditApplications(): HasMany
    {
        return $this->hasMany(CreditApplication::class, 'client_id');
    }

    public function creditLines(): HasMany
    {
        return $this->hasMany(CreditLine::class, 'client_id');
    }

    public function pldClientProfiles(): HasMany
    {
        return $this->hasMany(PldClientProfile::class, 'client_id');
    }

    public function pldBeneficialOwners(): HasMany
    {
        return $this->hasMany(PldBeneficialOwner::class, 'client_id');
    }

    public function pldScreenings(): HasMany
    {
        return $this->hasMany(PldScreening::class, 'client_id');
    }

    public function pldMonitoringEvents(): HasMany
    {
        return $this->hasMany(PldMonitoringEvent::class, 'client_id');
    }

    public function pldAlerts(): HasMany
    {
        return $this->hasMany(PldAlert::class, 'client_id');
    }

    public function pldCases(): HasMany
    {
        return $this->hasMany(PldCase::class, 'client_id');
    }
}
