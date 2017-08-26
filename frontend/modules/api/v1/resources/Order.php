<?php

namespace frontend\modules\api\v1\resources;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author David J Eddy <me@davidjeddy.com>
 */
class Order extends \frontend\models\Order implements Linkable
{
    public function fields()
    {
        return [
            'id',
            'customer_id',
            'order_date',
            'store_id',
            'total_amount',
            'total_wo_tax',
            'cart_discount_amt',
            'order_total_tax',
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
            Link::REL_SELF => Url::to(['order/view', 'id' => $this->id], true)
        ];
    }
}
