<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PldCase extends Model
{
    use HasUuids;

    protected $table = 'pld_cases';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditCompany::class, 'company_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditClient::class, 'client_id');
    }

    public function sourceAlert(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\PldAlert::class, 'source_alert_id');
    }

    public function complianceOfficer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'compliance_officer_id');
    }

    public function pldCaseEvents(): HasMany
    {
        return $this->hasMany(PldCaseEvent::class, 'case_id');
    }

    public function pldReports(): HasMany
    {
        return $this->hasMany(PldReport::class, 'case_id');
    }
}
