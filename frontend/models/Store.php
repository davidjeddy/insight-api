<?php

namespace frontend\models;

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
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Managers::className(), 'targetAttribute' => ['manager_id' => 'manager_id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['store_id' => 'store_id']);
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

        $defaultRangeStart = strtotime('last Sunday - 1 week');
        $defaultRangeEnd = strtotime('last Sunday');

        $this->order_count = 33; //\Yii::$app->db->createCommand('SELECT count(*) FROM order')->execute();
        $this->renewal_rate = round((17/33), 3);
        $this->renewal_count = 17;
        $this->aov = '12.34';
        $this->revenue = '1234.56';
    }
}
