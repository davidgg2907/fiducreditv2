<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditApplicationStatusHistory extends Model
{
    use HasUuids;

    protected $table = 'credit_application_status_history';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class, 'application_id');
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'changed_by');
    }
}
