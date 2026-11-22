<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditOriginacionSeeder extends Seeder {
    public function run(): void {
        $this->call([
            CreditCompaniesSeeder::class,
            CreditBranchesSeeder::class,
            CreditAdvisorsSeeder::class,
            CreditProductsSeeder::class,
            CreditProductVersionsSeeder::class,
            CreditProductFeesSeeder::class,
            CreditProductRulesSeeder::class,
            CreditCustomFieldsSeeder::class,
            CreditProductFieldsSeeder::class,
            CreditClientsSeeder::class,
            CreditClientAddressesSeeder::class,
            CreditClientAddressVersionsSeeder::class,
            CreditClientBankAccountsSeeder::class,
            CreditDocumentTypesSeeder::class,
            CreditDocumentValidationRulesSeeder::class,
            CreditProductDocumentsSeeder::class,
            CreditApplicationsSeeder::class,
            CreditApplicationFieldsSeeder::class,
            CreditApplicationDocumentsSeeder::class,
            CreditDocumentChecksSeeder::class,
            CreditApplicationFinancialItemsSeeder::class,
            CreditApplicationFinancialSummariesSeeder::class,
            CreditBureauInquiriesSeeder::class,
            CreditApplicationAnalysesSeeder::class,
            CreditApplicationDecisionsSeeder::class,
            CreditApplicationStatusHistorySeeder::class,
            CreditApplicationEventsSeeder::class,
            CreditApplicationConsentsSeeder::class,
            CreditApplicationGuarantorsSeeder::class,
            CreditApplicationConditionsSeeder::class,
        ]);
    }
}
