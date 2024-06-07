<?php

namespace app\services;

use Yii;

use app\models\Sms;
use app\models\History;

class SmsService extends BaseService
{
    /**
     * @return array
     */
    public static function getStatusTexts()
    {
        return [
            Sms::STATUS_NEW => Yii::t('app', 'New'),
            Sms::STATUS_READ => Yii::t('app', 'Read'),
            Sms::STATUS_ANSWERED => Yii::t('app', 'Answered'),

            Sms::STATUS_DRAFT => Yii::t('app', 'Draft'),
            Sms::STATUS_WAIT => Yii::t('app', 'Wait'),
            Sms::STATUS_SENT => Yii::t('app', 'Sent'),
            Sms::STATUS_DELIVERED => Yii::t('app', 'Delivered'),
        ];
    }

    /**
     * @param $value
     * @return mixed
     */
    public static function getStatusTextByValue($value)
    {
        return self::getStatusTexts()[$value] ?? $value;
    }

    /**
     * @return mixed|string
     */
    public function getStatusText(Sms $sms)
    {
        return self::getStatusTextByValue($sms->status);
    }

    /**
     * @return array
     */
    public static function getDirectionTexts()
    {
        return [
            Sms::DIRECTION_INCOMING => Yii::t('app', 'Incoming'),
            Sms::DIRECTION_OUTGOING => Yii::t('app', 'Outgoing'),
        ];
    }

    /**
     * @param $value
     * @return mixed
     */
    public static function getDirectionTextByValue($value)
    {
        return self::getDirectionTexts()[$value] ?? $value;
    }

    /**
     * @return mixed|string
     */
    public function getDirectionText(Sms $sms)
    {
        return self::getDirectionTextByValue($sms->direction);
    }

    public static function getBody(History $history)
    {
        return isset($history->sms) ? ($history->sms->message ? $history->sms->message : '') : '';
    }

    public static function getFooter($object)
    {
        return $object ? ($object->direction == Sms::DIRECTION_INCOMING ?
            Yii::t('app', 'Incoming message from {number}', [
                'number' => $object->phone_from ?? ''
            ]) : Yii::t('app', 'Sent message to {number}', [
                'number' => $object->phone_to ?? ''
            ])) : '***';
    }

    public static function getIconClass()
    {
        return 'icon-sms bg-dark-blue';
    }

    public static function getIconIncome($object = null)
    {
        return $object ? ($object->direction == Sms::DIRECTION_INCOMING) : '';
    }

    public static function getViewData(History $history)
    {
        return [
            'user' => $history->user,
            'body' => SmsService::getBody($history),
            'footer' => $history->sms ? ($history->sms->direction == Sms::DIRECTION_INCOMING ?
                Yii::t('app', 'Incoming message from {number}', [
                    'number' => $history->sms->phone_from ?? ''
                ]) : Yii::t('app', 'Sent message to {number}', [
                    'number' => $history->sms->phone_to ?? ''
                ])) : '***',
            'footerDatetime' => $history->ins_ts,
            'iconIncome' => $history->sms ? ($history->sms->direction == Sms::DIRECTION_INCOMING) : '',
            'iconClass' => 'icon-sms bg-dark-blue',
        ];
    }
}
