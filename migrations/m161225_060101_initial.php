<?php

class m161225_060101_initial extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%group}}', [
            'id'   => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
        ]);

        $this->createTable('{{%user}}', [
            'id'            => $this->bigPrimaryKey(),
            'email'         => $this->string(255)->notNull()->unique(),
            'last_name'     => $this->string(255),
            'first_name'    => $this->string(255),
            'state'         => $this->smallInteger()->notNull()->defaultValue('0'),
            'creation_date' => $this->timestamp()->notNull()->defaultExpression('now()'),
            'group_id'      => $this->bigInteger()->notNull(),
        ]);

        $this->addForeignKey(
            'users_to_groups_fk',
            '{{%user}}',
            'group_id',
            '{{%group}}',
            'id'
        );
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%group}}');
    }
}
