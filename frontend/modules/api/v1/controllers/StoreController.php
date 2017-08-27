<?php
namespace frontend\modules\api\v1\controllers;

/**
 * Class StoreController
 * @package frontend\modules\api\v1\controllers
 */
class StoreController extends BaseController
{
    /**
     *
     */
    const SEC_PER_WEEK = 604800;

    /**
     * @var string
     */
    public $modelClass = \frontend\modules\api\v1\resources\Store::class;

    /**
     * rolling 4 weeks of revenue based on story.id
     * 604,800 s in a week
     */
    public function action4WeeksOfRevenue($id, $endDate = null)
    {
        if ($endDate === null) {
            $endDate = strtotime('last Sunday - 1 week');
        }

        $model = $this->findModel($id);

        for ($i = 0; $i < 4; $i++) {
            $data = \Yii::$app->db->createCommand("
                select sum(total_amount) as weekly_revenue
                from `order`
                where store_id = " .$model->id . "
                AND order_date <= " .$endDate . "
                AND order_date > " . ($endDate - self::SEC_PER_WEEK) . "
            ")->queryAll();

            $endDate = $endDate - self::SEC_PER_WEEK;

            $value = (int)$data[0]['weekly_revenue'];
            if ($value >= 1) {
                $model->rolling_revenue[$i]['data'] = date('n/j/Y', $endDate);
                $model->rolling_revenue[$i]['value'] = (int)$data[0]['weekly_revenue'];
            }
        }

        $model->rolling_revenue = array_reverse($model->rolling_revenue);

        return $model;
    }
}
