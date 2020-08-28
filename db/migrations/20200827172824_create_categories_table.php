
<?php

use Phinx\Migration\AbstractMigration;

class CreateCategoriesTable extends AbstractMigration
{

    public function up()
    {
        $cats = $this->table('categories');
        $cats
            ->addColumn('name', 'string')
            ->save();
    }

    public function down()
    {
        $this->table('categories')->drop();
    }

}
