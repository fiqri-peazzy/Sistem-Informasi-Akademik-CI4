<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name'      => 'Admin Utama',
            'username'  => 'admin',
            'email'     => 'admin@tkalhijrah.sch.id',
            'password'  => password_hash('admin123', PASSWORD_DEFAULT),
            'role'      => 'admin',
            'picture'   => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Masukkan data ke tabel users
        $this->db->table('users')->insert($data);
    }
}