<?php

namespace app\controllers;

use app\models\Activity;
use app\models\forms\ActivityForm;
use yii\helpers\Url;
use yii\web\Controller;


/* 1. Создайте вёрстку страницы задачи на день. Пользователь должен будет попадать на неё при создании или редактировании события, выбранного в календаре.
a. На странице должна отображаться информация о событии.
b. Со страницы нужно иметь возможность удобно вернуться к календарю.
c. Со страницы нужно иметь возможность перейти к редактированию события.

2. Создайте форму добавления нового события в календарь пользователя.
a. Форма должна валидироваться в соответствии с полями.
b. Пока данные формы можно не сохранять, а просто выводить для дебага на отдельной странице submit.

3. * Разрешите пользователю прикреплять несколько файлов к событию.
a. Несколько файлов нужно прикреплять за одну загрузку. */

class ActivityController extends Controller {

    public function actionIndex( int $id ) {
        // тут нужно будет заменить на ActiveRecord и делать поиск по id
        $model = new ActivityForm();
        $model->setData($id);

        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionUpdate( int $id ) {
        $model = new ActivityForm();
        $model->setData($id);

        if ($model->load( \Yii::$app->request->post()) && $model->validate()) {
            return $this->redirectToMainPage($model->id);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete( int $id ) {
        $model = new Activity();
        $model->id = $id;
        return $this->redirectToMainPage($model->id);
    }

    private function redirectToMainPage( int $id ) {
        return $this->redirect(Url::to([ 'index', 'id' => $id ]));
    }
}