<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%days}}`.
 */
class m191130_113439_create_days_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%days}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('имя записи'),
            'is_weekend' => $this->boolean()->notNull()->defaultValue(false)
                ->comment('флаг указывающий что день является выходным'),
            'is_deleted' => $this->boolean()->notNull()->defaultValue( false )
                ->comment('флаг активности записи'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%days}}');
    }
}
