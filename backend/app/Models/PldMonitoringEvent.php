<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PldMonitoringEvent extends Model
{
    use HasUuids;

    protected $table = 'pld_monitoring_events';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'facts' => 'array',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(CreditClient::class, 'client_id');
    }

    public function line(): BelongsTo
    {
        return $this->belongsTo(CreditLine::class, 'line_id');
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(CreditLoan::class, 'loan_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(CreditPayment::class, 'payment_id');
    }

    public function drawdown(): BelongsTo
    {
        return $this->belongsTo(CreditDrawdown::class, 'drawdown_id');
    }

    public function settlement(): BelongsTo
    {
        return $this->belongsTo(CreditSettlement::class, 'settlement_id');
    }

    public function policyVersion(): BelongsTo
    {
        return $this->belongsTo(PldPolicyVersion::class, 'policy_version_id');
    }

    public function pldAlerts(): HasMany
    {
        return $this->hasMany(PldAlert::class, 'monitoring_event_id');
    }
}
