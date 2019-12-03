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
        $this->createTable('{{%activity}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('название собития'),
            'from' => $this->dateTime()->notNull()->comment('дата и время начала собития'),
            'to' => $this->dateTime()->notNull()->comment('дата и время завершения собития'),
            'is_main' => $this->boolean()->notNull()->defaultValue(false )
                ->comment('указатель является ли событие основным'),
            'desc' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%activity}}');
    }
}
