<?php

namespace frontend\modules\api\v1\resources;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Store extends \frontend\models\Store implements Linkable
{
    public function fields()
    {
        return [
            'id',
            'name',
            'zip',
            'manager_id',
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
