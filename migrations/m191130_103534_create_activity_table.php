<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%activity}}`.
 */
class m191130_103534_create_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('activity', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('название собития'),
            'started_at' => $this->timestamp()->notNull()->comment('начало собития'),
            'finished_at' => $this->timestamp()->notNull()->comment('завершение собития'),
            'is_main' => $this->boolean()->notNull()->defaultValue(false )
                ->comment('указатель является ли событие основным'),
            'desc' => $this->text(),
            'created_at' => $this->bigInteger(),
            'updated_at' => $this->bigInteger()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('activity');
    }
}
