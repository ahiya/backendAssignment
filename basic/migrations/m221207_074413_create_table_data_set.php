<?php

use yii\db\Migration;

/**
 * Class m221207_074413_create_table_data_set
 */
class m221207_074413_create_table_data_set extends Migration
{
    public function safeUp()
    {
        $options = null;
        if (\Yii::$app->db->getDriverName() === 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%data_set}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'timezone' => $this->string(),
            'week_of_day' => $this->string(),
            'available_at' => $this->string(),
            'available_untill' => $this->string(),
        ], $options);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%data_set}}');
    }
}
