<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

final class SessionMenu
{
    public function forPermissions(array $permissions, bool $isSuperadmin, ?string $appCode = null): array
    {
        $items = DB::table('menu_items')
            ->where(fn ($query) => $query->whereNull('menu_items.app_code')
                ->when($appCode !== null, fn ($q) => $q->orWhere('menu_items.app_code', $appCode)))
            ->whereNotIn('menu_items.code', [
                'credit_configuracion-sistema_versiones_productos',
                'credit_configuracion-sistema_comisiones_productos',
                'credit_configuracion-sistema_reglas_productos',
                'credit_configuracion-sistema_requisitos_documentales',
            ])
            ->leftJoin('module_actions', 'module_actions.id', '=', 'menu_items.module_action_id')
            ->orderBy('menu_items.position')
            ->orderBy('menu_items.code')
            ->get(['menu_items.*', 'module_actions.permission'])
            ->filter(fn (object $item) => $isSuperadmin || $item->module_action_id === null
                || in_array($item->permission, $permissions, true))
            ->groupBy(fn (object $item) => $item->parent_id ?? 0);

        return $this->children($items, 0);
    }

    private function children($groups, int $parent, array $visited = []): array
    {
        $result = [];
        foreach ($groups->get($parent, []) as $item) {
            if (isset($visited[$item->id])) {
                continue;
            }
            $next = $visited;
            $next[$item->id] = true;
            $children = $this->children($groups, $item->id, $next);
            if ($item->route === null && $children === []) {
                continue;
            }
            $entry = $this->entry($item);
            if ($children !== []) {
                $entry['children'] = $children;
            }
            $result[] = $entry;
        }
        return $result;
    }

    private function entry(object $item): array
    {
        return [
            'code' => $item->code,
            'text' => $item->label,
            'icon' => $item->icon,
            'routerLink' => $item->route,
        ];
    }
}
