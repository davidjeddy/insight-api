<?php
namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\resources\Article;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * Class ArticleController
 * @author Eugene Terentev <eugene@terentev.net>
 */
class BaseController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = null;

    /**
     * @var array
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index'   => [
                'class'       => \yii\rest\IndexAction::class,
                'modelClass'  => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'view'    => [
                'class'       => \yii\rest\ViewAction::class,
                'modelClass'  => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        return new ActiveDataProvider(array(
            'query' => Article::find()->published()
        ));
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function findModel($id)
    {
        $model = Article::find()
            ->published()
            ->andWhere(['id' => (int) $id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        return $model;
    }
}
