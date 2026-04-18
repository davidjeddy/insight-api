<?php
namespace frontend\modules\api\v1\controllers;

use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
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
     * @var null
     */
    private $corsDomains = null;

    /**
     * @return bool
     */
    public function init()
    {
        $this->corsDomains = env(
            (explode('\\', self::className())[0] === 'frontend' ? 'FRONTEND_CORS_SOURCE' : 'BACKEND_CORS_SOURCE')
        );

        if (\Yii::$app->request->method === 'OPTIONS') {
            return true;
        } else {
            // COOOOORRORORORORORORROSSSSS!!! Have to return this POST CORS OPTION request or the browser XHR fails.
            \Yii::$app->response->getHeaders()->set('Access-Control-Allow-Origin', $this->corsDomains);
        }
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index'   => [
                'class'       => \yii\rest\IndexAction::class,
                'modelClass'  => $this->modelClass
            ],
            'view'    => [
                'class'       => \yii\rest\ViewAction::class,
                'modelClass'  => $this->modelClass
            ],
        ];
    }

    /**
     * We need allow OPTIONS request on EVERY CNTL method that could be called. If the HTTP verb is OPTIONS, return the
     * Allow and CORS data.
     * Throw an error if 'Authorization' header is present.
     * Return full HTTP verb allowance set if an ID is provided.
     *
     * Because we are overriding the options action we also have to over ride the CORS headers.
     *
     */
    public function actionOptions()
    {
        $options = ['GET', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'];

        \Yii::$app->response->getHeaders()
            ->set('Access-Control-Allow-Headers', 'Authorization, Content-Type')
            ->set('Access-Control-Allow-Origin', $this->corsDomains)
            ->set('Access-Control-Allow-Methods', implode(', ', $options));
    }

    /**
     * @param \yii\base\Action $action
     *
     * @return null|string
     */
    public function beforeAction($action)
    {
        if (\Yii::$app->request->isOptions === true) {
            return $this->actionOptions();
        }

        return parent::beforeAction($action);
    }

    /**
     * @param $id
     *
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function findModel($id)
    {
        $model = ($this->modelClass)::find()
            ->andWhere(['id' => (int)$id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }

        return $model;
    }
}
