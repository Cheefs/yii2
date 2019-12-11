<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;

class MailController extends Controller
{
    public $message;
    public $text;

    public function actionIndex($arg, $arg2)
    {
        echo $arg . PHP_EOL;
        echo $arg2 . PHP_EOL;
        echo $this->message . PHP_EOL;
        echo $this->text . PHP_EOL;
    }

    public function options($actionID)
    {
        return ['message', 'text'];
    }
    public function optionAliases()
    {
        return ['m' => 'message', 't' => 'text'];
    }

    public function actionSendOut( int $userId )
    {
        $user = User::findOne([ 'id' => $userId ]);
        if ( $user ) {
            $mailSend = \Yii::$app->mailer
                ->compose('main/notification')
                ->setFrom( \Yii::$app->params['senderEmail'] )
                ->setSubject('Информация')
                ->setTo($user->email)->setCharset('UTF-8')
                ->send();
            if ( $mailSend ) {
                echo "Письмо успешно оправленно на почту $user->email" . PHP_EOL;
            } else {
                echo "Ошибка при отправке письма" . PHP_EOL;
            }
        } else {
            echo "Пользователь с id $userId не найден" . PHP_EOL;
        }
    }
}