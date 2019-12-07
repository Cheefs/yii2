<?php
/** @var $model \app\models\forms\SignUpForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('app', 'register');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>
            <?= $form->field($model, 'username')->textInput() ?>
            <?= $form->field($model, 'email')->textInput() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <hr/>
            <h4><?= Yii::t('app', 'profile fields') ?></h4>
            <hr/>
            <?= $form->field($model, 'first_name')->textInput() ?>
            <?= $form->field($model, 'last_name')->textInput() ?>
            <?= $form->field($model, 'second_name')->textInput() ?>
            <?= $form->field($model, 'phone')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>