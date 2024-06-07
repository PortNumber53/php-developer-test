<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%call}}".
 *
 * @property integer $id
 * @property string $ins_ts
 * @property integer $direction
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $status
 * @property string $phone_from
 * @property string $phone_to
 * @property string $comment
 *
 * -- magic properties
 * @property string $statusText
 * @property string $directionText
 * @property string $totalStatusText
 * @property string $totalDisposition
 * @property string $durationText
 * @property string $fullDirectionText
 * @property string $client_phone
 *
 * @property Customer $customer
 * @property User $user
 */
class Call extends ActiveRecord
{
    const STATUS_NO_ANSWERED = 0;
    const STATUS_ANSWERED = 1;

    const DIRECTION_INCOMING = 0;
    const DIRECTION_OUTGOING = 1;

    public $duration = 720;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%call}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ins_ts'], 'safe'],
            [['direction', 'phone_from', 'phone_to', 'type', 'status', 'viewed'], 'required'],
            [['direction', 'user_id', 'customer_id', 'type', 'status'], 'integer'],
            [['phone_from', 'phone_to', 'outcome'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ins_ts' => Yii::t('app', 'Date'),
            'direction' => Yii::t('app', 'Direction'),
            'directionText' => Yii::t('app', 'Direction'),
            'user_id' => Yii::t('app', 'User ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'status' => Yii::t('app', 'Status'),
            'statusText' => Yii::t('app', 'Status'),
            'phone_from' => Yii::t('app', 'Caller Phone'),
            'phone_to' => Yii::t('app', 'Dialed Phone'),
            'user.fullname' => Yii::t('app', 'User'),
            'customer.name' => Yii::t('app', 'Client'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
