<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateSiswaTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('siswa');

        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama'            => ['type' => 'VARCHAR', 'constraint' => 255],
            'jk'              => ['type' => 'CHAR', 'constraint' => 1],
            'nisn'            => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'tempat_lahir'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'tanggal_lahir'   => ['type' => 'DATE'],
            'nik'             => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'agama'           => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'alamat'          => ['type' => 'TEXT', 'null' => true],

            'rombel_saat_ini' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],

        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('siswa');
    }

    public function down()
    {
        $this->forge->dropTable('siswa');
    }
}