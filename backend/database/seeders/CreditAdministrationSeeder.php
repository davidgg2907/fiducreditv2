<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditAdministrationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            CreditAdministrationFixtures::prepareApprovedApplication();
            $this->call([
                CreditLinePoliciesSeeder::class,
                CreditLinesSeeder::class,
                CreditLineLimitHistorySeeder::class,
                CreditLineMovementsSeeder::class,
                CreditDrawdownsSeeder::class,
                CreditContractsSeeder::class,
                CreditLoansSeeder::class,
                CreditLoanTermsSeeder::class,
                CreditAmortizationSchedulesSeeder::class,
                CreditAmortizationInstallmentsSeeder::class,
                CreditInterestAccrualsSeeder::class,
                CreditPenaltyAccrualsSeeder::class,
                CreditPaymentChannelsSeeder::class,
                CreditPaymentsSeeder::class,
                CreditPaymentAllocationsSeeder::class,
                CreditLoanLedgerEntriesSeeder::class,
                CreditLoanBalancesSeeder::class,
                CreditLoanEventsSeeder::class,
                CreditPayoffQuotesSeeder::class,
                CreditPayoffQuoteItemsSeeder::class,
                CreditSettlementsSeeder::class,
                CreditLoanRestructuresSeeder::class,
                CreditLoanAdjustmentsSeeder::class,
                CreditDelinquencySnapshotsSeeder::class,
                PldPoliciesSeeder::class,
                PldPolicyVersionsSeeder::class,
                PldRulesSeeder::class,
                PldProductPoliciesSeeder::class,
                PldClientProfilesSeeder::class,
                PldBeneficialOwnersSeeder::class,
                PldScreeningsSeeder::class,
                PldMonitoringEventsSeeder::class,
                PldAlertsSeeder::class,
                PldAlertActionsSeeder::class,
                PldCasesSeeder::class,
                PldCaseEventsSeeder::class,
                PldReportsSeeder::class,
            ]);
        });
    }
}
