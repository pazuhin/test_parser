
<?php

use Phinx\Migration\AbstractMigration;

class CreateFilmTable extends AbstractMigration
{

    public function up()
    {
        $films = $this->table('films');
        $films
            ->addColumn('position', 'integer')
            ->addColumn('rating', 'float')
            ->addColumn('name', 'string')
            ->addColumn('year', 'integer')
            ->addColumn('votes', 'integer')
            ->addColumn('date', 'datetime')
            ->addColumn('score', 'float')
            ->addColumn('story', 'string')
            ->addColumn('img', 'string')
            ->addColumn('category_id', 'integer')
            ->addForeignKey('category_id', 'categories', 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'])
            ->save();
    }

    public function down()
    {
        $this->table('films')->drop();
    }

}