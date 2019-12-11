<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\NotFoundHttpException;

//  a. Пользователь может управлять своими личными данными.
//  b. Пользователь может управлять своими активностями.

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UserController extends BaseController
{
    /**
     * Lists all Users models.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionProfile() {
        $model = User::findOne( [ 'id' => Yii::$app->user->id ]);
        if ( $model ) {
            return $this->render('profile', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException();
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id) {
        $model = User::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['profile']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCalendar() {
        return $this->render('calendar', [
            'user' => Yii::$app->user
        ]);
    }
}
