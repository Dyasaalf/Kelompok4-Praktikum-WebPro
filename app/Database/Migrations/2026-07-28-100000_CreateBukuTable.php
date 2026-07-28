<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBukuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_buku' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'pengarang' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'penerbit' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'tahun_terbit' => [
                'type'       => 'YEAR',
                'null'       => true,
            ],
            'stok' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kode_buku');
        $this->forge->createTable('buku');
    }

    public function down()
    {
        $this->forge->dropTable('buku');
    }
}
