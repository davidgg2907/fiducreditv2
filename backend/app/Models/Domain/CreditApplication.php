<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditApplication extends Model
{
    use HasUuids;

    protected $table = 'credit_applications';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(CreditClient::class, 'client_id');
    }

    public function productVersion(): BelongsTo
    {
        return $this->belongsTo(CreditProductVersion::class, 'product_version_id');
    }

    public function advisor(): BelongsTo
    {
        return $this->belongsTo(CreditAdvisor::class, 'advisor_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(CreditBranch::class, 'branch_id');
    }

    public function addressVersion(): BelongsTo
    {
        return $this->belongsTo(CreditClientAddressVersion::class, 'address_version_id');
    }

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(CreditClientBankAccount::class, 'bank_account_id');
    }

    public function previousApplication(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class, 'previous_application_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function creditApplications(): HasMany
    {
        return $this->hasMany(CreditApplication::class, 'previous_application_id');
    }

    public function creditApplicationFields(): HasMany
    {
        return $this->hasMany(CreditApplicationField::class, 'application_id');
    }

    public function creditApplicationDocuments(): HasMany
    {
        return $this->hasMany(CreditApplicationDocument::class, 'application_id');
    }

    public function creditApplicationFinancialItems(): HasMany
    {
        return $this->hasMany(CreditApplicationFinancialItem::class, 'application_id');
    }

    public function creditApplicationFinancialSummaries(): HasMany
    {
        return $this->hasMany(CreditApplicationFinancialSummary::class, 'application_id');
    }

    public function creditBureauInquiries(): HasMany
    {
        return $this->hasMany(CreditBureauInquiry::class, 'application_id');
    }

    public function creditApplicationAnalyses(): HasMany
    {
        return $this->hasMany(CreditApplicationAnalyse::class, 'application_id');
    }

    public function creditApplicationDecisions(): HasMany
    {
        return $this->hasMany(CreditApplicationDecision::class, 'application_id');
    }

    public function creditApplicationStatusHistory(): HasMany
    {
        return $this->hasMany(CreditApplicationStatusHistory::class, 'application_id');
    }

    public function creditApplicationEvents(): HasMany
    {
        return $this->hasMany(CreditApplicationEvent::class, 'application_id');
    }

    public function creditApplicationConsents(): HasMany
    {
        return $this->hasMany(CreditApplicationConsent::class, 'application_id');
    }

    public function creditApplicationGuarantors(): HasMany
    {
        return $this->hasMany(CreditApplicationGuarantor::class, 'application_id');
    }

    public function creditApplicationConditions(): HasMany
    {
        return $this->hasMany(CreditApplicationCondition::class, 'application_id');
    }

    public function creditWorkflowInstances(): HasMany
    {
        return $this->hasMany(CreditWorkflowInstance::class, 'application_id');
    }

    public function creditLines(): HasMany
    {
        return $this->hasMany(CreditLine::class, 'origin_application_id');
    }

    public function creditLineLimitHistory(): HasMany
    {
        return $this->hasMany(CreditLineLimitHistory::class, 'source_application_id');
    }

    public function creditDrawdowns(): HasMany
    {
        return $this->hasMany(CreditDrawdown::class, 'application_id');
    }

    public function creditContracts(): HasMany
    {
        return $this->hasMany(CreditContract::class, 'application_id');
    }

    public function creditLoans(): HasMany
    {
        return $this->hasMany(CreditLoan::class, 'application_id');
    }
}
