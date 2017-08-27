<?php

namespace frontend\modules\api\v1\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $payment_id
 * @property string $total_amount
 * @property integer $status
 * @property integer $order_id
 * @property integer $customer_id
 * @property string $del_date
 *
 * @property Customer $customer
 * @property Order $order
 */
class Payment extends Base
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total_amount', 'status', 'order_id', 'customer_id'], 'required'],
            [['total_amount'], 'number'],
            [['status', 'order_id', 'customer_id'], 'integer'],
            [['del_date'], 'safe'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'order_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Payment ID'),
            'total_amount' => Yii::t('app', 'Total Amount'),
            'status' => Yii::t('app', 'Status'),
            'order_id' => Yii::t('app', 'Order ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'del_date' => Yii::t('app', 'Del Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['order_id' => 'id']);
    }
}
