<?php

use App\Http\Controllers\AccessRoleController;
use App\Http\Controllers\AccessUserController;
use App\Http\Controllers\AccessCatalogController;
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

Route::middleware([AuthenticateAccessToken::class, \App\Http\Middleware\RecordOperationalRequest::class])->group(function (): void {
    Route::get('me', [AuthController::class, 'me']);
    Route::get('access/operational-dashboard', [\App\Http\Controllers\OperationalDashboardController::class, 'index'])->middleware('can:manage-access');
    Route::prefix('access')->middleware('can:manage-access')->group(function (): void {
        Route::get('catalog', [AccessRoleController::class, 'catalog']);
        Route::get('roles', [AccessRoleController::class, 'index']);
        Route::get('roles/{role}', [AccessRoleController::class, 'show'])->whereNumber('role');
        Route::delete('roles/{role}', [AccessRoleController::class, 'destroy'])->whereNumber('role');
        Route::get('users', [AccessUserController::class, 'index']);
        Route::post('users', [AccessUserController::class, 'store']);
        Route::get('users/{user}', [AccessUserController::class, 'show'])->whereNumber('user');
        Route::put('users/{user}', [AccessUserController::class, 'update'])->whereNumber('user');
        Route::patch('users/{user}', [AccessUserController::class, 'update'])->whereNumber('user');
        Route::patch('users/{user}/status', [AccessUserController::class, 'setStatus'])->whereNumber('user');
        Route::get('modules', [AccessCatalogController::class, 'modules']);
        Route::get('modules/{module}', [AccessCatalogController::class, 'module'])->whereNumber('module');
        Route::post('modules', [AccessCatalogController::class, 'storeModule']);
        Route::put('modules/{module}', [AccessCatalogController::class, 'updateModule'])->whereNumber('module');
        Route::delete('modules/{module}', [AccessCatalogController::class, 'deleteModule'])->whereNumber('module');
        Route::get('actions', [AccessCatalogController::class, 'actions']);
        Route::get('actions/{action}', [AccessCatalogController::class, 'action'])->whereNumber('action');
        Route::post('actions', [AccessCatalogController::class, 'storeAction']);
        Route::put('actions/{action}', [AccessCatalogController::class, 'updateAction'])->whereNumber('action');
        Route::delete('actions/{action}', [AccessCatalogController::class, 'deleteAction'])->whereNumber('action');
        Route::get('menus', [AccessCatalogController::class, 'menus']);
        Route::get('menus/{menu}', [AccessCatalogController::class, 'menu'])->whereNumber('menu');
        Route::post('menus', [AccessCatalogController::class, 'storeMenu']);
        Route::put('menus/{menu}', [AccessCatalogController::class, 'updateMenu'])->whereNumber('menu');
        Route::delete('menus/{menu}', [AccessCatalogController::class, 'deleteMenu'])->whereNumber('menu');
        Route::post('roles', [AccessRoleController::class, 'store']);
        Route::put('roles/{role}', [AccessRoleController::class, 'update'])->whereNumber('role');
        Route::put('users/{user}/role', [AccessRoleController::class, 'assign'])->whereNumber('user');
    });

    Route::get('perfil', [AuthController::class, 'profile']);
    Route::post('perfil', [AuthController::class, 'updateProfile'])->middleware('throttle:auth-sensitive');
    Route::post('perfil/contrasena', [AuthController::class, 'updatePassword'])->middleware('throttle:auth-sensitive');
});


// Captura masiva transaccional de ingresos y egresos de una solicitud.
Route::middleware([AuthenticateAccessToken::class, \App\Http\Middleware\RecordOperationalRequest::class])
    ->post(
        'v1/credit-applications/{id}/financial-items/batch',
        [\App\Http\Controllers\CreditApplicationFinancialItemController::class, 'storeBatch']
    );

// Los cinco frontends comparten estos recursos. Solo acceso administrativo
// hasta implementar políticas operativas por empresa, sucursal y flujo.
Route::middleware([AuthenticateAccessToken::class, \App\Http\Middleware\RecordOperationalRequest::class])
    ->prefix('v1')
    ->group(function (): void {
        Route::apiResource(
            'credit-companies',
            \App\Http\Controllers\CreditCompanyController::class
        )->parameters([
            'credit-companies' => 'id',
        ]);
        Route::apiResource(
            'credit-branches',
            \App\Http\Controllers\CreditBranchController::class
        )->parameters([
            'credit-branches' => 'id',
        ]);
        Route::apiResource(
            'credit-advisors',
            \App\Http\Controllers\CreditAdvisorController::class
        )->parameters([
            'credit-advisors' => 'id',
        ]);
        Route::apiResource(
            'credit-products',
            \App\Http\Controllers\CreditProductController::class
        )->parameters([
            'credit-products' => 'id',
        ]);
        Route::apiResource(
            'credit-product-versions',
            \App\Http\Controllers\CreditProductVersionController::class
        )->parameters([
            'credit-product-versions' => 'id',
        ]);
        Route::apiResource(
            'credit-product-fees',
            \App\Http\Controllers\CreditProductFeeController::class
        )->parameters([
            'credit-product-fees' => 'id',
        ]);
        Route::apiResource(
            'credit-product-rules',
            \App\Http\Controllers\CreditProductRuleController::class
        )->parameters([
            'credit-product-rules' => 'id',
        ]);
        Route::apiResource(
            'credit-custom-fields',
            \App\Http\Controllers\CreditCustomFieldController::class
        )->parameters([
            'credit-custom-fields' => 'id',
        ]);
        Route::apiResource(
            'credit-product-fields',
            \App\Http\Controllers\CreditProductFieldController::class
        )->parameters([
            'credit-product-fields' => 'id',
        ]);
        Route::apiResource(
            'credit-clients',
            \App\Http\Controllers\CreditClientController::class
        )->parameters([
            'credit-clients' => 'id',
        ]);
        Route::apiResource(
            'credit-client-addresses',
            \App\Http\Controllers\CreditClientAddressController::class
        )->parameters([
            'credit-client-addresses' => 'id',
        ]);
        Route::apiResource(
            'credit-client-address-versions',
            \App\Http\Controllers\CreditClientAddressVersionController::class
        )->parameters([
            'credit-client-address-versions' => 'id',
        ]);
        Route::apiResource(
            'credit-client-bank-accounts',
            \App\Http\Controllers\CreditClientBankAccountController::class
        )->parameters([
            'credit-client-bank-accounts' => 'id',
        ]);
        Route::apiResource(
            'credit-document-types',
            \App\Http\Controllers\CreditDocumentTypeController::class
        )->parameters([
            'credit-document-types' => 'id',
        ]);
        Route::apiResource(
            'credit-document-validation-rules',
            \App\Http\Controllers\CreditDocumentValidationRuleController::class
        )->parameters([
            'credit-document-validation-rules' => 'id',
        ]);
        Route::apiResource(
            'credit-product-documents',
            \App\Http\Controllers\CreditProductDocumentController::class
        )->parameters([
            'credit-product-documents' => 'id',
        ]);
        Route::apiResource(
            'credit-applications',
            \App\Http\Controllers\CreditApplicationController::class
        )->parameters([
            'credit-applications' => 'id',
        ]);
        Route::apiResource(
            'credit-application-fields',
            \App\Http\Controllers\CreditApplicationFieldController::class
        )->parameters([
            'credit-application-fields' => 'id',
        ]);
        Route::apiResource(
            'credit-application-documents',
            \App\Http\Controllers\CreditApplicationDocumentController::class
        )->parameters([
            'credit-application-documents' => 'id',
        ]);
        Route::apiResource(
            'credit-document-checks',
            \App\Http\Controllers\CreditDocumentCheckController::class
        )->parameters([
            'credit-document-checks' => 'id',
        ]);
        Route::apiResource(
            'credit-application-financial-items',
            \App\Http\Controllers\CreditApplicationFinancialItemController::class
        )->parameters([
            'credit-application-financial-items' => 'id',
        ]);
        Route::apiResource(
            'credit-application-financial-summaries',
            \App\Http\Controllers\CreditApplicationFinancialSummaryController::class
        )->parameters([
            'credit-application-financial-summaries' => 'id',
        ]);
        Route::apiResource(
            'credit-bureau-inquiries',
            \App\Http\Controllers\CreditBureauInquiryController::class
        )->parameters([
            'credit-bureau-inquiries' => 'id',
        ]);
        Route::apiResource(
            'credit-application-analyses',
            \App\Http\Controllers\CreditApplicationAnalyseController::class
        )->parameters([
            'credit-application-analyses' => 'id',
        ]);
        Route::apiResource(
            'credit-application-decisions',
            \App\Http\Controllers\CreditApplicationDecisionController::class
        )->parameters([
            'credit-application-decisions' => 'id',
        ]);
        Route::apiResource(
            'credit-application-status-history',
            \App\Http\Controllers\CreditApplicationStatusHistoryController::class
        )->parameters([
            'credit-application-status-history' => 'id',
        ]);
        Route::apiResource(
            'credit-application-events',
            \App\Http\Controllers\CreditApplicationEventController::class
        )->parameters([
            'credit-application-events' => 'id',
        ]);
        Route::apiResource(
            'credit-application-consents',
            \App\Http\Controllers\CreditApplicationConsentController::class
        )->parameters([
            'credit-application-consents' => 'id',
        ]);
        Route::apiResource(
            'credit-application-guarantors',
            \App\Http\Controllers\CreditApplicationGuarantorController::class
        )->parameters([
            'credit-application-guarantors' => 'id',
        ]);
        Route::apiResource(
            'credit-application-conditions',
            \App\Http\Controllers\CreditApplicationConditionController::class
        )->parameters([
            'credit-application-conditions' => 'id',
        ]);
        Route::apiResource(
            'credit-workflows',
            \App\Http\Controllers\CreditWorkflowController::class
        )->parameters([
            'credit-workflows' => 'id',
        ]);
        Route::apiResource(
            'credit-workflow-versions',
            \App\Http\Controllers\CreditWorkflowVersionController::class
        )->parameters([
            'credit-workflow-versions' => 'id',
        ]);
        Route::apiResource(
            'credit-workflow-steps',
            \App\Http\Controllers\CreditWorkflowStepController::class
        )->parameters([
            'credit-workflow-steps' => 'id',
        ]);
        Route::apiResource(
            'credit-workflow-transitions',
            \App\Http\Controllers\CreditWorkflowTransitionController::class
        )->parameters([
            'credit-workflow-transitions' => 'id',
        ]);
        Route::apiResource(
            'credit-workflow-step-roles',
            \App\Http\Controllers\CreditWorkflowStepRoleController::class
        )->parameters([
            'credit-workflow-step-roles' => 'id',
        ]);
        Route::apiResource(
            'credit-workflow-step-rules',
            \App\Http\Controllers\CreditWorkflowStepRuleController::class
        )->parameters([
            'credit-workflow-step-rules' => 'id',
        ]);
        Route::apiResource(
            'credit-workflow-instances',
            \App\Http\Controllers\CreditWorkflowInstanceController::class
        )->parameters([
            'credit-workflow-instances' => 'id',
        ]);
        Route::apiResource(
            'credit-workflow-tasks',
            \App\Http\Controllers\CreditWorkflowTaskController::class
        )->parameters([
            'credit-workflow-tasks' => 'id',
        ]);
        Route::apiResource(
            'credit-workflow-task-history',
            \App\Http\Controllers\CreditWorkflowTaskHistoryController::class
        )->parameters([
            'credit-workflow-task-history' => 'id',
        ]);
        Route::apiResource(
            'credit-workflow-sla',
            \App\Http\Controllers\CreditWorkflowSlaController::class
        )->parameters([
            'credit-workflow-sla' => 'id',
        ]);
        Route::apiResource(
            'credit-line-policies',
            \App\Http\Controllers\CreditLinePolicyController::class
        )->parameters([
            'credit-line-policies' => 'id',
        ]);
        Route::apiResource(
            'credit-lines',
            \App\Http\Controllers\CreditLineController::class
        )->parameters([
            'credit-lines' => 'id',
        ]);
        Route::apiResource(
            'credit-line-limit-history',
            \App\Http\Controllers\CreditLineLimitHistoryController::class
        )->parameters([
            'credit-line-limit-history' => 'id',
        ]);
        Route::apiResource(
            'credit-line-movements',
            \App\Http\Controllers\CreditLineMovementController::class
        )->parameters([
            'credit-line-movements' => 'id',
        ]);
        Route::apiResource(
            'credit-drawdowns',
            \App\Http\Controllers\CreditDrawdownController::class
        )->parameters([
            'credit-drawdowns' => 'id',
        ]);
        Route::apiResource(
            'credit-contracts',
            \App\Http\Controllers\CreditContractController::class
        )->parameters([
            'credit-contracts' => 'id',
        ]);
        Route::apiResource(
            'credit-loans',
            \App\Http\Controllers\CreditLoanController::class
        )->parameters([
            'credit-loans' => 'id',
        ]);
        Route::apiResource(
            'credit-loan-terms',
            \App\Http\Controllers\CreditLoanTermController::class
        )->parameters([
            'credit-loan-terms' => 'id',
        ]);
        Route::apiResource(
            'credit-amortization-schedules',
            \App\Http\Controllers\CreditAmortizationScheduleController::class
        )->parameters([
            'credit-amortization-schedules' => 'id',
        ]);
        Route::apiResource(
            'credit-amortization-installments',
            \App\Http\Controllers\CreditAmortizationInstallmentController::class
        )->parameters([
            'credit-amortization-installments' => 'id',
        ]);
        Route::apiResource(
            'credit-interest-accruals',
            \App\Http\Controllers\CreditInterestAccrualController::class
        )->parameters([
            'credit-interest-accruals' => 'id',
        ]);
        Route::apiResource(
            'credit-penalty-accruals',
            \App\Http\Controllers\CreditPenaltyAccrualController::class
        )->parameters([
            'credit-penalty-accruals' => 'id',
        ]);
        Route::apiResource(
            'credit-loan-balances',
            \App\Http\Controllers\CreditLoanBalanceController::class
        )->parameters([
            'credit-loan-balances' => 'id',
        ]);
        Route::apiResource(
            'credit-delinquency-snapshots',
            \App\Http\Controllers\CreditDelinquencySnapshotController::class
        )->parameters([
            'credit-delinquency-snapshots' => 'id',
        ]);
        Route::apiResource(
            'credit-loan-rate-revisions',
            \App\Http\Controllers\CreditLoanRateRevisionController::class
        )->parameters([
            'credit-loan-rate-revisions' => 'id',
        ]);
        Route::apiResource(
            'credit-business-calendars',
            \App\Http\Controllers\CreditBusinessCalendarController::class
        )->parameters([
            'credit-business-calendars' => 'id',
        ]);
        Route::apiResource(
            'credit-business-holidays',
            \App\Http\Controllers\CreditBusinessHolidayController::class
        )->parameters([
            'credit-business-holidays' => 'id',
        ]);
        Route::apiResource(
            'credit-product-calendars',
            \App\Http\Controllers\CreditProductCalendarController::class
        )->parameters([
            'credit-product-calendars' => 'id',
        ]);
        Route::apiResource(
            'credit-payment-channels',
            \App\Http\Controllers\CreditPaymentChannelController::class
        )->parameters([
            'credit-payment-channels' => 'id',
        ]);
        Route::apiResource(
            'credit-payments',
            \App\Http\Controllers\CreditPaymentController::class
        )->parameters([
            'credit-payments' => 'id',
        ]);
        Route::apiResource(
            'credit-payment-allocations',
            \App\Http\Controllers\CreditPaymentAllocationController::class
        )->parameters([
            'credit-payment-allocations' => 'id',
        ]);
        Route::apiResource(
            'credit-loan-ledger-entries',
            \App\Http\Controllers\CreditLoanLedgerEntryController::class
        )->parameters([
            'credit-loan-ledger-entries' => 'id',
        ]);
        Route::apiResource(
            'credit-loan-events',
            \App\Http\Controllers\CreditLoanEventController::class
        )->parameters([
            'credit-loan-events' => 'id',
        ]);
        Route::apiResource(
            'credit-payoff-quotes',
            \App\Http\Controllers\CreditPayoffQuoteController::class
        )->parameters([
            'credit-payoff-quotes' => 'id',
        ]);
        Route::apiResource(
            'credit-payoff-quote-items',
            \App\Http\Controllers\CreditPayoffQuoteItemController::class
        )->parameters([
            'credit-payoff-quote-items' => 'id',
        ]);
        Route::apiResource(
            'credit-settlements',
            \App\Http\Controllers\CreditSettlementController::class
        )->parameters([
            'credit-settlements' => 'id',
        ]);
        Route::apiResource(
            'credit-loan-restructures',
            \App\Http\Controllers\CreditLoanRestructureController::class
        )->parameters([
            'credit-loan-restructures' => 'id',
        ]);
        Route::apiResource(
            'credit-loan-adjustments',
            \App\Http\Controllers\CreditLoanAdjustmentController::class
        )->parameters([
            'credit-loan-adjustments' => 'id',
        ]);
        Route::apiResource(
            'credit-payment-application-policies',
            \App\Http\Controllers\CreditPaymentApplicationPolicyController::class
        )->parameters([
            'credit-payment-application-policies' => 'id',
        ]);
        Route::apiResource(
            'credit-payment-application-priorities',
            \App\Http\Controllers\CreditPaymentApplicationPriorityController::class
        )->parameters([
            'credit-payment-application-priorities' => 'id',
        ]);
        Route::apiResource(
            'pld-policies',
            \App\Http\Controllers\PldPolicyController::class
        )->parameters([
            'pld-policies' => 'id',
        ]);
        Route::apiResource(
            'pld-policy-versions',
            \App\Http\Controllers\PldPolicyVersionController::class
        )->parameters([
            'pld-policy-versions' => 'id',
        ]);
        Route::apiResource(
            'pld-rules',
            \App\Http\Controllers\PldRuleController::class
        )->parameters([
            'pld-rules' => 'id',
        ]);
        Route::apiResource(
            'pld-product-policies',
            \App\Http\Controllers\PldProductPolicyController::class
        )->parameters([
            'pld-product-policies' => 'id',
        ]);
        Route::apiResource(
            'pld-client-profiles',
            \App\Http\Controllers\PldClientProfileController::class
        )->parameters([
            'pld-client-profiles' => 'id',
        ]);
        Route::apiResource(
            'pld-beneficial-owners',
            \App\Http\Controllers\PldBeneficialOwnerController::class
        )->parameters([
            'pld-beneficial-owners' => 'id',
        ]);
        Route::apiResource(
            'pld-screenings',
            \App\Http\Controllers\PldScreeningController::class
        )->parameters([
            'pld-screenings' => 'id',
        ]);
        Route::apiResource(
            'pld-monitoring-events',
            \App\Http\Controllers\PldMonitoringEventController::class
        )->parameters([
            'pld-monitoring-events' => 'id',
        ]);
        Route::apiResource(
            'pld-alerts',
            \App\Http\Controllers\PldAlertController::class
        )->parameters([
            'pld-alerts' => 'id',
        ]);
        Route::apiResource(
            'pld-alert-actions',
            \App\Http\Controllers\PldAlertActionController::class
        )->parameters([
            'pld-alert-actions' => 'id',
        ]);
        Route::apiResource(
            'pld-cases',
            \App\Http\Controllers\PldCaseController::class
        )->parameters([
            'pld-cases' => 'id',
        ]);
        Route::apiResource(
            'pld-case-events',
            \App\Http\Controllers\PldCaseEventController::class
        )->parameters([
            'pld-case-events' => 'id',
        ]);
        Route::apiResource(
            'pld-reports',
            \App\Http\Controllers\PldReportController::class
        )->parameters([
            'pld-reports' => 'id',
        ]);
    });
