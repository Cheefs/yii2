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
use yii\base\Model;
use yii\db\Transaction;
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
            [['username', 'email', 'password'], 'required'],
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
    public function register()
    {
        $this->setPassword($this->password);
        $this->generateAuthKey();
        return $this->save();
    }
}