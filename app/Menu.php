<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * 格式化菜单数据
     * @param $menuData
     * @param array $finalMenuData
     * @return array
     */
    public static function formatMenu(&$menuData, &$finalMenuData = [])
    {
        foreach ($menuData as $key => $item) {
            if ($item['parent_id'] === 0) {
                $finalMenuData[] = $item;
                continue;
            }
            self::formatMenuByParentId($item, $finalMenuData);

        }
        return $finalMenuData;
    }

    /**
     * 通过parent_id 格式化菜单数据
     * @param $item
     * @param array $finalMenuData
     */
    public static function formatMenuByParentId($item, &$finalMenuData = [])
    {
        foreach ($finalMenuData as &$value) {
            if ($item['parent_id'] === $value['id']) {
                $value['node'][] = $item;
                continue;
            }
            if (!empty($value['node'])) {
                self::formatMenuByParentId($item, $value['node']);
            }
        }
    }
}
