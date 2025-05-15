<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeacherTable extends Migration
{
    public function up()
    {
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
            'alamat_jalan'        => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'desa_kelurahan'      => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'kecamatan'           => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
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
            'sk_pengangkatan'     => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'tmt_pengangkatan'    => [
                'type'       => 'DATE',
                'null'       => true,
            ],
            'lembaga_pengangkatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'sumber_gaji'         => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'nama_ibu_kandung'    => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'nik'                 => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'created_at'          => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'          => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('guru');
    }

    public function down()
    {
        $this->forge->dropTable('guru');
    }
}