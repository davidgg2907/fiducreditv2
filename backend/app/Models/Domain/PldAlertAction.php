<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PldAlertAction extends Model
{
    use HasUuids;

    protected $table = 'pld_alert_actions';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function alert(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\PldAlert::class, 'alert_id');
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'actor_id');
    }
}
