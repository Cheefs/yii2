<?php
/** @var $days array of days */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="row">
    <div class="col-sm-12">
        <?php foreach ($days as $k => $day ):?>
            <div class="col-sm-4 day">
                <span><?= $day ?></span>
                <?= Html::a('', Url::to(['activity/create']), [
                    'class' => 'glyphicon glyphicon-plus-sign'
                ]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
