<?php

namespace app\controllers;

use app\models\Activity;
use app\models\forms\ActivityForm;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;


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
    /**
     * просмотр нашей задачи
     * @param  $id int id задачи
     * @return string возвращает вид
    */
    public function actionIndex( int $id ) {
        // тут нужно будет заменить на ActiveRecord и делать поиск по id
        $model = new ActivityForm();
        $model->setData($id);

        return $this->render('index', [
            'model' => $model
        ]);
    }
    /**
     * просмотр нашей задачи
     * @param  $dayId int id дня на котором создаем задачу ( или какойто иной признак )
     * @return string возвращает вид
     */
    public function actionCreate(int $dayId) {
        $model = new ActivityForm();
        $model->dayId = $dayId;
        if ( $model->load( \Yii::$app->request->post() ) && $model->validate()) {
            $model->saveFiles();
            return $this->render('submit-debug', [
                'model' => $model,
            ]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Обновление задачи ( этот метот очень похож на Create поэтому если всегда будут одинаковы
     * можно будет их обьеденить, и понимать какой это режим по наличию поля Activity->id )
     * @param  $id int id задачи
     * @return string возвращает вид
     */
    public function actionUpdate( int $id ) {
        $model = new ActivityForm();
        $model->setData($id);
        if ( $model->load( \Yii::$app->request->post() ) && $model->validate()) {
            $model->saveFiles();
            return $this->render('submit-debug', [
                'model' => $model,
            ]);
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }
    /**
     * Удаление задачи
     * @param  $id int id задачи
     * @return string возвращает вид
     */
    public function actionDelete( int $id ) {
        $model = new Activity();
        $model->id = $id;
        return $this->redirectToMainPage($model->id);
    }

    /**
     * Просто упростил запись редиректа, чтоб не повторять его везде, мб когдато вьюху сменим
     * @param  $id int id задачи
     * @return string возвращает вид
     */
    private function redirectToMainPage( int $id ) {
        return $this->redirect(Url::to([ 'index', 'id' => $id ]));
    }
}