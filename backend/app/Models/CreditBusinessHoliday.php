<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditBusinessHoliday extends Model
{
    use HasUuids;

    protected $table = 'credit_business_holidays';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function calendar(): BelongsTo
    {
        return $this->belongsTo(CreditBusinessCalendar::class, 'calendar_id');
    }
}
