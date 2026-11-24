<?php
namespace App\Repositories\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;

/**
 * Búsqueda textual por campos del módulo y relaciones declaradas de configuración.
 * No recorre información operativa, PLD ni datos personales de clientes.
 */
trait SearchAcrossRelations
{
    private function applyGlobalSearch(Builder $query, string $value): void
    {
        $search = trim($value);
        if ($search === '') return;
        $model = $query->getModel();
        $allowedTables = [
            'credit_companies', 'credit_branches', 'credit_advisors',
            'credit_products', 'credit_product_versions', 'credit_product_fees',
            'credit_product_rules', 'credit_custom_fields', 'credit_product_documents',
            'credit_document_types', 'credit_document_validation_rules',
            'credit_business_calendars', 'credit_business_holidays',
            'credit_workflows', 'credit_workflow_versions', 'credit_workflow_steps',
            'credit_workflow_transitions', 'credit_workflow_step_roles',
            'credit_workflow_step_rules', 'credit_workflow_sla',
            'credit_line_policies', 'credit_payment_application_policies',
            'credit_payment_application_priorities',
        ];
        $fields = function (string $table): array {
            return array_values(array_filter(Schema::getColumnListing($table), static function ($field) use ($table) {
                if (preg_match('/(password|secret|token|credential|private|hash)/i', $field)) return false;
                return in_array(Schema::getColumnType($table, $field), ['string','varchar','char','text','mediumtext','longtext'], true);
            }));
        };
        $relations = [];
        foreach ((new ReflectionClass($model))->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getDeclaringClass()->getName() !== get_class($model) || $method->getNumberOfRequiredParameters() !== 0) continue;
            $type = $method->getReturnType();
            if (!$type instanceof \ReflectionNamedType || !is_a($type->getName(), Relation::class, true)) continue;
            $relation = $model->{$method->getName()}();
            $table = $relation->getRelated()->getTable();
            if (in_array($table, $allowedTables, true) && count($relations) < 8) {
                $relations[] = [$method->getName(), $table];
            }
        }
        $like = '%'.addcslashes($search, '%_\\').'%';
        $query->where(function (Builder $sub) use ($model, $fields, $relations, $like) {
            foreach ($fields($model->getTable()) as $field) {
                $sub->orWhere($model->qualifyColumn($field), 'like', $like);
            }
            foreach ($relations as [$name, $table]) {
                $relatedFields = $fields($table);
                if (!$relatedFields) continue;
                $sub->orWhereHas($name, function (Builder $related) use ($relatedFields, $like) {
                    $related->where(function (Builder $nested) use ($relatedFields, $related, $like) {
                        foreach ($relatedFields as $field) $nested->orWhere($related->getModel()->qualifyColumn($field), 'like', $like);
                    });
                });
            }
        });
    }
}
