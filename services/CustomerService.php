<?php

namespace app\services;

use Yii;
use app\models\Call;
use app\models\Customer;
use app\models\History;

class CustomerService extends BaseService
{
    public static function getWidgetView()
    {
        return '_item_statuses_change';
    }

    /**
     * @return string
     */
    public function getClient_phone($object = null)
    {
        return $object->direction == Call::DIRECTION_INCOMING ? $object->phone_from : $object->phone_to;
    }

    public static function getTypeOldValue($model)
    {
        return Customer::getTypeTextByType($model->getDetailOldValue('type'));
    }

    public static function getTypeNewValue($model)
    {
        return Customer::getTypeTextByType($model->getDetailNewValue('type'));
    }

    public static function getQualityTextByQuality($quality)
    {
        return Customer::getQualityTexts()[$quality] ?? $quality;
    }

    public static function getViewData(History $history)
    {
        switch ($history->event) {
            case History::EVENT_CUSTOMER_CHANGE_TYPE:
                $oldValue = self::getTypeOldValue($history);
                $newValue = self::getTypeNewValue($history);
                break;
            case History::EVENT_CUSTOMER_CHANGE_QUALITY:
                $oldValue = self::getQualityTextByQuality($history->getDetailOldValue('quality'));
                $newValue = self::getQualityTextByQuality($history->getDetailNewValue('quality'));
                break;
        }
        return [
            'model' => $history,
            'oldValue' => $oldValue,
            'newValue' => $newValue,
        ];
    }
}
