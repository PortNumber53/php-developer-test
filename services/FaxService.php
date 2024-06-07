<?php

namespace app\services;

use Yii;
use yii\helpers\Html;


use app\models\Fax;
use app\models\History;

class FaxService extends BaseService
{
    /**
     * @return array
     */
    public static function getTypeTexts()
    {
        return [
            Fax::TYPE_POA_ATC => Yii::t('app', 'POA/ATC'),
            Fax::TYPE_REVOCATION_NOTICE => Yii::t('app', 'Revocation'),
        ];
    }

    /**
     * @return mixed|string
     */
    public function getTypeText(Fax $fax)
    {
        return self::getTypeTexts()[$fax->type] ?? $fax->type;
    }

    public static function getBody(History $history)
    {
        $eventType = $history->event;
        $types = [
            Fax::EVENT_INCOMING_FAX => Yii::t('app', 'Incoming fax'),
            Fax::EVENT_OUTGOING_FAX => Yii::t('app', 'Outgoing fax'),
        ];
        // return $types[$eventType];
        $object = $history->{$history->object};

        $body = $types[$eventType] . ' - ' .
            (isset($object->document) ? Html::a(
                Yii::t('app', 'view document'),
                $object->document->getViewUrl(),
                [
                    'target' => '_blank',
                    'data-pjax' => 0,
                ]
            ) : '');

        return $body;
    }

    public static function getFooter($object)
    {
        return Yii::t('app', '{type} was sent to {group}', [
            'type' => $object ? 'fix_this' . $object->getTypeText() : 'Fax',
            'group' => isset($object->creditorGroup) ? Html::a($object->creditorGroup->name, ['creditors/groups'], ['data-pjax' => 0]) : ''
        ]);
    }


    public static function getIconClass()
    {
        return 'fa-fax bg-green';
    }

    public static function getViewData(History $history)
    {
        $fax = $history->fax;
        return [
            'user' => $history->user,
            'body' => self::getBody($history) .
                ' - ' .
                (isset($fax->document) ? Html::a(
                    Yii::t('app', 'view document'),
                    $fax->document->getViewUrl(),
                    [
                        'target' => '_blank',
                        'data-pjax' => 0
                    ]
                ) : ''),
            'footer' => Yii::t('app', '{type} was sent to {group}', [
                'type' => $fax ? $fax->getTypeText() : 'Fax',
                'group' => isset($fax->creditorGroup) ? Html::a($fax->creditorGroup->name, ['creditors/groups'], ['data-pjax' => 0]) : ''
            ]),
            'footerDatetime' => $history->ins_ts,
            'iconClass' => 'fa-fax bg-green',
        ];
    }
}
