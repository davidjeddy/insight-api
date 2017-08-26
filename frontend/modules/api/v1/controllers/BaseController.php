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
}
