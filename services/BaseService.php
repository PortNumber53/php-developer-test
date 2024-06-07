<?php

namespace app\services;

use app\models\History;

class BaseService
{
    public static function getWidgetView()
    {
        return '_item_common';
    }

    public static function getContent($object)
    {
        return null;
    }

    public static function getComment($object = null)
    {
        return null;
    }

    public static function getIconIncome($object = null)
    {
        return null;
    }

    public static function getViewData(History $history)
    {
        return [
            'user' => $history->user,
            'body' => $history->eventText,
            'bodyDatetime' => $history->ins_ts,
            'iconClass' => 'fa-gear bg-purple-light',
        ];
    }
}
