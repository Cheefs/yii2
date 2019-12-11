<?php

namespace app\controllers;

use app\components\behaviors\CacheBehavior;
use edofre\fullcalendar\models\Event;
use Yii;
use app\models\Activity;
use app\models\forms\ActivityForm;
use app\models\search\ActivitySearch;
use yii\web\NotFoundHttpException;

class ActivityController extends BaseController {
    /**
     * просмотр нашей задачи
     * @return string возвращает вид
    */
    public function actionIndex() {
        $searchModel = new ActivitySearch();
        $query = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search( $query, true );

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
        return $this->render('form', [
            'model' => $model
        ]);
    }

    /**
     * @param  $id int id задачи
     * @return string возвращает вид
     * @throws NotFoundHttpException
     */
    public function actionUpdate( int $id ) {
        $model = ActivityForm::findOne($id);
        if ( $model ) {
            if ( $model->load( \Yii::$app->request->post() ) && $model->save()) {
                return $this->redirect('index');
            }
            return $this->render('form', [
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

    /**
     * Получение списка активностей для календаря для конкретного пользователя
     * @param  int $userId
     * @return array
     **/
    public function actionEvents( int $userId ) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $activitiesList = Activity::findAll([ 'author_id' => $userId ]);
        $calendarEvents = [];

        if ( $activitiesList && is_array($activitiesList) && count( $activitiesList )) {
            foreach ( $activitiesList as $activity ) {

                $calendarEvents[] = new Event([
                    'id' => $activity->id,
                    'title' => $activity->name,
                    'start' => Yii::$app->formatter->asDatetime($activity->started_at, 'php:Y-m-d H:i:s' ),
                    'end' =>  Yii::$app->formatter->asDatetime($activity->finished_at, 'php:Y-m-d H:i:s' ),

                    'editable'         => true,
                    'startEditable'    => true,
                    'durationEditable' => true,
                ]);
            }
        }
        return $calendarEvents;
    }
}