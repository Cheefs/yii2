<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username имя пользователя
 * @property string $password_hash пароль
 * @property string $first_name имя пользователя
 * @property string $last_name фамилия пользователя
 * @property string $second_name отчество пользователя
 * @property string $phone телефон пользователя
 * @property string $email почта пользователя
 * @property string $auth_key ключ аутификации
 * @property string $password_reset_token
 * @property int $is_deleted флаг активности
 *
 * @property ActivityToUsers[] $activityToUsers
 * @property Calendar[] $calendars
 */
class User extends ActiveRecord implements IdentityInterface
{
    const IS_DELETED = true;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['is_deleted'], 'integer'],
            [['username', 'first_name', 'last_name', 'second_name', 'phone', 'email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'second_name' => Yii::t('app', 'Second Name'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityToUsers() {
        return $this->hasMany(ActivityToUsers::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendars() {
        return $this->hasMany(Calendar::class, ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'is_deleted' => !self::IS_DELETED]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'is_deleted' => !self::IS_DELETED]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /** Generates "remember me" authentication key */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}
