<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],

            'nama_kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'wali_kelas' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'jumlah_siswa' => [
                'type' => 'INT',
                'null' => true
            ]

        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('kelas');
    }

    public function down()
    {
        //
        $this->forge->dropTable('kelas');
    }
}