<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_item_child}}`.
 */
class m191214_145309_create_auth_item_child_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('auth_item_child', [
            'parent' => $this->string(64)->notNull(),
            'child' =>$this->string(64)->notNull()
        ]);
        $this->addPrimaryKey('item-child-key', 'auth_item_child', ['parent', 'child']);

        $this->addForeignKey(
            'fk-auth_item_child-parent',
            'auth_item_child',
            'parent',
            'auth_item',
            'name',
            'CASCADE',
        );

        $this->addForeignKey(
            'fk-auth_item_child-child',
            'auth_item_child',
            'child',
            'auth_item',
            'name',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-auth_item_child-parent', 'auth_item_child' );
        $this->dropForeignKey('fk-auth_item_child-child', 'auth_item_child' );
        $this->dropTable('auth_item_child');
    }
}
