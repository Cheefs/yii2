<?php
/** @var $model \app\models\forms\ActivityForm */
/** @var $dayId int */
use yii\helpers\VarDumper;

var_dump($model);
/** вывод обычного дампа куда более лучше чем этого хелпера */
//VarDumper::dump( [ $model, $dayId ] );