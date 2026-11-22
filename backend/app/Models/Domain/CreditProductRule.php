<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditProductRule extends Model
{
    use HasUuids;

    protected $table = 'credit_product_rules';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'rule_value' => 'array',
        ];
    }

    public function productVersion(): BelongsTo
    {
        return $this->belongsTo(CreditProductVersion::class, 'product_version_id');
    }
}
