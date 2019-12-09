<?php

use yii\db\Migration;

/**
 * Class m190529_143243_Multilingual_KSL
 */
class m190529_143243_Multilingual_KSL extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        //Создание таблицы для категорий
        $this->createTable('{{%lang_post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'text' => $this->text()->notNull(),
            'lang' => $this->string()->notNull(),
            'post_id' => $this->integer(10),
        ], $tableOptions);

        //Создание таблиц постов
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull()->unique(),
            'author' => $this->string()->notNull(),
        ], $tableOptions);


        //Создание индекса в таблице lang_post для ячейки 'post_id'
        $this->createIndex('FK_lang_post', '{{%lang_post}}', 'post_id');

        /* Связывание таблицы lang_post с таблицей post по первичным ключам.
        * При удалении записи в таблице post, записи из графы post_id таблицы lang_post будут обновлены на NULL,
        * а при обновлении записи в таблице post, записи из графы post_id таблицы lang_post будут обновлены соответственно.
        */
        $this->addForeignKey(
            'FK_lang_post', '{{%lang_post}}', 'post_id', '{{%post}}', 'id', 'SET NULL', 'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%lang_post}}');
        $this->dropTable('{{%post}}');
    }
}