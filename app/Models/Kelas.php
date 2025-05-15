<?php

namespace App\Models;

use CodeIgniter\Model;

class Kelas extends Model
{
    protected $table            = 'kelas';
    protected $primaryKey       = 'id';

    protected $allowedFields    = ['nama_kelas', 'wali_kelas', 'jumlah_siswa'];
}