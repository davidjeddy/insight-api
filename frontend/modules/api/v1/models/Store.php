<?php

namespace frontend\modules\api\v1\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property integer $store_id
 * @property string $name
 * @property integer $zip
 * @property integer $manager_id
 *
 * @property Order[] $orders
 * @property Manager $manager
 */
class Store extends Base
{
    /**
     * Added properties for stores over a given date range
     */
    public $order_count = null;
    public $renewal_rate = null;
    public $renewal_count = null;
    public $aov = null;
    public $revenue = null;
    public $rolling_revenue = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'zip', 'manager_id'], 'required'],
            [['zip', 'manager_id'], 'integer'],
            [['name'], 'string', 'max' => 75],
            [['lati', 'long'], 'strig', 'max' => 16],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manager::className(), 'targetAttribute' => ['manager_id' => 'manager_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Store ID'),
            'name' => Yii::t('app', 'Name'),
            'zip' => Yii::t('app', 'Zip'),
            'manager_id' => Yii::t('app', 'Manager ID'),
            'lati' => Yii::t('app', 'Latitude'),
            'long' => Yii::t('app', 'Longitude'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['store_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Manager::className(), ['manager_id' => 'manager_id']);
    }

    /**
     *
     */
    public function afterFind()
    {
        parent::afterFind();

        $prevWeekSunday = strtotime('last Sunday - 2 week');
        $prevWeekSaturday=strtotime('last Sunday - 1 week') -1; // tick backwards into the prev. week;s Saturday
        $lastWeekSunday = strtotime('last Sunday - 1 week');
        $lastWeekSaturday=strtotime('last Saturday');

        $data = \Yii::$app->db->createCommand("
select s.id as `store_id`, 
        s.name as `store_name`,
        weekreq.`week_count` as `week_order_ct`,
        weekreq.`revenue_current` as `revenue`,
        # Calculate renewal rate by dividing old vs new
        weekreq.`week_count` / prevweek.`prev_order_ct` as `renewal_rate` ,
        weekreq.`avg_order_value`as `avg_order_value`  # Average Order Value
from store s
inner join (
    select
    count(*) as `prev_order_ct`,
    sum(total_amount) as `revenue_prev`,
    o.store_id
    FROM `order` o
    where # o.store_id = s.id AND
--     o.order_date >= UNIX_TIMESTAMP('2017-08-07 00:00')  AND 
--     o.order_date <= UNIX_TIMESTAMP('2017-08-14 00:00') # This is the week range for PREVIOUS period
    o.order_date >= " . $prevWeekSunday . " AND
    o.order_date <= " . $prevWeekSaturday . "
    group by o.store_id
) as `prevweek`
    on prevweek.store_id = s.id # join up order info for this store for PREVIOUS week
inner join (
    select 
        sum(total_amount) as `revenue_current`,
        count(*) as `week_count`,
        avg(total_amount) as `avg_order_value`,
        o.store_id
        #,DATE(from_unixtime(o.order_date))
        FROM `order` o # on oe.store_id = s.id AND    
        WHERE
        --     o.order_date >  UNIX_TIMESTAMP('2017-08-14 00:00') AND 
    --         o.order_date <=  UNIX_TIMESTAMP('2017-08-21 00:00') # This is the week actually requested
            o.order_date > " . $lastWeekSunday . " AND 
            o.order_date <=  " . $lastWeekSaturday . "
        AND o.customer_id in ( 
            select o.customer_id as `customer_id`
            #,store_id,
            #DATE(from_unixtime(o.order_date))
            from `order` o 
            where         
            o.order_date >= " . $prevWeekSunday . " AND
            o.order_date <= " . $prevWeekSaturday . "
        )
    group by o.store_id
) as `weekreq`
    on weekreq.store_id = s.id  
        AND prevweek.store_id
        AND s.id = " . $this->id . "
        ")->queryAll();

        $this->order_count = (int)$data[0]['week_order_ct'];
        $this->renewal_rate = round($data[0]['renewal_rate'], 2);
        $this->renewal_count = (int)$data[0]['week_order_ct'];
        $this->aov = round($data[0]['avg_order_value'], 2);
        $this->revenue = round($data[0]['revenue'], 2);
    }
}
