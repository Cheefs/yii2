<?php
/** @var $days array of days */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="row">
    <div class="col-sm-12">
        <!--  пока что Id дня будем считать индексом в массиве   -->
        <?php foreach ($days as $k => $day ):?>
            <div class="col-sm-4 day">
                <span><?= $day ?></span>
                <?= Html::a('', Url::to(['activity/create', 'dayId' => $k ]), [
                    'class' => 'glyphicon glyphicon-plus-sign'
                ]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
