<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordToAnggota extends Migration
{
    public function up()
    {
        $this->forge->addColumn('anggota', [
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'nis_nim',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('anggota', 'password');
    }
}
