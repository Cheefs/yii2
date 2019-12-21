<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_assignment}}`.
 */
class m191214_145347_create_auth_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('auth_assignment', [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()
        ]);

        $this->addPrimaryKey('auth_assignment_pk', 'auth_assignment', ['item_name', 'user_id']);

        $this->addForeignKey(
            'fk-auth_assignment-user_id',
            'auth_assignment',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-auth_assignment-item_name',
            'auth_assignment',
            'item_name',
            'auth_item',
            'name',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-auth_assignment-user_id', 'auth_assignment');
        $this->dropForeignKey('fk-auth_assignment-item_name', 'auth_assignment');
        $this->dropTable('auth_assignment');
    }
}
