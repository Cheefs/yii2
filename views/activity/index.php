<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create Activity', ['save'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [ 'attribute' => 'id' ],
            [ 'attribute' => 'name' ],
            [
                'attribute' => 'started_at',
                 'value' => function( $model ) {
                    /** @var $model \app\models\Activity  */
                    return Yii::$app->formatter->asDatetime( $model->started_at, $model::DATE_FORMAT_FOR_FORMATTER );
                }
            ],
            [
                'attribute' => 'finished_at',
                'value' => function( $model ) {
                    /** @var $model \app\models\Activity  */
                    if ($model->finished_at) {
                        return  Yii::$app->formatter->asDatetime( $model->finished_at, $model::DATE_FORMAT_FOR_FORMATTER );
                    }
                   return null;
                }
            ],
            [
                'attribute' => 'is_main',
                'format' => 'raw',
                'value' => function( $model ) {
                    /** @var $model \app\models\Activity  */
                    $text = $model->is_main ? 'yes' : 'no';
                    return Yii::t('app', $text);
                }
            ],
            [
                'attribute' => 'is_repeatable',
                'format' => 'raw',
                'value' => function( $model ) {
                    /** @var $model \app\models\Activity  */
                    $text = $model->is_main ? 'yes' : 'no';
                    return Yii::t('app', $text);
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function( $model ) {
                    /** @var $model \app\models\Activity  */
                    return Yii::$app->formatter->asDatetime( $model->created_at, $model::DATE_FORMAT_FOR_FORMATTER );
                }
            ],
            [ 'attribute' => 'desc' ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => function( $model ) {
                    /** @var $model \app\models\Activity  */
                    return Yii::$app->formatter->asDatetime( $model->updated_at, $model::DATE_FORMAT_FOR_FORMATTER );
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                         return Html::a('', Url::to(['save', 'id' => $model->id ]), [
                            'class' => 'glyphicon glyphicon-pencil'
                         ]);
                    },
                    'delete',
                ]
            ],
        ],
    ]); ?>


</div>
