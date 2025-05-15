<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RecreateGuruTable extends Migration
{
    public function up()
    {
        // Hapus tabel guru jika ada
        $this->forge->dropTable('guru', true);

        // Buat ulang tabel guru dengan struktur baru
        $this->forge->addField([
            'id'                  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama'                => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'jk'                  => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'null'       => false,
            ],
            'tempat_lahir'        => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'tanggal_lahir'       => [
                'type'       => 'DATE',
                'null'       => true,
            ],
            'status_kepegawaian'  => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'jenis_ptk'           => [
                'type'       => 'ENUM',
                'constraint' => ['Guru', 'Tenaga Kependidikan', 'Kepala Sekolah', 'Guru Honor Sekolah', 'GTY/PTY'],
                'null'       => false,
            ],
            'agama'               => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            'hp'                  => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'email'               => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'nik'                 => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('guru');
    }

    public function down()
    {
        // Drop tabel guru saat rollback
        $this->forge->dropTable('guru');
    }
}