<?php
/** @var $model \app\models\forms\ActivityForm */

use app\models\forms\DayForm;
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
        <?= $form->field($model, 'from')->textInput() ?>
        <?= $form->field($model, 'to')->textInput() ?>
        <?= $form->field($model, 'isMain')->radioList([
            0 => Yii::t('app', 'no'),
            1 => Yii::t('app', 'yes'),
        ]) ?>
        <?= $form->field($model, 'isRepeatable')->checkbox() ?>
        <div class="text-center">
            <h2><?= Yii::t('app', 'days of activity') ?></h2>
            <?= $form->field($model, 'repeatDays')->checkboxList( DayForm::DAYS_LIST )
                ->label(false);
            ?>
        </div>
        <?= $form->field($model, 'attachments[]')->fileInput(['multiple' => true ]) ?>
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
