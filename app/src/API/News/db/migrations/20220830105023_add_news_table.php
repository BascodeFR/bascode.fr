<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddNewsTable extends AbstractMigration
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
        $this->table('news')
        ->addColumn('name', 'string', ['limit' => 255])
        ->addColumn('slug', 'string', ['limit' => 255])
        ->addColumn('avatar', 'string', ['limit' => 255])
        ->addColumn('content', 'string', ['limit' => 6000])
        ->addColumn('created_at', 'datetime')
        ->addColumn('updated_at', 'datetime')
        ->create();
    }
}
