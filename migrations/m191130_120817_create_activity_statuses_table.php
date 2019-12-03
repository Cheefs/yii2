<?php

use yii\db\Migration;

/**
 * Таблица статусов событий, они могут быть удаленны\перенесенны\пропушенны и тд
 * Handles the creation of table `{{%activity_statuses}}`.
 */
class m191130_120817_create_activity_statuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%activity_statuses}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('название статуса'),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false)
                ->comment('флаг активности записи')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%activity_statuses}}');
    }
}
