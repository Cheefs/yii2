<?php
/**
 * Created by PhpStorm.
 * User: evg
 * Date: 02/12/2019
 * Time: 19:31
 */
namespace app\models\forms;

use app\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 *  1) Создайте форму регистрации новых пользователей на сайте.
 *
 * @property $username
 * @property $email
 * @property $password
 **/
class SignUpForm extends User {

    public $password;

    public function rules() {
        $rules = [
            [['email'], 'email'],
            [['username', 'email' ], 'trim'],
            [['email'], 'string', 'max' => 255 ],
            [['password'], 'string', 'min' => 4 ],
            [['username', 'email'], 'required'],
            [['username'], 'string', 'min' => 2, 'max' => 255],
            [['email'], 'unique',
                'targetClass' => User::class,
                'message' => Yii::t('app', 'This email address has already been taken.')
            ],
            [['username'], 'unique',
                'targetClass' => User::class,
                'message' => \Yii::t('app', 'This username has already been taken')
            ],
        ];

        return ArrayHelper::merge( parent::rules(), $rules );
    }

    /**
     * Signs user up.
     *
     * @return boolean
     * @throws \yii\base\Exception
     */
    public function register() {
        $randomPassword = Yii::$app->security->generateRandomString(6 );
        $this->setPassword( $randomPassword );
        $this->generateAuthKey();
        $this->sendEmail($randomPassword, $this->username, $this->email );
        return $this->save();
    }
    /**
     * Отправка почты
     * @param $password
     * @param $username
     * @param $email
    */
    private function sendEmail( $password, $username, $email ) {
        Yii::$app->mailer->compose()
            ->setFrom( Yii::$app->params['senderEmail'] )
            ->setTo( $email )
            ->setSubject( Yii::t('app', 'yours account data'))
            ->setHtmlBody('
                <b>'.Yii::t('app', 'login').':</b>
                <span>'. $username.'</span><br/>
                <b>'.Yii::t('app', 'password').':</b>
                <span>'.$password.'</span>
            ')
            ->send();
    }
}

