<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditLineLimitHistory extends Model
{
    use HasUuids;

    protected $table = 'credit_line_limit_history';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function line(): BelongsTo
    {
        return $this->belongsTo(CreditLine::class, 'line_id');
    }

    public function sourceApplication(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class, 'source_application_id');
    }

    public function authorizedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'authorized_by');
    }
}
