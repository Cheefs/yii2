<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */

$controller = mb_strtolower( Yii::$app->controller->id );
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $controller ), 'url' => ['activity']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">

    <h1><?= Yii::t('app', "$controller view") ?></h1>
    <p>
        <?= Html::a(Yii::t('app', Yii::t('app', 'edit')), [
            'update', 'id' => $model->id
        ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', Yii::t('app', 'delete')), [
            'delete', 'id' => $model->id
        ], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [ 'attribute' => 'id' ],
            [ 'attribute' => 'name'],
            [
                'attribute' => 'started_at',
                'value' => function($model) {
                    return $model->started_at ? Yii::$app->formatter->asDatetime( $model->started_at ) : null;
                }
            ],
            [
                'attribute' => 'finished_at',
                'value' => function($model) {
                    return $model->finished_at ? Yii::$app->formatter->asDatetime( $model->finished_at ) : null;
                }
            ],
            [
                'attribute' => 'is_repeatable',
                'value' => function($model) {
                    return $model->is_main ? Yii::t('app', 'yes')
                        : Yii::t('app', 'no');
                }
            ],
            [
                'attribute' => 'is_main',
                'value' => function($model) {
                    return $model->is_main ? Yii::t('app', 'main')
                        : Yii::t('app', 'regular');
                }
            ],
            [ 'attribute' => 'desc' ],
        ],
    ]) ?>

</div>
