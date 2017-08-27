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
        {
            parent::__construct();

            if ($cxGrp = \Yii::$app->request->getQueryParam('customer_group')) {
                $this->dates['prevWeekSunday']  = strtotime('last Sunday', strtotime($cxGrp));
                $this->dates['prevWeekSaturday']= strtotime('next Saturday', strtotime($cxGrp));
            } else {
                $this->dates['prevWeekSunday']  = strtotime('last Sunday - 2 week');
                $this->dates['prevWeekSaturday']=strtotime('last Sunday - 1 week') -1; // tick backwards into the prev. week;s Saturday
            }

            if ($rpDate = \Yii::$app->request->getQueryParam('report_date')) {
                $this->dates['lastWeekSunday']  = strtotime('last Sunday', strtotime($rpDate));
                $this->dates['lastWeekSaturday']= strtotime('next Saturday', strtotime($rpDate));
            } else {
                $this->dates['lastWeekSunday']  = strtotime('last Sunday - 1 week');
                $this->dates['lastWeekSaturday']=strtotime('last Saturday');
            }
        }
    }
}

