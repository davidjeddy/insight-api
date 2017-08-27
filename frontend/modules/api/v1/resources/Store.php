<?php

namespace frontend\modules\api\v1\resources;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author David J Eddy <me@davidjeddy.com>
 */
class Store extends \frontend\modules\api\v1\models\Store implements Linkable
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'name',
            'zip',
            'manager_id',
            'order_count',
            'renewal_rate',
            'renewal_count',
            'aov',
            'revenue',
            'rolling_revenue',
            'lati',
            'long'
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
            Link::REL_SELF => Url::to(['store/view', 'id' => $this->id], true)
        ];
    }
}
