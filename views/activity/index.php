<?php
/** @var $model \app\models\Activity */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-sm-12 text-center">
        <h1 class="text_bold">
            <?= $model->name ?>
            <?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', Url::to(['update', 'id' => $model->id ])) ?>
        </h1>
        <div class="row">
            <div class="col-sm-6">
                <h3>
                    <span class="text_bold"><?= Yii::t('app', 'from') ?>:</span>
                    <span><?= $model->from ?? Yii::t('app', 'not set') ?></span>
                </h3>
            </div>
            <div class="col-sm-6">
                <h3>
                    <span class="text_bold"><?= Yii::t('app', 'to') ?>:</span>
                    <span><?= $model->to ?? Yii::t('app', 'not set') ?></span>
                </h3>
            </div>
        </div>

        <p><?= $model->desc ?></p>

        <?= Html::a(Yii::t('app', 'remove'), Url::to(['delete', 'id' => $model->id ]), [
            'class' => 'btn btn-primary'
        ]) ?>
    </div>
</div>

