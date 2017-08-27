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

    /**
     * @return \yii\db\DataReader
     */
    public static function getNewCustomers()
    {
        $dates = \Yii::$app->Insight->dates;

        $query = "# New customers that didn't buy last week
select 
    c.id as `customer_id`,
    c.username as `username`,
    o.total_amount `total_order_amt`,
    o.store_id as `store_id`,
    s.name as `store_name`
from customer c

inner join `order` o on o.customer_id = c.id AND

# This previous's date range
o.order_date > " . $dates['lastWeekSunday'] . " AND 
o.order_date <=  " . $dates['lastWeekSaturday'] . " AND

# Filter out rows for customers that DID purchase 
c.id not in
(
    select o.customer_id as `customer_id`
    from `order` o 
    where 
    o.order_date >= " . $dates['prevWeekSunday'] . " AND
    o.order_date <= " . $dates['prevWeekSaturday'] . " 
)

inner join store s on s.id = o.store_id
";

        if (!empty(\Yii::$app->request->getQueryParam('store_id'))) {
            $query .= "where `store_id` = " . (int)\Yii::$app->request->getQueryParam('store_id');
        }

        $data = \Yii::$app->db->createCommand($query)->query();

        return $data;
    }

    /**
     * @return array
     */
    public static function getLostCustomers()
    {
        $dates = \Yii::$app->Insight->dates;

        $query = "
# Used to populate the 'Lost Customers' grid
select c.*, customer_aggregates.*
from customer c
inner join `order` o on o.customer_id = c.id AND
# This previous's date range
    o.order_date >= " . $dates['prevWeekSunday'] . " AND
    o.order_date <= " . $dates['prevWeekSaturday'] . " AND
    c.id not in
    (
    # Customers from THIS week that had an order
        select o.customer_id as `customer_id`
    from `order` o
    where
    o.order_date > " . $dates['lastWeekSunday'] . " AND
    o.order_date <=  " . $dates['lastWeekSaturday'] . "
)
inner join (
        select o.customer_id as `customer_id`,
    sum(total_amount) as `lifetime_amt`,
    avg(total_amount) as `avg_order_amt`
    from `order` o
    group by o.customer_id
) as `customer_aggregates`
    on `customer_aggregates`.`customer_id` = c.id
";

        if (!empty(\Yii::$app->request->getQueryParam('store_id'))) {
            $query .= "where `store_id` = " . (int)\Yii::$app->request->getQueryParam('store_id');
        }

        $data = \Yii::$app->db->createCommand($query)->query();

        return $data;
    }
}
