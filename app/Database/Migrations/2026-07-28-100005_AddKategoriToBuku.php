<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKategoriToBuku extends Migration
{
    public function up()
    {
        $this->forge->addColumn('buku', [
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'judul',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('buku', 'kategori');
    }
}
