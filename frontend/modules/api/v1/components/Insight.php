<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 8/26/17
 * Time: 8:07 PM
 */

namespace frontend\modules\api\v1\components;

use yii\base\Component;

class Insight extends Component
{
    public $dates = [];

    public function __construct()
    {
        parent::__construct();;

        $this->dates['prevWeekSunday']  = strtotime('last Sunday - 2 week');
        $this->dates['prevWeekSaturday']=strtotime('last Sunday - 1 week') -1; // tick backwards into the prev. week;s Saturday
        $this->dates['lastWeekSunday']  = strtotime('last Sunday - 1 week');
        $this->dates['lastWeekSaturday']=strtotime('last Saturday');
    }
}