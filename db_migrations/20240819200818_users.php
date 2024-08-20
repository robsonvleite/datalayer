<?php declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Users extends AbstractMigration
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
        $table = $this->table('users');
        $table
            ->addColumn('first_name', 'string', ['limit' => 80, 'null' => false])
            ->addColumn('last_name', 'string', ['limit' => 80, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp')
            ->create();

        if ($this->isMigratingUp()) {
            $rows = [
                [
                    'first_name' => 'Robson',
                    'last_name' => 'Leite'
                ],
                [
                    'first_name' => 'William',
                    'last_name' => 'Sampaio'
                ],
                [
                    'first_name' => 'Alex Alan',
                    'last_name' => 'Nunes'
                ],
                [
                    'first_name' => 'Elton',
                    'last_name' => 'Mel'
                ],
                [
                    'first_name' => 'Wilder',
                    'last_name' => 'Amorim'
                ],
                [
                    'first_name' => 'Omni',
                    'last_name' => 'Species'
                ],
                [
                    'first_name' => 'Juliano',
                    'last_name' => 'Giacomeli'
                ]
            ];

            $table->insert($rows)->saveData();
        }
    }
}
