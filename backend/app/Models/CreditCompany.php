<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditCompany extends Model
{
    use HasUuids;

    protected $table = 'credit_companies';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function creditBranches(): HasMany
    {
        return $this->hasMany(CreditBranch::class, 'company_id');
    }

    public function creditAdvisors(): HasMany
    {
        return $this->hasMany(CreditAdvisor::class, 'company_id');
    }

    public function creditProducts(): HasMany
    {
        return $this->hasMany(CreditProduct::class, 'company_id');
    }

    public function creditCustomFields(): HasMany
    {
        return $this->hasMany(CreditCustomField::class, 'company_id');
    }

    public function creditClients(): HasMany
    {
        return $this->hasMany(CreditClient::class, 'company_id');
    }

    public function creditDocumentTypes(): HasMany
    {
        return $this->hasMany(CreditDocumentType::class, 'company_id');
    }

    public function creditWorkflows(): HasMany
    {
        return $this->hasMany(CreditWorkflow::class, 'company_id');
    }

    public function creditLines(): HasMany
    {
        return $this->hasMany(CreditLine::class, 'company_id');
    }

    public function creditBusinessCalendars(): HasMany
    {
        return $this->hasMany(CreditBusinessCalendar::class, 'company_id');
    }

    public function creditPaymentChannels(): HasMany
    {
        return $this->hasMany(CreditPaymentChannel::class, 'company_id');
    }

    public function pldPolicies(): HasMany
    {
        return $this->hasMany(PldPolicy::class, 'company_id');
    }

    public function pldCases(): HasMany
    {
        return $this->hasMany(PldCase::class, 'company_id');
    }

    public function pldReports(): HasMany
    {
        return $this->hasMany(PldReport::class, 'company_id');
    }
}
