<?php


use Phinx\Migration\AbstractMigration;

class CreateInitialTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('box_volumes', ['id' => false, 'primary_key' => 'type'])
            ->addColumn('type', 'string', ['length' => 2, 'comment' => 'тип тары'])
            ->addColumn('volume', 'integer', ['comment' => 'объем (литр)'])
            ->create();

        $this->table('goods')
            ->addColumn('shop_name', 'string', ['comment' => 'имя поставщика'])
            ->addColumn('box_type', 'string', ['length' => 2, 'comment' => 'тип тары'])
            ->addColumn('price', 'integer', ['comment' => 'цена товара'])
            ->create();

        $this->table('consumption', ['id' => false])
            ->addColumn('consumption', 'integer', ['comment' => 'расход (литр/метр кв.)'])
            ->create();
    }
}
