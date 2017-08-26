<?php

namespace frontend\modules\api\v1\resources;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author David J Eddy <me@davidjeddy.com>
 */
class Manager extends \frontend\models\Manager implements Linkable
{
    public function fields()
    {
        return [
            'id',
            'first_name',
            'last_name',
            'cell_number',
            'email',
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
            Link::REL_SELF => Url::to(['manager/view', 'id' => $this->id], true)
        ];
    }
}
