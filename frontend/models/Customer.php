<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $customer_id
 * @property string $role
 * @property string $username
 *
 * @property Order[] $orders
 */
class Customer extends Base
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role', 'username'], 'required'],
            [['role', 'username'], 'string', 'max' => 75],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Customer ID'),
            'role' => Yii::t('app', 'Role'),
            'username' => Yii::t('app', 'Username'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }
}
