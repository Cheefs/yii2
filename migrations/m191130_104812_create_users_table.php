<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m191130_104812_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        /**
          * в модели user хранятся также поля $authKey и $accessToken но они используются в сессиях и в базу ненужны
          * но пока что внес и их в таблицу, для наполнения, потом перерабоаем
         */
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->unique()->notNull()->comment('имя пользователя'),
            'password' => $this->string()->notNull()->comment('пароль'),
            'authKey' => $this->string()->notNull()->comment('ключ доступа к чемуто'),
            'accessToken' => $this->string()->notNull()->comment('токен')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
