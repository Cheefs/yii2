<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app',  \Yii::t('app', 'update personal info'));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'account'), 'url' => ['account']];
$this->params['breadcrumbs'][] = Yii::t('app', 'update');
?>
<div class="users-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="users-form">
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'username')->textInput() ?>
            <?= $form->field($model, 'first_name')->textInput() ?>
            <?= $form->field($model, 'last_name')->textInput() ?>
            <?= $form->field($model, 'second_name')->textInput() ?>
            <?= $form->field($model, 'phone')->textInput() ?>
            <?= $form->field($model, 'email')->textInput() ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'submit'), ['class' => 'btn btn-success']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
