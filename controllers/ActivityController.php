<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Activity;
use app\models\forms\ActivityForm;
use app\models\search\ActivitySearch;
use yii\web\NotFoundHttpException;

class ActivityController extends Controller {
    /**
     * просмотр нашей задачи
     * @return string возвращает вид
    */
    public function actionIndex(){
        $searchModel = new ActivitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * просмотр нашей задачи
     * @return string возвращает вид
     */
    public function actionCreate() {
        $model = new ActivityForm();
        if ( $model->load( \Yii::$app->request->post() ) && $model->save() ) {
            return $this->redirect('index');
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * @param  $id int id задачи
     * @return string возвращает вид
     * @throws NotFoundHttpException
     */
    public function actionUpdate( int $id ) {
        $model = Activity::findOne($id);
        if ( $model ) {
            if ( $model->load( \Yii::$app->request->post() ) && $model->save()) {
                return $this->redirect('index');
            }
            return $this->render('update', [
                'model' => $model
            ]);
        }
        throw new NotFoundHttpException();
    }

    /**
     * Удаление задачи
     * @param  $id int id задачи
     * @return string возвращает вид
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete( int $id ) {
        $model = Activity::findOne($id);
        if ( $model && $model->delete() ) {
            return $this->redirect('index');
        }
        throw new NotFoundHttpException('activity not found');
    }
}