<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditCustomField extends Model
{
    use HasUuids;

    protected $table = 'credit_custom_fields';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'options' => 'array',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(CreditCompany::class, 'company_id');
    }

    public function creditProductFields(): HasMany
    {
        return $this->hasMany(CreditProductField::class, 'custom_field_id');
    }

    public function creditApplicationFields(): HasMany
    {
        return $this->hasMany(CreditApplicationField::class, 'custom_field_id');
    }
}
