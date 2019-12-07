<?php
/** @var $model \app\models\forms\ActivityForm */

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<h1 class="text-center"><?= Yii::t('app', 'create new activity') ?></h1>
<?php $form = ActiveForm::begin([
    'id' => 'create-form',
    'options' => [ 'enctype' => 'multipart/form-data' ]
]); ?>

<div class="row">
    <div class="col-sm-12">
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'desc')->textarea() ?>
        <?= $form->field($model, 'started_at')->widget(DateTimePicker::class, [
            'options' => ['placeholder' => 'Enter event time ...'],
            'pluginOptions' => [
                'format' => $model::DATE_FORMAT_FOR_DATE_PICKER,
                'autoclose' => true
            ]
        ])?>
        <?= $form->field($model, 'finished_at')->widget(DateTimePicker::class, [
            'options' => ['placeholder' => 'Enter event time ...'],
            'pluginOptions' => [
                'format' =>  $model::DATE_FORMAT_FOR_DATE_PICKER,
                'autoclose' => true
            ]
        ])?>
        <?= $form->field($model, 'is_main')->radioList([
            0 => Yii::t('app', 'no'),
            1 => Yii::t('app', 'yes'),
        ]) ?>
        <?= $form->field($model, 'is_repeatable')->checkbox() ?>
    </div>

</div>

<div class="text-center">
    <?= Html::submitButton(Yii::t('app', 'submit'), [
        'class' => 'btn btn-primary'
    ]) ?>
    <?= Html::a(Yii::t('app', 'cancel'), Url::to(['index', 'id' => $model->id ]), [
        'class' => 'btn btn-danger'
    ]) ?>
</div>

<?php ActiveForm::end(); ?>
