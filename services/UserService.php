<?php

namespace app\services;

use Yii;
use app\models\User;

class UserService extends BaseService
{
    /**
     * @return string
     */
    public function getStatusText($object = null)
    {
        return User::getStatusTexts()[$object->status] ?? $object->status;
    }
}
