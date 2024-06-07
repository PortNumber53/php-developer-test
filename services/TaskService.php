<?php

namespace app\services;

use Yii;
use app\models\Call;
use app\models\History;
use app\models\Task;

class TaskService extends BaseService
{
    /**
     * @return array
     */
    public static function getFullDirectionTexts()
    {
        return [
            Task::EVENT_CREATED_TASK => Yii::t('app', 'Task created'),
            Task::EVENT_UPDATED_TASK => Yii::t('app', 'Task updated'),
            Task::EVENT_COMPLETED_TASK => Yii::t('app', 'Task completed'),
        ];
    }

    /**
     * @return mixed|string
     */
    public static function getFullDirectionText(Call $call)
    {
        return self::getFullDirectionTexts()[$call->direction] ?? $call->direction;
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
        $task = $model->task;
        return "$model->eventText: " . ($task->title ?? '');
    }

    public static function getFooter($object)
    {
        return isset($object->customerCreditor->name) ? "Creditor: " . $object->customerCreditor->name : '';
    }

    public static function getIconClass()
    {
        return 'fa-check-square bg-yellow';
    }

    public static function getViewData(History $history)
    {
        $task = $history->task;

        return [
            'user' => $history->user,
            'body' => self::getBody($history),
            'footer' => isset($task->customerCreditor->name) ? "Creditor: " . $task->customerCreditor->name : '',
            'footerDatetime' => $history->ins_ts,
            'iconClass' => 'fa-check-square bg-yellow',
        ];
    }
}
