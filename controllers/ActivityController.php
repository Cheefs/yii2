<?php

namespace app\controllers;

use app\models\Activity;
use app\models\forms\ActivityForm;
use app\models\search\ActivitySearch;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
     * @param  $id int
     * @return string возвращает вид
     */
    public function actionSave( int $id = null ) {
        /// если id был передан - делаем запрос на выборку, в проотивном случае оперируем новой моделью
        $model = $id ? Activity::findOne($id) : new ActivityForm();

        if ( $model->load( \Yii::$app->request->post() ) && $model->validate()) {
            if ( $model->save() ) {
                return $this->redirectToMainPage();
            }
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
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete( int $id ) {
        $model = Activity::findOne($id);
        if ( $model && $model->delete() ) {
            return $this->redirectToMainPage();
        }
        throw new NotFoundHttpException('activity not found');
    }

    /**
     * Просто упростил запись редиректа, чтоб не повторять его везде, мб когдато вьюху сменим
     * @return string возвращает вид
     */
    private function redirectToMainPage( ) {
        return $this->redirect(Url::to([ 'index' ]));
    }
}