<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class MsgTable extends AbstractMigration
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
        $table = $this->table('messages');
        $table->addColumn('name', 'string')
            ->addColumn('content', 'text', ['limit' => MysqlAdapter::TEXT_LONG])
            ->addColumn('created_by', 'string')
            ->addColumn('created_at', 'datetime')
            ->create();
    }
}
