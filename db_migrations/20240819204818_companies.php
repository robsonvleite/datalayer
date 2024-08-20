<?php declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class Companies extends AbstractMigration
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
        // create the table
        $table = $this->table('companies');
        $table
            ->addColumn('user_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'signed' => false])
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp')
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();

        if ($this->isMigratingUp()) {
            $rows = [
                [
                    'user_id' => 1,
                    'name' => 'CoffeeCode'
                ],
                [
                    'user_id' => 2,
                    'name' => 'Eugência de Desenvolvimento de Software'
                ],
                [
                    'user_id' => 3,
                    'name' => 'CoffeeCode'
                ],
                [
                    'user_id' => 4,
                    'name' => 'CoffeeCode'
                ],
                [
                    'user_id' => 5,
                    'name' => 'CoffeeCode'
                ],
                [
                    'user_id' => 6,
                    'name' => 'CoffeeCode'
                ],
                [
                    'user_id' => 7,
                    'name' => 'CoffeeCode'
                ]
            ];

            $table->insert($rows)->saveData();
        }
    }
}
