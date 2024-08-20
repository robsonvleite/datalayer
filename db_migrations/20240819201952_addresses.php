<?php declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class Addresses extends AbstractMigration
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
        $table = $this->table('addresses');
        $table
            ->addColumn('user_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'signed' => false])
            ->addColumn('cep', 'string', ['limit' => 8])
            ->addColumn('address', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp')
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();

        if ($this->isMigratingUp()) {
            $rows = [
                [
                    'user_id' => 1,
                    'cep' => '69050000',
                    'address' => 'Avenida Constantino Nery, 1000'
                ], [
                    'user_id' => 2,
                    'cep' => '69050010',
                    'address' => 'Avenida Djalma Batista, 1'
                ]
            ];

            $table->insert($rows)->saveData();
        }
    }
}
