<?php

use yii\db\Migration;

class m231023_225201_initial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->getDb()->createCommand(
            <<<SQL
                CREATE TABLE blog (
                    uid VARCHAR(255) not null primary key,
                    userUid VARCHAR(255) not null,
                    header VARCHAR(255) not null,
                    text TEXT not null
                );

                CREATE TABLE user (
                    uid VARCHAR(255) not null primary key,
                    login VARCHAR(255) not null,
                    password VARCHAR(255) not null
                );
            SQL
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->getDb()->createCommand(
            <<<SQL
                DROP TABLE blog;

                DROP TABLE user;
            SQL
        )->execute();
    }
}
