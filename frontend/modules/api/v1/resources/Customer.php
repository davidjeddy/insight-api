<?php

namespace frontend\modules\api\v1\resources;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author David J Eddy <me@davidjeddy.com>
 */
class Customer extends \frontend\modules\api\v1\models\Customer implements Linkable
{
    public function fields()
    {
        return [
            'id',
            'role',
            'username'
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
            Link::REL_SELF => Url::to(['customer/view', 'id' => $this->id], true)
        ];
    }
}
