<?php

namespace app\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;

class BaseController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        parent::beforeAction($action);

        if ( \Yii::$app->user->isGuest ) {
           \Yii::$app->controller->redirect(['site/login']);
        }

        return $action;
    }
}