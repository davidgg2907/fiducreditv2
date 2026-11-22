<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('client_id')->constrained('credit_clients')->restrictOnDelete();
            $table->foreignUuid('product_version_id')->constrained('credit_product_versions')->restrictOnDelete();
            $table->foreignUuid('advisor_id')->constrained('credit_advisors')->restrictOnDelete();
            $table->foreignUuid('branch_id')->constrained('credit_branches')->restrictOnDelete();
            $table->foreignUuid('address_version_id')->constrained('credit_client_address_versions')->restrictOnDelete();
            $table->foreignUuid('bank_account_id')->nullable()->constrained('credit_client_bank_accounts')->restrictOnDelete();
            $table->foreignUuid('previous_application_id')->nullable()->constrained('credit_applications')->restrictOnDelete();
            $table->string('application_number')->unique();
            $table->unsignedInteger('version')->default(1);
            $table->decimal('requested_amount',18,2);
            $table->decimal('approved_amount',18,2)->nullable();
            $table->unsignedSmallInteger('requested_term');
            $table->string('status')->default('captured');
            $table->string('review_substatus')->nullable();
            $table->json('product_snapshot')->nullable();
            $table->decimal('declared_income',18,2)->nullable();
            $table->decimal('declared_expenses',18,2)->nullable();
            $table->decimal('debt_to_income_ratio',9,6)->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('decided_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->index(['status','review_substatus']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_applications'); }
};
