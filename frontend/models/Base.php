<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for `Insight` data tables.
 *
 * @property integer $customer_id
 * @property string $role
 * @property string $username
 *
 * @property Order[] $orders
 */
class Base extends \yii\db\ActiveRecord
{
    /**
     *
     */
    const RESPONSE_DATE_FORMAT = 'Y-m-d';

    /**
     *
     */
    public function afterFind()
    {
        parent::afterFind();

        foreach ($this->getAttributes() as $key => $value)
        {
            if ($this->endsWith($value, '_date')) {
                $this->setAttribute($key, date(self::RESPONSE_DATE_FORMAT, (int)$value));
            }
        }
    }

    /**
     * @param bool $insert
     * @return $this
     * @throws \Exception
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            throw new \Exception($this->getErrors());
        }

        foreach ($this->getAttributes() as $key => $value)
        {
            if ($this->endsWith($value, '_date')) {
                $this->setAttribute($key, strtotime((string)$value));
            }
        }

        return $this;
    }

    /**
     * @source https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * @source https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }
}
