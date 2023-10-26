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
                CREATE TABLE blog_post (
                    uid VARCHAR(255) not null primary key,
                    userUid VARCHAR(255) not null,
                    header VARCHAR(255) not null,
                    text TEXT not null,
                    createdAt TIMESTAMP not null
                );

                CREATE TABLE user (
                    uid VARCHAR(255) not null primary key,
                    login VARCHAR(255) not null,
                    password VARCHAR(255) not null
                );

                CREATE INDEX blog_post_createdAt ON blog_post (createdAt DESC);
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
                DROP TABLE blog_post;

                DROP TABLE user;
            SQL
        )->execute();
    }
}
