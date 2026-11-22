<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditDocumentType extends Model
{
    use HasUuids;

    protected $table = 'credit_document_types';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(CreditCompany::class, 'company_id');
    }

    public function creditDocumentValidationRules(): HasMany
    {
        return $this->hasMany(CreditDocumentValidationRule::class, 'document_type_id');
    }

    public function creditProductDocuments(): HasMany
    {
        return $this->hasMany(CreditProductDocument::class, 'document_type_id');
    }

    public function creditApplicationDocuments(): HasMany
    {
        return $this->hasMany(CreditApplicationDocument::class, 'document_type_id');
    }
}
