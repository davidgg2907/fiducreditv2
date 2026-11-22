<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditDocumentValidationRule extends Model
{
    use HasUuids;

    protected $table = 'credit_document_validation_rules';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'parameters' => 'array',
        ];
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(CreditDocumentType::class, 'document_type_id');
    }

    public function creditDocumentChecks(): HasMany
    {
        return $this->hasMany(CreditDocumentCheck::class, 'validation_rule_id');
    }
}
