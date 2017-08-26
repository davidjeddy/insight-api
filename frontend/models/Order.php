<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $order_id
 * @property integer $customer_id
 * @property string $order_date
 * @property integer $store_id
 * @property string $total_amount
 * @property string $total_wo_tax
 * @property string $cart_discount_amt
 * @property string $order_total_tax
 *
 * @property Customer $customer
 * @property Store $store
 */
class Order extends Base
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'store_id', 'total_amount', 'total_wo_tax', 'cart_discount_amt'], 'required'],
            [['customer_id', 'store_id'], 'integer'],
            [['order_date'], 'safe'],
            [['total_amount', 'total_wo_tax', 'cart_discount_amt', 'order_total_tax'], 'number'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'store_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Order ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'order_date' => Yii::t('app', 'Order Date'),
            'store_id' => Yii::t('app', 'Store ID'),
            'total_amount' => Yii::t('app', 'Total Amount'),
            'total_wo_tax' => Yii::t('app', 'Total Wo Tax'),
            'cart_discount_amt' => Yii::t('app', 'Cart Discount Amt'),
            'order_total_tax' => Yii::t('app', 'Order Total Tax'),
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
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['store_id' => 'id']);
    }
}
