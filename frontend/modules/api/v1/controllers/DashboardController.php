<?php
namespace frontend\modules\api\v1\controllers;

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

        $data['revenue']        = round(\frontend\modules\api\v1\resources\Order::getTotalLastWeekRevenue(), 2);
        $data['order_count']    = (int)\frontend\modules\api\v1\resources\Order::getTotalLastWeekCount();
        $data['aov']            = round($data['revenue'] / $data['order_count'], 2);

        $renewal = \frontend\models\Customer::getRenewal();
        $data['renewal']            = round(($renewal[0]['renewal_rate'] * 100), 2);

        $c_renewal = 0;
        if (\Yii::$app->request->getQueryParam('customer_group')) {
            $c_renewal = \frontend\models\Customer::getCumulativeRenewal();
        }
        $data['cumulative_renewal'] = round(($c_renewal[0]['cum_renewal_rate'] * 100), 2);

        $data['new_customers']  = \frontend\modules\api\v1\resources\Customer::getNewCustomers();
        $data['lost_customers'] = \frontend\modules\api\v1\resources\Customer::getLostCustomers();

        return $data;
    }
}
