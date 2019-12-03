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
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->unique()->notNull()->comment('имя пользователя'),
            'password' => $this->string()->notNull()->comment('пароль'),
            'first_name' => $this->string()->notNull()->comment('имя пользователя'),
            'last_name' => $this->string()->notNull()->comment('фамилия пользователя'),
            'second_name' => $this->string()->notNull()->comment('отчество пользователя'),
            'phone' => $this->string()->comment('телефон пользователя'),
            'email' => $this->string()->notNull()->unique()->comment('почта пользователя'),
            'auth_key' => $this->string(32)->notNull()->comment('ключ аутификации'),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false)->comment('флаг активности')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
