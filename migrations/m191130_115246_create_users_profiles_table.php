<?php

use yii\db\Migration;

/**
 * Таблица профилей пользователей
 * Handles the creation of table `{{%users_profiles}}`.
 */
class m191130_115246_create_users_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_profiles}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('указатель на пользователя'),
            'first_name' => $this->string()->notNull()->comment('имя пользователя'),
            'last_name' => $this->string()->notNull()->comment('фамилия пользователя'),
            'second_name' => $this->string()->notNull()->comment('отчество пользователя'),
            'phone' => $this->string()->comment('телефон пользователя'),
            'email' => $this->string()->comment('почта пользователя'),
        ]);

        $this->addForeignKey(
            'fk-users-profiles-user_id',
            'users_profiles',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-users-profiles-user_id',
            'users_profiles'
        );
        $this->dropTable('{{%users_profiles}}');
    }
}
