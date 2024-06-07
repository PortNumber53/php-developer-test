<?php

namespace app\services;

use Yii;
use app\models\Call;
use app\models\History;

class CallService extends BaseService
{
    /**
     * @return mixed|string
     */
    public static function getFullDirectionText(Call $call)
    {
        return self::getFullDirectionTexts()[$call->direction] ?? $call->direction;
    }

    /**
     * @return array
     */
    public static function getFullDirectionTexts()
    {
        return [
            Call::DIRECTION_INCOMING => Yii::t('app', 'Incoming Call'),
            Call::DIRECTION_OUTGOING => Yii::t('app', 'Outgoing Call'),
        ];
    }

    /**
     * @return string
     */
    public static function getDurationText(Call $call)
    {
        if (!is_null($call->duration)) {
            return $call->duration >= 3600 ? gmdate("H:i:s", $call->duration) : gmdate("i:s", $call->duration);
        }
        return '00:00';
    }

    /**
     * @param bool $hasComment
     * @return string
     */
    public static function getTotalDisposition(Call $call, $hasComment = true)
    {
        $t = [];
        if ($hasComment && $call->comment) {
            $t[] = $call->comment;
        }
        return implode(': ', $t);
    }

    /**
     * @return mixed|string
     */
    public static function getTotalStatusText(Call $call)
    {
        if (
            $call->status == Call::STATUS_NO_ANSWERED
            && $call->direction == Call::DIRECTION_INCOMING
        ) {
            return Yii::t('app', 'Missed Call');
        }

        if (
            $call->status == Call::STATUS_NO_ANSWERED
            && $call->direction == Call::DIRECTION_OUTGOING
        ) {
            return Yii::t('app', 'Client No Answer');
        }

        $msg = self::getFullDirectionText($call);

        if ($call->duration) {
            $msg .= ' (' . self::getDurationText($call) . ')';
        }

        return $msg;
    }

    public static function getBody(History $model)
    {
        $call = $model->call;
        return ($call ?
            self::getTotalStatusText($call)
            . (self::getTotalDisposition($call, false) ? " <span class='text-grey'>" . CallService::getTotalDisposition($call, false) . "</span>" : "")
            : '<i>Deleted</i> ');
    }

    public static function getIconClass(Call $call = null)
    {
        $answered = $call && $call->status == Call::STATUS_ANSWERED;

        return $answered && $call->direction == Call::DIRECTION_INCOMING;
    }

    public static function getComment($object = null)
    {
        return $object->comment ?? '';
    }

    public static function getFooter($object)
    {
        return isset($object->applicant) ? "Called <span>{$object->applicant->name}</span>" : null;
    }

    public static function getIconIncome($object = null)
    {
        $answered = $object && $object->status == Call::STATUS_ANSWERED;

        return $answered && $object->direction == Call::DIRECTION_INCOMING;
    }

    public static function getViewData(History $history)
    {
        $call = $history->call;

        $answered = $call && $call->status == Call::STATUS_ANSWERED;

        return [
            'user' => $history->user,
            'content' => $call->comment ?? '',
            'body' => self::getBody($history),
            'footer' => isset($call->applicant) ? "Called <span>{$call->applicant->name}</span>" : null,
            'footerDatetime' => $history->ins_ts,
            'iconIncome' => $answered && $call->direction == Call::DIRECTION_INCOMING,
            'iconClass' => $answered ? 'md-phone bg-green' : 'md-phone-missed bg-red',
        ];
    }
}
