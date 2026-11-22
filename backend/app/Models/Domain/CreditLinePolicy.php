<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditLinePolicy extends Model
{
    use HasUuids;

    protected $table = 'credit_line_policies';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function productVersion(): BelongsTo
    {
        return $this->belongsTo(CreditProductVersion::class, 'product_version_id');
    }

    public function creditLines(): HasMany
    {
        return $this->hasMany(CreditLine::class, 'policy_id');
    }
}
