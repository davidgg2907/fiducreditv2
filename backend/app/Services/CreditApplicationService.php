<?php

namespace App\Services;

use App\Models\CreditApplication;
use App\Repositories\CreditApplicationRepository;
use App\Repositories\CreditApplicationConsentRepository;
use App\Repositories\CreditApplicationDocumentRepository;
use App\Repositories\CreditApplicationEventRepository;
use App\Repositories\CreditApplicationFinancialItemRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;

class CreditApplicationService
{
    public function __construct(
        private readonly CreditApplicationRepository $applications,
        private readonly CreditApplicationFinancialItemRepository $financialItems,
        private readonly CreditApplicationDocumentRepository $documents,
        private readonly CreditApplicationConsentRepository $consents,
        private readonly CreditApplicationEventRepository $events
    ) {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->applications->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplication
    {
        return $this->applications->findOrFail($id, $include);
    }

    /**
     * Persist a draft and its dependent records as one logical operation.
     * Files are private and removed on DB rollback.
     */
    public function create(array $payload, int $actorId): CreditApplication
    {
        $files = [];
        $financialItems = $payload['financial_items'] ?? [];
        $documents = $payload['documents'] ?? [];
        $consents = $payload['consents'] ?? [];

        unset(
            $payload['financial_items'],
            $payload['documents'],
            $payload['consents']
        );

        $payload['created_by'] = $actorId;
        $payload['status'] = 'captured';
        $payload['version'] = 1;

        try {
            return DB::transaction(function () use (
                $payload,
                $actorId,
                $financialItems,
                $documents,
                $consents,
                &$files
            ): CreditApplication {
                $version = \App\Models\CreditProductVersion::query()->findOrFail($payload['product_version_id']);
                $application = $this->applications->create(array_merge($payload, ConfiguracionPlazos::seleccionar($version,$payload)));

                foreach ($financialItems as $item) {
                    $this->financialItems->create([
                        ...$item,
                        'application_id' => $application->id,
                        'captured_by' => $actorId,
                        'verified' => false,
                    ]);
                }

                foreach ($documents as $document) {
                    $file = $document['file'];
                    $path = Storage::disk('local')->putFile(
                        'credit/documents/'.$application->id,
                        $file
                    );

                    if (!is_string($path) || $path === '') {
                        throw new RuntimeException('No fue posible almacenar el documento.');
                    }

                    $files[] = $path;

                    $this->documents->create([
                        'application_id' => $application->id,
                        'document_type_id' => $document['document_type_id'],
                        'version' => 1,
                        'storage_disk' => 'local',
                        'storage_path' => $path,
                        'original_filename' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType() ?? 'application/octet-stream',
                        'size_bytes' => $file->getSize(),
                        'sha256' => hash_file('sha256', $file->getRealPath()),
                        'status' => 'pending',
                        'uploaded_by' => $actorId,
                    ]);
                }

                foreach ($consents as $consent) {
                    $this->consents->create([
                        ...$consent,
                        'application_id' => $application->id,
                        'accepted_at' => $consent['accepted'] ? now() : null,
                    ]);
                }

                $this->events->create([
                    'application_id' => $application->id,
                    'actor_id' => $actorId,
                    'event_type' => 'application_created',
                    'after_data' => [
                        'status' => 'captured',
                        'document_count' => count($documents),
                        'financial_item_count' => count($financialItems),
                    ],
                    'ip_address' => request()->ip(),
                    'occurred_at' => now(),
                ]);

                return $application->load([
                    'creditApplicationFinancialItems',
                    'creditApplicationDocuments',
                    'creditApplicationConsents',
                ]);
            });
        } catch (Throwable $exception) {
            if ($files !== []) {
                Storage::disk('local')->delete($files);
            }

            throw $exception;
        }
    }

    public function update(string $id, array $attributes): CreditApplication
    {
        return DB::transaction(function () use ($id, $attributes): CreditApplication {
            $application = CreditApplication::query()
                ->lockForUpdate()
                ->findOrFail($id);

            if ($application->status !== 'captured') {
                throw ValidationException::withMessages([
                    'status' => 'Solo se permite modificar solicitudes en captura.',
                ]);
            }

            $datos = array_merge($application->getAttributes(),$attributes);
            $version = \App\Models\CreditProductVersion::query()->findOrFail($datos['product_version_id']);
            return $this->applications->update($id, array_merge($attributes, ConfiguracionPlazos::seleccionar($version,$datos)));
        });
    }
}
