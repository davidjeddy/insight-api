<?php

namespace frontend\modules\api\v1\resources;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Payment extends \frontend\models\Payment implements Linkable
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'total_amount',
            'status',
            'order_id',
            'customer_id',
            'del_date',
        ];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['payment/view', 'id' => $this->id], true)
        ];
    }
}
