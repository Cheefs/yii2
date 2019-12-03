<?php

use yii\db\Migration;

/**
 * Таблица  связки пользователя и события
 * Handles the creation of table `{{%activity_to_users}}`.
 */
class m191130_110208_create_activity_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%activity_to_users}}', [
            'activity_id' => $this->integer()->notNull()->comment('указатель на активность'),
            'user_id' => $this->integer()->notNull()->comment('указатель на пользователя'),
        ]);
        /** внешний ключь для связи с событием */
        $this->addForeignKey(
            'fk-activity-to-users-activity_id',
            'activity_to_users',
            'activity_id',
            'activity',
            'id',
            'CASCADE'
        );
        /** внешний ключь для связи с пользователем */
        $this->addForeignKey(
            'fk-activity-to-users-user_id',
            'activity_to_users',
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
            'fk-activity-to-users-activity_id',
            'activity_to_users'
        );
        $this->dropForeignKey(
            'fk-activity-to-users-user_id',
            'activity_to_users'
        );
        $this->dropTable('{{%activity_to_users}}');
    }
}
