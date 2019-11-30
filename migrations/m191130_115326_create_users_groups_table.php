<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_groups}}`.
 */
class m191130_115326_create_users_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_groups}}', [
            'group_id' => $this->integer()->notNull()->comment('указатель на группу'),
            'user_id' => $this->integer()->notNull()->comment('указатель на пользователя'),
        ]);

        $this->addForeignKey(
            'fk-users_groups-group_id',
            'users_groups',
            'group_id',
            'groups',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-users_groups-user_id',
            'users_groups',
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
            'fk-users_groups-group_id',
            'users_groups'
        );

        $this->dropForeignKey(
            'fk-users_groups-user_id',
            'users_groups'
        );

        $this->dropTable('{{%users_groups}}');
    }
}
