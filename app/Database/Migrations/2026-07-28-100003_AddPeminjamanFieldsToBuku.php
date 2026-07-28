<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPeminjamanFieldsToBuku extends Migration
{
    public function up()
    {
        $this->forge->addColumn('buku', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['tersedia', 'dipinjam'],
                'default'    => 'tersedia',
                'after'      => 'stok',
            ],
            'anggota_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'status',
            ],
            'tanggal_pinjam' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'anggota_id',
            ],
        ]);

        $this->forge->addForeignKey('anggota_id', 'anggota', 'id', 'SET NULL', 'CASCADE');
        $this->forge->processIndexes('buku');
    }

    public function down()
    {
        $this->forge->dropForeignKey('buku', 'buku_anggota_id_foreign');
        $this->forge->dropColumn('buku', ['status', 'anggota_id', 'tanggal_pinjam']);
    }
}
