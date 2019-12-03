<?php

use yii\db\Migration;

/**
 * Таблица групп ( для регулировки по правам )
 * Handles the creation of table `{{%groups}}`.
 */
class m191130_115302_create_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%groups}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('название группы'),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false)
                ->comment('флаг активности записи'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%groups}}');
    }
}
