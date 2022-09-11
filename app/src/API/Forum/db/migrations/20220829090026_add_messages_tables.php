<?php
declare(strict_types=1);

use Phinx\Db\Action\AddColumn;
use Phinx\Migration\AbstractMigration;

final class AddMessagesTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->table('posts')
            ->addColumn('content', 'string')
            ->addColumn('user_id', 'integer')
            ->AddColumn('thread_id', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addForeignKey('thread_id', 'threads', 'id', ['delete' => 'CASCADE'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE'])
            ->create();
    }
}
