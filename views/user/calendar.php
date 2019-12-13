<?php
/** @var $user \app\models\User */

use yii\helpers\Url;

?>

<?= edofre\fullcalendar\Fullcalendar::widget([
    'options' => [
        'id' => 'calendar',
        'language' => 'ru',
    ],
    'clientOptions' => [
        'weekNumbers' => false,
        'selectable'  => true,
        'defaultView' => 'month',
    ],
    'events' => Url::to(['activity/events', 'userId' => $user->id ]),
]);
?>