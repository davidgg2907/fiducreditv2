<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditClientBankAccount extends Model
{
    use HasUuids;

    protected $table = 'credit_client_bank_accounts';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(CreditClient::class, 'client_id');
    }

    public function creditApplications(): HasMany
    {
        return $this->hasMany(CreditApplication::class, 'bank_account_id');
    }

    public function creditDrawdowns(): HasMany
    {
        return $this->hasMany(CreditDrawdown::class, 'bank_account_id');
    }

    public function creditPayments(): HasMany
    {
        return $this->hasMany(CreditPayment::class, 'source_bank_account_id');
    }
}
