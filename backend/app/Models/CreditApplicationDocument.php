<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditApplicationDocument extends Model
{
    use HasUuids;

    protected $table = 'credit_application_documents';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class, 'application_id');
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(CreditDocumentType::class, 'document_type_id');
    }

    public function previousDocument(): BelongsTo
    {
        return $this->belongsTo(CreditApplicationDocument::class, 'previous_document_id');
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by');
    }

    public function creditApplicationDocuments(): HasMany
    {
        return $this->hasMany(CreditApplicationDocument::class, 'previous_document_id');
    }

    public function creditDocumentChecks(): HasMany
    {
        return $this->hasMany(CreditDocumentCheck::class, 'application_document_id');
    }
}
