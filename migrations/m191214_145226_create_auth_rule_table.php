<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_rule}}`.
 */
class m191214_145226_create_auth_rule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('auth_rule', [
            'name' => $this->string(64)->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),

        ]);

        $this->addPrimaryKey('', 'auth_rule', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('auth_rule');
    }
}