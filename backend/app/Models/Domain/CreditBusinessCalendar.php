<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditBusinessCalendar extends Model
{
    use HasUuids;

    protected $table = 'credit_business_calendars';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditCompany::class, 'company_id');
    }

    public function creditBusinessHolidays(): HasMany
    {
        return $this->hasMany(CreditBusinessHoliday::class, 'calendar_id');
    }

    public function creditProductCalendars(): HasMany
    {
        return $this->hasMany(CreditProductCalendar::class, 'calendar_id');
    }
}
