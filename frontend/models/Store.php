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
        return $this->hasMany(Order::className(), ['store_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Manager::className(), ['manager_id' => 'id']);
    }
}
