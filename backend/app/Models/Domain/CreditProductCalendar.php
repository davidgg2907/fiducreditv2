<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditProductCalendar extends Model
{
    use HasUuids;

    protected $table = 'credit_product_calendars';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function productVersion(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditProductVersion::class, 'product_version_id');
    }

    public function calendar(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditBusinessCalendar::class, 'calendar_id');
    }
}
