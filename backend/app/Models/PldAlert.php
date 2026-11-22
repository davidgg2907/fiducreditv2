<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PldAlert extends Model
{
    use HasUuids;

    protected $table = 'pld_alerts';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'evidence' => 'array',
        ];
    }

    public function monitoringEvent(): BelongsTo
    {
        return $this->belongsTo(PldMonitoringEvent::class, 'monitoring_event_id');
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(PldRule::class, 'rule_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(CreditClient::class, 'client_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }

    public function pldAlertActions(): HasMany
    {
        return $this->hasMany(PldAlertAction::class, 'alert_id');
    }

    public function pldCases(): HasMany
    {
        return $this->hasMany(PldCase::class, 'source_alert_id');
    }
}
