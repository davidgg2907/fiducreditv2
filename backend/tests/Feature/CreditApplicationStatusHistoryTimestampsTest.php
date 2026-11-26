<?php

namespace Tests\Feature;

use App\Models\CreditApplicationStatusHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CreditApplicationStatusHistoryTimestampsTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_history_uses_changed_at_without_eloquent_timestamps(): void
    {
        $model = new CreditApplicationStatusHistory();

        $this->assertFalse($model->usesTimestamps());

        $columns = DB::getSchemaBuilder()->getColumnListing('credit_application_status_history');
        $this->assertContains('changed_at', $columns);
        $this->assertNotContains('created_at', $columns);
        $this->assertNotContains('updated_at', $columns);
    }
}
