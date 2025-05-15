<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiswaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama'                  => ['type' => 'VARCHAR', 'constraint' => 255],
            'jk'                    => ['type' => 'CHAR', 'constraint' => 1],
            'nisn'                  => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'tempat_lahir'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'tanggal_lahir'         => ['type' => 'DATE'],
            'nik'                   => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'agama'                 => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'alamat'                => ['type' => 'TEXT', 'null' => true],
            'rt'                    => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'rw'                    => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'dusun'                 => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'kelurahan'             => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'kecamatan'             => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'kode_pos'              => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'jenis_tinggal'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'default' => 'Bersama Orang Tua'],
            'alat_transportasi'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'hp'                    => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'nama_ayah'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tahun_lahir_ayah'      => ['type' => 'YEAR', 'null' => true],
            'pendidikan_ayah'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'pekerjaan_ayah'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'penghasilan_ayah'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'nik_ayah'              => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'nama_ibu'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tahun_lahir_ibu'       => ['type' => 'YEAR', 'null' => true],
            'pendidikan_ibu'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'pekerjaan_ibu'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'penghasilan_ibu'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'nik_ibu'               => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'rombel_saat_ini'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'no_registrasi_akta_lahir' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'kebutuhan_khusus'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'sekolah_asal'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'anak_ke'               => ['type' => 'INT', 'null' => true],
            'no_kk'                 => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'berat_badan'           => ['type' => 'FLOAT', 'null' => true],
            'tinggi_badan'          => ['type' => 'FLOAT', 'null' => true],
            'lingkar_kepala'        => ['type' => 'FLOAT', 'null' => true],
            'jml_saudara_kandung'   => ['type' => 'INT', 'null' => true],
            'jarak_rumah_ke_sekolah' => ['type' => 'FLOAT', 'null' => true],
            'created_at'            => ['type' => 'DATETIME', 'null' => true],
            'updated_at'            => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('siswa');
    }

    public function down()
    {
        $this->forge->dropTable('siswa');
    }
}