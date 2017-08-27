<?php
namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\Customer as CustomerMDL;
use \frontend\modules\api\v1\resources\Order as OrderMDL;

/**
 * Class DashboardController
 * @package frontend\modules\api\v1\controllers
 */
class DashboardController extends BaseController
{
    /**
     * @var string
     */
    public $modelClass = null;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    /**
     *
     */
    public function actionIndex()
    {
        $data = [];

        if ($data['revenue']) {
            $data['aov'] = round($data['revenue'] / $data['order_count'], 2);
        }
        $renewal    = CustomerMDL::getRenewal();
        $c_renewal  = CustomerMDL::getCumulativeRenewal();

        $data['revenue']            = (float)round(OrderMDL::getTotalLastWeekRevenue(), 2);
        $data['order_count']        = (int)OrderMDL::getTotalLastWeekCount();
        $data['renewal']            = (float)round(($renewal[0]['renewal_rate'] * 100), 2);
        $data['cumulative_renewal'] = (float)round(($c_renewal[0]['cum_renewal_rate'] * 100), 2);
        $data['new_customers']      = CustomerMDL::getNewCustomers(); // array
        $data['lost_customers']     = CustomerMDL::getLostCustomers(); // array

        return $data;
    }
}
