<?php

namespace app\controllers;

use app\models\forms\DayForm;
use yii\web\Controller;

class DayController extends Controller {
    /**
     * Просмотр дней ( тут будет календарь, да и контроллер думаю нужно будет назвать иначе )
     * @return string возвращает вид
     */
    public function actionIndex() {
        return $this->render('index', [
            'days' => DayForm::DAYS_LIST
        ]);
    }
}
