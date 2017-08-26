<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "managers".
 *
 * @property integer $manager_id
 * @property string $first_name
 * @property string $last_name
 * @property string $cell_number
 * @property string $email
 *
 * @property Store[] $stores
 */
class Manager extends Base
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manager';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 75],
            [['cell_number'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Manager ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'cell_number' => Yii::t('app', 'Cell Number'),
            'email' => Yii::t('app', 'Email'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStores()
    {
        return $this->hasMany(Store::className(), ['manager_id' => 'id']);
    }
}
