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
class Base extends \yii\db\ActiveRecord
{

}
