<?php

namespace Tests\Feature;

use App\Http\Middleware\AuthenticateAccessToken;
use App\Models\CreditAdvisor;
use App\Models\CreditApplication;
use App\Models\CreditBranch;
use App\Models\CreditClient;
use App\Models\CreditClientAddress;
use App\Models\CreditClientAddressVersion;
use App\Models\CreditCompany;
use App\Models\CreditDocumentType;
use App\Models\CreditProduct;
use App\Models\CreditProductVersion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreditApplicationCaptureTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_application_with_related_records_in_one_request(): void
    {
        Storage::fake('local');
        $data = $this->setupReferences();

        $response = $this->post('/api/v1/credit-applications', [
            ...$data,
            'application_number' => 'SOL-TEST-001',
            'requested_amount' => '12500.00',
            'requested_term' => 12,
            'financial_items' => [
                [
                    'entry_type' => 'income',
                    'concept' => 'Sueldo',
                    'amount' => '25000.00',
                    'frequency' => 'monthly',
                ],
                [
                    'entry_type' => 'expense',
                    'concept' => 'Renta',
                    'amount' => '6000.00',
                    'frequency' => 'monthly',
                ],
            ],
            'documents' => [
                [
                    'document_type_id' => CreditDocumentType::firstOrFail()->id,
                    'file' => UploadedFile::fake()->create('ine.pdf', 120, 'application/pdf'),
                ],
            ],
            'consents' => [
                [
                    'consent_type' => 'privacy',
                    'version' => '1',
                    'accepted' => true,
                ],
            ],
        ], ['Accept' => 'application/json']);

        $response->assertCreated()
            ->assertJsonPath('data.status', 'captured');

        $this->assertDatabaseCount('credit_applications', 1);
        $this->assertDatabaseCount('credit_application_financial_items', 2);
        $this->assertDatabaseCount('credit_application_documents', 1);
        $this->assertDatabaseCount('credit_application_consents', 1);
        $this->assertDatabaseCount('credit_application_events', 1);

        $document = DB::table('credit_application_documents')->first();
        $this->assertNotNull($document);
        Storage::disk('local')->assertExists($document->storage_path);
    }

    public function test_adds_financial_items_in_one_batch_transaction(): void
    {
        $data = $this->setupReferences();

        $application = CreditApplication::query()->create([
            ...$data,
            'application_number' => 'SOL-TEST-BATCH',
            'requested_amount' => '12500.00',
            'requested_term' => 12,
            'created_by' => auth()->id(),
        ]);

        $this->postJson(
            '/api/v1/credit-applications/'.$application->id.'/financial-items/batch',
            [
                'items' => [
                    [
                        'entry_type' => 'income',
                        'concept' => 'Sueldo',
                        'amount' => '25000.00',
                        'frequency' => 'monthly',
                    ],
                    [
                        'entry_type' => 'expense',
                        'concept' => 'Renta',
                        'amount' => '6000.00',
                        'frequency' => 'monthly',
                    ],
                ],
            ]
        )->assertCreated()->assertJsonCount(2, 'data');

        $this->assertDatabaseCount('credit_application_financial_items', 2);
        $this->assertEqualsCanonicalizing(
            ['25000.00', '6000.00'],
            DB::table('credit_application_financial_items')
                ->pluck('amount')
                ->map(fn ($amount) => number_format((float) $amount, 2, '.', ''))
                ->all()
        );
    }

    private function setupReferences(): array
    {
        $this->withoutMiddleware(AuthenticateAccessToken::class);

        $user = new User();
        $user->forceFill([
            'name' => 'Superadministrador de pruebas',
            'email' => 'admin-fiducredit@example.test',
            'password' => 'LongTemporaryPassword123!',
            'is_superadmin' => true,
        ])->save();

        $this->actingAs($user);

        $company = CreditCompany::query()->create([
            'legal_name' => 'Institución Crédito Pruebas',
            'trade_name' => 'FiduCredit Test',
            'rfc' => 'AAA010101AAA',
        ]);

        $branch = CreditBranch::query()->create([
            'company_id' => $company->id,
            'code' => 'MTY01',
            'name' => 'Sucursal de pruebas',
            'municipality' => 'Monterrey',
            'state' => 'Nuevo León',
        ]);

        $advisor = CreditAdvisor::query()->create([
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'user_id' => $user->id,
            'employee_code' => 'ADV001',
        ]);

        $product = CreditProduct::query()->create([
            'company_id' => $company->id,
            'code' => 'PERSONAL',
            'name' => 'Crédito personal',
        ]);

        $productVersion = CreditProductVersion::query()->create([
            'product_id' => $product->id,
            'version' => 1,
            'min_amount' => '1000.00',
            'max_amount' => '100000.00',
            'min_term' => 1,
            'max_term' => 48,
            'min_annual_rate' => '0.150000',
            'max_annual_rate' => '0.400000',
        ]);

        $client = CreditClient::query()->create([
            'company_id' => $company->id,
            'first_name' => 'Cliente',
            'last_name' => 'Pruebas',
        ]);

        $address = CreditClientAddress::query()->create([
            'client_id' => $client->id,
        ]);

        $addressVersion = CreditClientAddressVersion::query()->create([
            'address_id' => $address->id,
            'version' => 1,
            'street' => 'Calle Ficticia',
            'neighborhood' => 'Centro',
            'city' => 'Monterrey',
            'municipality' => 'Monterrey',
            'state' => 'Nuevo León',
            'postal_code' => '64000',
        ]);

        CreditDocumentType::query()->create([
            'company_id' => $company->id,
            'code' => 'INE',
            'name' => 'Identificación oficial',
        ]);

        return [
            'client_id' => $client->id,
            'product_version_id' => $productVersion->id,
            'advisor_id' => $advisor->id,
            'branch_id' => $branch->id,
            'address_version_id' => $addressVersion->id,
        ];
    }
}
