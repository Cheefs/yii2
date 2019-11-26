<?php

namespace app\controllers;

use app\models\Day;
use app\models\forms\DayForm;
use yii\web\Controller;

class DayController extends Controller {

    public function actionIndex() {
        return $this->render('index', [
            'days' => DayForm::DAYS_LIST
        ]);
    }

    public function actionCreate() {

    }
}
