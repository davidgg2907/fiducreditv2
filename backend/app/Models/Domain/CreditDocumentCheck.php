<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditDocumentCheck extends Model
{
    use HasUuids;

    protected $table = 'credit_document_checks';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function applicationDocument(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditApplicationDocument::class, 'application_document_id');
    }

    public function validationRule(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditDocumentValidationRule::class, 'validation_rule_id');
    }

    public function checkedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'checked_by');
    }
}
