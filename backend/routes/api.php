<?php

use App\Http\Controllers\AccessRoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginBrandingController;
use App\Http\Middleware\AuthenticateAccessToken;
use App\Http\Middleware\ProtectBrowserAuth;
use Illuminate\Support\Facades\Route;

Route::get('login/branding', [LoginBrandingController::class, 'show']);

Route::middleware(ProtectBrowserAuth::class)->group(function (): void {
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:auth-login');
    Route::post('login/refresh', [AuthController::class, 'refresh'])->middleware('throttle:auth-session');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('throttle:auth-session');
    Route::post('password/forgot', [AuthController::class, 'forgotPassword'])->middleware('throttle:auth-recovery');
    Route::post('password/reset', [AuthController::class, 'resetPassword'])->middleware('throttle:auth-recovery');
});

Route::middleware(AuthenticateAccessToken::class)->group(function (): void {
    Route::get('me', [AuthController::class, 'me']);
    Route::prefix('access')->middleware('can:manage-access')->group(function (): void {
        Route::get('catalog', [AccessRoleController::class, 'catalog']);
        Route::get('roles', [AccessRoleController::class, 'index']);
        Route::post('roles', [AccessRoleController::class, 'store']);
        Route::put('roles/{role}', [AccessRoleController::class, 'update'])->whereNumber('role');
        Route::put('users/{user}/role', [AccessRoleController::class, 'assign'])->whereNumber('user');
    });

    Route::get('perfil', [AuthController::class, 'profile']);
    Route::post('perfil', [AuthController::class, 'updateProfile'])->middleware('throttle:auth-sensitive');
    Route::post('perfil/contrasena', [AuthController::class, 'updatePassword'])->middleware('throttle:auth-sensitive');
});


// Los cinco frontends comparten estos recursos. Solo acceso administrativo
// hasta implementar políticas operativas por empresa, sucursal y flujo.
Route::middleware(AuthenticateAccessToken::class)
    ->prefix('v1')
    ->group(function (): void {
        Route::apiResource('credit-companies', \App\Http\Controllers\Domain\CreditCompanyController::class);
        Route::apiResource('credit-branches', \App\Http\Controllers\Domain\CreditBranchController::class);
        Route::apiResource('credit-advisors', \App\Http\Controllers\Domain\CreditAdvisorController::class);
        Route::apiResource('credit-products', \App\Http\Controllers\Domain\CreditProductController::class);
        Route::apiResource('credit-product-versions', \App\Http\Controllers\Domain\CreditProductVersionController::class);
        Route::apiResource('credit-product-fees', \App\Http\Controllers\Domain\CreditProductFeeController::class);
        Route::apiResource('credit-product-rules', \App\Http\Controllers\Domain\CreditProductRuleController::class);
        Route::apiResource('credit-custom-fields', \App\Http\Controllers\Domain\CreditCustomFieldController::class);
        Route::apiResource('credit-product-fields', \App\Http\Controllers\Domain\CreditProductFieldController::class);
        Route::apiResource('credit-clients', \App\Http\Controllers\Domain\CreditClientController::class);
        Route::apiResource('credit-client-addresses', \App\Http\Controllers\Domain\CreditClientAddressController::class);
        Route::apiResource('credit-client-address-versions', \App\Http\Controllers\Domain\CreditClientAddressVersionController::class);
        Route::apiResource('credit-client-bank-accounts', \App\Http\Controllers\Domain\CreditClientBankAccountController::class);
        Route::apiResource('credit-document-types', \App\Http\Controllers\Domain\CreditDocumentTypeController::class);
        Route::apiResource('credit-document-validation-rules', \App\Http\Controllers\Domain\CreditDocumentValidationRuleController::class);
        Route::apiResource('credit-product-documents', \App\Http\Controllers\Domain\CreditProductDocumentController::class);
        Route::apiResource('credit-applications', \App\Http\Controllers\Domain\CreditApplicationController::class);
        Route::apiResource('credit-application-fields', \App\Http\Controllers\Domain\CreditApplicationFieldController::class);
        Route::apiResource('credit-application-documents', \App\Http\Controllers\Domain\CreditApplicationDocumentController::class);
        Route::apiResource('credit-document-checks', \App\Http\Controllers\Domain\CreditDocumentCheckController::class);
        Route::apiResource('credit-application-financial-items', \App\Http\Controllers\Domain\CreditApplicationFinancialItemController::class);
        Route::apiResource('credit-application-financial-summaries', \App\Http\Controllers\Domain\CreditApplicationFinancialSummaryController::class);
        Route::apiResource('credit-bureau-inquiries', \App\Http\Controllers\Domain\CreditBureauInquiryController::class);
        Route::apiResource('credit-application-analyses', \App\Http\Controllers\Domain\CreditApplicationAnalyseController::class);
        Route::apiResource('credit-application-decisions', \App\Http\Controllers\Domain\CreditApplicationDecisionController::class);
        Route::apiResource('credit-application-status-history', \App\Http\Controllers\Domain\CreditApplicationStatusHistoryController::class);
        Route::apiResource('credit-application-events', \App\Http\Controllers\Domain\CreditApplicationEventController::class);
        Route::apiResource('credit-application-consents', \App\Http\Controllers\Domain\CreditApplicationConsentController::class);
        Route::apiResource('credit-application-guarantors', \App\Http\Controllers\Domain\CreditApplicationGuarantorController::class);
        Route::apiResource('credit-application-conditions', \App\Http\Controllers\Domain\CreditApplicationConditionController::class);
        Route::apiResource('credit-workflows', \App\Http\Controllers\Domain\CreditWorkflowController::class);
        Route::apiResource('credit-workflow-versions', \App\Http\Controllers\Domain\CreditWorkflowVersionController::class);
        Route::apiResource('credit-workflow-steps', \App\Http\Controllers\Domain\CreditWorkflowStepController::class);
        Route::apiResource('credit-workflow-transitions', \App\Http\Controllers\Domain\CreditWorkflowTransitionController::class);
        Route::apiResource('credit-workflow-step-roles', \App\Http\Controllers\Domain\CreditWorkflowStepRoleController::class);
        Route::apiResource('credit-workflow-step-rules', \App\Http\Controllers\Domain\CreditWorkflowStepRuleController::class);
        Route::apiResource('credit-workflow-instances', \App\Http\Controllers\Domain\CreditWorkflowInstanceController::class);
        Route::apiResource('credit-workflow-tasks', \App\Http\Controllers\Domain\CreditWorkflowTaskController::class);
        Route::apiResource('credit-workflow-task-history', \App\Http\Controllers\Domain\CreditWorkflowTaskHistoryController::class);
        Route::apiResource('credit-workflow-sla', \App\Http\Controllers\Domain\CreditWorkflowSlaController::class);
        Route::apiResource('credit-line-policies', \App\Http\Controllers\Domain\CreditLinePolicyController::class);
        Route::apiResource('credit-lines', \App\Http\Controllers\Domain\CreditLineController::class);
        Route::apiResource('credit-line-limit-history', \App\Http\Controllers\Domain\CreditLineLimitHistoryController::class);
        Route::apiResource('credit-line-movements', \App\Http\Controllers\Domain\CreditLineMovementController::class);
        Route::apiResource('credit-drawdowns', \App\Http\Controllers\Domain\CreditDrawdownController::class);
        Route::apiResource('credit-contracts', \App\Http\Controllers\Domain\CreditContractController::class);
        Route::apiResource('credit-loans', \App\Http\Controllers\Domain\CreditLoanController::class);
        Route::apiResource('credit-loan-terms', \App\Http\Controllers\Domain\CreditLoanTermController::class);
        Route::apiResource('credit-amortization-schedules', \App\Http\Controllers\Domain\CreditAmortizationScheduleController::class);
        Route::apiResource('credit-amortization-installments', \App\Http\Controllers\Domain\CreditAmortizationInstallmentController::class);
        Route::apiResource('credit-interest-accruals', \App\Http\Controllers\Domain\CreditInterestAccrualController::class);
        Route::apiResource('credit-penalty-accruals', \App\Http\Controllers\Domain\CreditPenaltyAccrualController::class);
        Route::apiResource('credit-loan-balances', \App\Http\Controllers\Domain\CreditLoanBalanceController::class);
        Route::apiResource('credit-delinquency-snapshots', \App\Http\Controllers\Domain\CreditDelinquencySnapshotController::class);
        Route::apiResource('credit-loan-rate-revisions', \App\Http\Controllers\Domain\CreditLoanRateRevisionController::class);
        Route::apiResource('credit-business-calendars', \App\Http\Controllers\Domain\CreditBusinessCalendarController::class);
        Route::apiResource('credit-business-holidays', \App\Http\Controllers\Domain\CreditBusinessHolidayController::class);
        Route::apiResource('credit-product-calendars', \App\Http\Controllers\Domain\CreditProductCalendarController::class);
        Route::apiResource('credit-payment-channels', \App\Http\Controllers\Domain\CreditPaymentChannelController::class);
        Route::apiResource('credit-payments', \App\Http\Controllers\Domain\CreditPaymentController::class);
        Route::apiResource('credit-payment-allocations', \App\Http\Controllers\Domain\CreditPaymentAllocationController::class);
        Route::apiResource('credit-loan-ledger-entries', \App\Http\Controllers\Domain\CreditLoanLedgerEntryController::class);
        Route::apiResource('credit-loan-events', \App\Http\Controllers\Domain\CreditLoanEventController::class);
        Route::apiResource('credit-payoff-quotes', \App\Http\Controllers\Domain\CreditPayoffQuoteController::class);
        Route::apiResource('credit-payoff-quote-items', \App\Http\Controllers\Domain\CreditPayoffQuoteItemController::class);
        Route::apiResource('credit-settlements', \App\Http\Controllers\Domain\CreditSettlementController::class);
        Route::apiResource('credit-loan-restructures', \App\Http\Controllers\Domain\CreditLoanRestructureController::class);
        Route::apiResource('credit-loan-adjustments', \App\Http\Controllers\Domain\CreditLoanAdjustmentController::class);
        Route::apiResource('credit-payment-application-policies', \App\Http\Controllers\Domain\CreditPaymentApplicationPolicyController::class);
        Route::apiResource('credit-payment-application-priorities', \App\Http\Controllers\Domain\CreditPaymentApplicationPriorityController::class);
        Route::apiResource('pld-policies', \App\Http\Controllers\Domain\PldPolicyController::class);
        Route::apiResource('pld-policy-versions', \App\Http\Controllers\Domain\PldPolicyVersionController::class);
        Route::apiResource('pld-rules', \App\Http\Controllers\Domain\PldRuleController::class);
        Route::apiResource('pld-product-policies', \App\Http\Controllers\Domain\PldProductPolicyController::class);
        Route::apiResource('pld-client-profiles', \App\Http\Controllers\Domain\PldClientProfileController::class);
        Route::apiResource('pld-beneficial-owners', \App\Http\Controllers\Domain\PldBeneficialOwnerController::class);
        Route::apiResource('pld-screenings', \App\Http\Controllers\Domain\PldScreeningController::class);
        Route::apiResource('pld-monitoring-events', \App\Http\Controllers\Domain\PldMonitoringEventController::class);
        Route::apiResource('pld-alerts', \App\Http\Controllers\Domain\PldAlertController::class);
        Route::apiResource('pld-alert-actions', \App\Http\Controllers\Domain\PldAlertActionController::class);
        Route::apiResource('pld-cases', \App\Http\Controllers\Domain\PldCaseController::class);
        Route::apiResource('pld-case-events', \App\Http\Controllers\Domain\PldCaseEventController::class);
        Route::apiResource('pld-reports', \App\Http\Controllers\Domain\PldReportController::class);
    });
