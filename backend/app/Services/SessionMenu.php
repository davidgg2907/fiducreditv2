<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

final class SessionMenu
{
    public function forPermissions(array $permissions, bool $isSuperadmin): array
    {
        $items = DB::table('menu_items')
            ->leftJoin('module_actions', 'module_actions.id', '=', 'menu_items.module_action_id')
            ->orderBy('menu_items.position')
            ->orderBy('menu_items.code')
            ->get(['menu_items.*', 'module_actions.permission'])
            ->filter(fn (object $item) => $isSuperadmin || $item->module_action_id === null
                || in_array($item->permission, $permissions, true))
            ->groupBy(fn (object $item) => $item->parent_id ?? 0);

        $menu = [];
        foreach ($items->get(0, []) as $item) {
            $entry = $this->entry($item);
            if ($item->route !== null) {
                $menu[] = $entry;
                continue;
            }

            $children = [];
            foreach ($items->get($item->id, []) as $child) {
                if ($child->route !== null) {
                    $children[] = $this->entry($child);
                }
            }

            if ($children !== []) {
                $menu[] = [...$entry, 'children' => $children];
            }
        }

        return $menu;
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
