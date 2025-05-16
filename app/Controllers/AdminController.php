<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CiAuth;
use App\Libraries\Hash;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use SSP;

class AdminController extends BaseController
{
    protected $helpers = ['url', 'form'];
    protected $db;
    public function __construct()
    {
        require_once APPPATH . 'ThirdParty/ssp.php';
        $this->db = db_connect();
        $this->sql_details = [
            'user' => env('database.default.username'),
            'pass' => env('database.default.password'),
            'db'   => env('database.default.database'),
            'host' => env('database.default.hostname'),
        ];
    }

    public function index()
    {
        $data = [
            'pageTitle' => 'Dashboard Admin'
        ];

        return view('backend/pages/home', $data);
    }
    public function logoutHandler()
    {
        CiAuth::forget();
        return redirect()->route('admin.login.form')->with('fail', 'anda telah logout');
    }

    public function pageGuru()
    {
        return view('backend/pages/pageGuru', ['pageTitle' => 'Data Guru']);
    }

    public function dataGuruStore()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $rules = [
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harap masukkan nama guru.'
                    ]
                ],
                'jk' => [
                    'rules' => 'required|in_list[L,P]',
                    'errors' => [
                        'required' => 'Harap pilih jenis kelamin.',
                        'in_list'  => 'Jenis kelamin tidak valid.'
                    ]
                ],
                'tempat_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harap masukkan tempat lahir.'
                    ]
                ],
                'tanggal_lahir' => [
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required'   => 'Harap masukkan tanggal lahir.',
                        'valid_date' => 'Format tanggal lahir tidak valid.'
                    ]
                ],
                'status_kepegawaian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harap masukkan status kepegawaian.'
                    ]
                ],
                'jenis_ptk' => [
                    'rules' => 'required|in_list[GURU,Tenaga Kependidikan,Kepala Sekolah,Guru Honor Sekolah,GTY/PTY,Guru]',
                    'errors' => [
                        'required' => 'Harap pilih jenis PTK.',
                        'in_list'  => 'Jenis PTK tidak valid.'
                    ]
                ],
                'hp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harap masukkan nomor HP.'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required'    => 'Harap masukkan email.',
                        'valid_email' => 'Format email tidak valid.'
                    ]
                ],
            ];
            if (!$this->validate($rules)) {
                return $this->response->setJSON(['error' => $validation->getErrors()]);
            }


            $data = $this->request->getPost();
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            $guruModel = new Guru();

            if ($guruModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => 1,
                    'msg'    => 'Data guru berhasil disimpan.'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg'    => 'Gagal menyimpan data guru.'
                ]);
            }
        }
    }

    public function importGuru()
    {
        $file = $this->request->getFile('file_excel');
        if (!$file->isValid()) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'File tidak valid']);
        }

        $ext = $file->getClientExtension();
        if (!in_array($ext, ['xlsx', 'xls'])) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Format file harus .xlsx atau .xls']);
        }

        $tempPath = WRITEPATH . '../public/uploads_temp/';
        if (!is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        $fileName = $file->getRandomName();
        $file->move($tempPath, $fileName);
        $filePath = $tempPath . $fileName;

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        unlink($filePath);

        $guruModel = new \App\Models\Guru();
        $countInserted = 0;
        $errors = [];

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];

            // Cek baris kosong
            $isEmptyRow = true;
            foreach ($row as $cell) {
                if (trim($cell) !== '') {
                    $isEmptyRow = false;
                    break;
                }
            }
            if ($isEmptyRow) continue;

            // Ambil data sesuai kolom baru (index kolom disesuaikan)
            $nama = trim($row[1] ?? '');
            $jk = trim($row[2] ?? '');
            $tempat_lahir = trim($row[3] ?? '');
            $tanggal_lahir = trim($row[4] ?? '');
            $status_kepegawaian = trim($row[5] ?? '');
            $jenis_ptk = trim($row[6] ?? '');
            $agama = trim($row[7] ?? '');
            $hp = trim($row[8] ?? '');
            $email = trim($row[9] ?? '');
            $nik = trim($row[10] ?? '');

            // Validasi wajib
            if (empty($nama) || empty($jk) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($status_kepegawaian) || empty($jenis_ptk) || empty($hp) || empty($email)) {
                $errors[] = "Baris " . ($i + 1) . ": Data wajib tidak lengkap.";
                continue;
            }

            // Cek duplikat berdasarkan email, nama, dan NIK
            $exists = $guruModel->where('email', $email)
                ->orWhere('nama', $nama)
                ->orWhere('nik', $nik)
                ->first();

            if ($exists) {
                $errors[] = "Baris " . ($i + 1) . ": Data duplikat ditemukan (email/nama/nik).";
                continue;
            }

            $dataInsert = [
                'nama' => $nama,
                'jk' => $jk,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => date('Y-m-d', strtotime($tanggal_lahir)),
                'status_kepegawaian' => $status_kepegawaian,
                'jenis_ptk' => $jenis_ptk,
                'agama' => $agama,
                'hp' => $hp,
                'email' => $email,
                'nik' => $nik,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $guruModel->insert($dataInsert);
            $countInserted++;
        }

        if (count($errors) > 0) {
            return $this->response->setJSON([
                'status' => 0,
                'msg' => 'Beberapa data gagal diimpor: ' . implode('; ', $errors)
            ]);
        }

        return $this->response->setJSON([
            'status' => 1,
            'count' => $countInserted,
            'msg' => 'Berhasil menambahkan ' . $countInserted . ' data guru.'
        ]);
    }

    public function datatablesGuru()
    {
        $table = 'guru';
        $primaryKey = 'id';

        $columns = [
            ['db' => 'id', 'dt' => 0],
            ['db' => 'nama', 'dt' => 1],
            ['db' => 'email', 'dt' => 2],
            ['db' => 'status_kepegawaian', 'dt' => 3],
            [
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($d, $row) {
                    return '<button data-id=' . $d . ' class="btn btn-sm btn-warning btnEditGuru" title="edit"><i class="fa fa-edit"></i></button> ' .
                        '<button data-id="' . $d . '" class="btn btn-sm btn-danger btn-delete btnDeleteGuru" title="hapus"><i class="fa fa-trash"></i></button>';
                }
            ]
        ];

        // Database connection info
        $sql_details = [
            'user' => env('database.default.username'),
            'pass' => env('database.default.password'),
            'db'   => env('database.default.database'),
            'host' => env('database.default.hostname')
        ];


        return json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }

    public function dataGuru()
    {

        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $id = $request->getVar('id_guru');

            $guruModel = new Guru();
            $data = $guruModel->find($id);
            return $this->response->setJSON(['data' => $data]);
        }
    }

    public function dataGuruUpdate()
    {
        if ($this->request->isAJAX()) {
            $data = $this->request->getPost();

            $validation = \Config\Services::validation();

            $rules = [
                'nama' => [
                    'rules' => "required|is_unique[guru.nama,id," . $data['id'] . "]",
                    'errors' => [
                        'required' => 'Harap masukkan nama guru.',
                        'is_unique' => 'Nama guru sudah terdaftar.'
                    ]
                ],
                'jk' => [
                    'rules' => 'required|in_list[L,P]',
                    'errors' => [
                        'required' => 'Harap pilih jenis kelamin.',
                        'in_list' => 'Jenis kelamin tidak valid.'
                    ]
                ],
                'tempat_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harap masukkan tempat lahir.'
                    ]
                ],
                'tanggal_lahir' => [
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => 'Harap masukkan tanggal lahir.',
                        'valid_date' => 'Format tanggal lahir tidak valid.'
                    ]
                ],
                'status_kepegawaian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harap masukkan status kepegawaian.'
                    ]
                ],
                'jenis_ptk' => [
                    'rules' => 'required|in_list[GURU,Tenaga Kependidikan,Kepala Sekolah,Guru Honor Sekolah,GTY/PTY,Guru]',
                    'errors' => [
                        'required' => 'Harap pilih jenis PTK.',
                        'in_list' => 'Jenis PTK tidak valid.'
                    ]
                ],
                'hp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harap masukkan nomor HP.'
                    ]
                ],
                'email' => [
                    'rules' => "required|valid_email|is_unique[guru.email,id," . $data['id'] . "]",
                    'errors' => [
                        'required' => 'Harap masukkan email.',
                        'valid_email' => 'Format email tidak valid.',
                        'is_unique' => 'Email sudah terdaftar.'
                    ]
                ],
                'nik' => [
                    'rules' => "permit_empty|is_unique[guru.nik,id," . $data['id'] . "]",
                    'errors' => [
                        'is_unique' => 'NIK sudah terdaftar.'
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON(['error' => $validation->getErrors()]);
            }

            $data['updated_at'] = date('Y-m-d H:i:s');

            $guruModel = new Guru();

            if ($guruModel->update($data['id'], $data)) {
                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'Data guru berhasil diperbarui.'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Gagal memperbarui data guru.'
                ]);
            }
        }
    }

    public function dataGuruDrop()
    {
        $request = \Config\Services::request();


        if ($request->isAJAX()) {
            $id = $request->getGet('id_guru');

            if (!$id) {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'ID guru tidak ditemukan.'
                ]);
            }

            $guruModel = new Guru();

            if ($guruModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'Data guru berhasil dihapus.'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Gagal menghapus data guru.'
                ]);
            }
        }
    }

    public function pageSiswa()
    {
        $kelas = new \App\Models\Kelas();

        return view('backend/pages/pageSiswa', ['pageTitle' => 'Data Siswa', 'kelas' => $kelas->asObject()->findAll()]);
    }

    public function dataSiswaStore()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $validationRules = [
                'nama' => [
                    'rules' => 'required|min_length[3]',
                    'errors' => [
                        'required' => 'Nama lengkap wajib diisi.',
                        'min_length' => 'Nama minimal 3 karakter.'
                    ]
                ],
                'jk' => [
                    'rules' => 'required|in_list[L,P]',
                    'errors' => [
                        'required' => 'Jenis kelamin wajib dipilih.',
                        'in_list' => 'Jenis kelamin tidak valid.'
                    ]
                ],
                'tempat_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tempat lahir wajib diisi.'
                    ]
                ],
                'nisn' => [
                    'rules' => 'required|is_unique[siswa.nisn]',
                    'errors' => [
                        'required' => 'NISN wajib diisi.',
                        'is_unique' => 'NISN Tidak Boleh Sama'
                    ]
                ],
                'nik' => [
                    'rules' => 'required|is_unique[siswa.nik]',
                    'errors' => [
                        'required' => 'NIK wajib diisi.',
                        'is_unique' => 'NIK Tidak Boleh Sama'
                    ]
                ],
                'tanggal_lahir' => [
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => 'Tanggal lahir wajib diisi.',
                        'valid_date' => 'Format tanggal lahir tidak valid.'
                    ]
                ],
                // Tambahkan rules lain sesuai kebutuhan
            ];

            if (!$this->validate($validationRules)) {
                $errors = $this->validator->getErrors();
                return $this->response->setJSON([
                    'status' => 0,
                    'error' => $errors,
                    'msg' => 'Validasi gagal, periksa inputan Anda.'
                ]);
            }

            $data = $this->request->getPost();
            $siswaModel = new Siswa();
            $siswaModel->insert($data);

            return $this->response->setJSON([
                'status' => 1,
                'msg' => 'Data siswa berhasil disimpan.'
            ]);
        }
    }
    public function datatablesSiswa()
    {
        $table = 'siswa';
        $primaryKey = 'id';

        $columns = [
            ['db' => 'id', 'dt' => 0],
            ['db' => 'nama', 'dt' => 1],
            [
                'db' => 'jk', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return $d == 'P' ? 'Perempuan' : 'Laki-Laki';
                }
            ],
            ['db' => 'nisn', 'dt' => 3],
            [
                'db' => 'rombel_saat_ini',
                'dt' => 4,
                'formatter' => function ($d, $row) {
                    $kelas = new \App\Models\Kelas();
                    $datakelas =  $kelas->asObject()->find($d);
                    return isset($datakelas) ? $datakelas->nama_kelas : 'null';
                }
            ],
            [
                'db' => 'id',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    return '<button data-id=' . $d . ' class="btn btn-sm btn-warning btnEditSiswa" title="edit"><i class="fa fa-edit"></i></button> ' .
                        '<button data-id="' . $d . '" class="btn btn-sm btn-danger btn-delete btnDeleteSiswa" title="hapus"><i class="fa fa-trash"></i></button>';
                }
            ]
        ];

        // Database connection info
        $sql_details = [
            'user' => env('database.default.username'),
            'pass' => env('database.default.password'),
            'db'   => env('database.default.database'),
            'host' => env('database.default.hostname')
        ];


        return json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }

    public function dataSiswa()
    {

        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $id = $request->getVar('id_siswa');

            $siswaModel = new Siswa();
            $data = $siswaModel->find($id);
            return $this->response->setJSON(['data' => $data]);
        }
    }
    public function dataSiswaUpdate()
    {
        $validationRules = [
            'id' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'ID siswa tidak ditemukan.',
                    'integer' => 'ID siswa tidak valid.'
                ]
            ],
            'nama' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama minimal 3 karakter.'
                ]
            ],
            'jk' => [
                'rules' => 'required|in_list[L,P]',
                'errors' => [
                    'required' => 'Jenis kelamin wajib dipilih.',
                    'in_list' => 'Jenis kelamin tidak valid.'
                ]
            ],
            'tempat_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tempat lahir wajib diisi.'
                ]
            ],
            'tanggal_lahir' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal lahir wajib diisi.',
                    'valid_date' => 'Format tanggal lahir tidak valid.'
                ]
            ],
            'nisn' => [
                'rules' => 'permit_empty|is_unique[siswa.nisn,id,{id}]',
                'errors' => [
                    'is_unique' => 'NISN sudah digunakan oleh siswa lain.'
                ]
            ],
            'nik' => [
                'rules' => 'permit_empty|is_unique[siswa.nik,id,{id}]',
                'errors' => [
                    'is_unique' => 'NIK sudah digunakan oleh siswa lain.'
                ]
            ],
            // Tambahkan rules lain sesuai kebutuhan
        ];

        $id = $this->request->getPost('id');

        // Ganti placeholder {id} dengan nilai sebenarnya untuk validasi unik
        foreach ($validationRules as &$rule) {
            if (isset($rule['rules'])) {
                $rule['rules'] = str_replace('{id}', $id, $rule['rules']);
            }
        }

        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            return $this->response->setJSON([
                'status' => 0,
                'error' => $errors,
                'msg' => 'Validasi gagal, periksa inputan Anda.'
            ]);
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'jk' => $this->request->getPost('jk'),
            'nisn' => $this->request->getPost('nisn'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'nik' => $this->request->getPost('nik'),
            'agama' => $this->request->getPost('agama'),
            'alamat' => $this->request->getPost('alamat'),
            'rombel_saat_ini' => $this->request->getPost('rombel_saat_ini'),
        ];

        $siswaModel = new Siswa();
        $siswaModel->update($id, $data);

        return $this->response->setJSON([
            'status' => 1,
            'msg' => 'Data siswa berhasil diperbarui.'
        ]);
    }

    public function dataSiswaDrop()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $id = $request->getGet('id_siswa');

            $siswaModel = new \App\Models\Siswa();

            if (!$siswaModel->find($id)) {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Data siswa tidak ditemukan.'
                ]);
            }

            if ($siswaModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'Data siswa berhasil dihapus.'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Gagal menghapus data siswa.'
                ]);
            }
        }

        // Jika bukan AJAX, bisa redirect atau tampilkan error
        return redirect()->to('/');
    }

    public function pageKelas()
    {
        $guru = new Guru();

        return view('backend/pages/pageKelas', ['pageTitle' => 'Data Kelas', 'guru' => $guru->asObject()->findAll()]);
    }

    public function dataKelasStore()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_kelas' => 'required|is_unique[kelas.nama_kelas]',

        ];

        $errors = [
            'nama_kelas' => [
                'required' => 'Nama kelas wajib diisi.',
                'is_unique' => 'Nama kelas sudah ada, silakan gunakan nama lain.'
            ],
        ];

        if (!$this->validate($rules, $errors)) {
            return $this->response->setJSON([
                'status' => 0,
                'error' => $this->validator->getErrors(),
                'msg' => 'Validasi gagal.'
            ]);
        }

        $kelasModel = new \App\Models\Kelas();

        $data = [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'wali_kelas' => $this->request->getPost('wali_kelas'),
        ];

        if ($kelasModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 1,
                'msg' => 'Data kelas berhasil disimpan.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 2,
                'msg' => 'Gagal menyimpan data kelas.'
            ]);
        }
    }

    public function datatablesKelas()
    {
        $table = 'kelas';
        $primaryKey = 'id';

        $columns = [
            [
                'db' => 'id',
                'dt' => 0,

            ],
            ['db' => 'nama_kelas', 'dt' => 1],
            [
                'db' => 'wali_kelas',
                'dt' => 2,
                'formatter' => function ($d, $row) {
                    $guru = new Guru();
                    $dataGuru = $guru->asObject()->find($d);
                    return $dataGuru->nama;
                }
            ],
            [
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    $siswa = new Siswa();
                    $jumlah_siswa = count($siswa->where('rombel_saat_ini', $d)->findAll());
                    return $jumlah_siswa ?? '-';
                }
            ],
            [
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($d, $row) {
                    $editBtn = '<button class="btn btn-sm btn-warning btn-edit-kelas" data-id="' . $d . '"><i class="fa fa-edit"></i></button>';
                    $deleteBtn = '<button class="btn btn-sm btn-danger btn-delete-kelas" data-id="' . $d . '"><i class="fa fa-trash"></i></button>';
                    return $editBtn . ' ' . $deleteBtn;
                }
            ]
        ];

        $request = $_GET;

        $data = SSP::simple($request, $this->sql_details, $table, $primaryKey, $columns);

        return $this->response->setJSON($data);
    }

    public function dataKelas()
    {
        $id = $this->request->getGet('id');
        $kelasModel = new \App\Models\Kelas();

        $kelas = $kelasModel->find($id);

        if ($kelas) {
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $kelas
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data kelas tidak ditemukan'
            ]);
        }
    }
    public function dataKelasUpdate()
    {
        $validation = \Config\Services::validation();
        $id = $this->request->getVar('id');
        $validation->setRules([
            'nama_kelas' => 'required|string|max_length[100]|is_unique[kelas.nama_kelas,id,' . $id . ']',
            'wali_kelas' => 'required',
        ], [
            'nama_kelas' => [
                'required' => 'Nama kelas harus diisi.',
                'max_length' => 'Nama kelas maksimal 100 karakter.',

                'is_unique' => 'Nama Kelas sudah ada',
            ],
            'wali_kelas' => [
                'required' => 'Wali kelas harus dipilih.',
            ],
        ]);

        $input = $this->request->getPost();

        if (!$validation->run($input)) {
            return $this->response->setJSON([
                'status' => 'validation_error',
                'errors' => $validation->getErrors()
            ]);
        }

        $kelasModel = new \App\Models\Kelas();

        $dataUpdate = [
            'nama_kelas' => $input['nama_kelas'],
            'wali_kelas' => $input['wali_kelas'],
        ];

        $updated = $kelasModel->update($id, $dataUpdate);

        if ($updated) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data kelas berhasil diperbarui.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal memperbarui data kelas.'
            ]);
        }
    }
    public function dataKelasDrop()
    {
        $id = $this->request->getGet('id');

        if (!$id || !is_numeric($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID kelas tidak valid.'
            ]);
        }

        $kelasModel = new \App\Models\Kelas();

        $kelas = $kelasModel->find($id);
        if (!$kelas) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data kelas tidak ditemukan.'
            ]);
        }

        $deleted = $kelasModel->delete($id);

        if ($deleted) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data kelas berhasil dihapus.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menghapus data kelas.'
            ]);
        }
    }

    public function pageUsers()
    {
        $data = [
            'pageTitle' => 'Data Pengguna'
        ];
        return view('backend/pages/pageUsers', $data);
    }

    public function dataUserStore()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $rules = [
                'name' => 'required',
                'username' => 'required|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required',
                'role' => 'required|in_list[admin,guru,kepala,ortu]'
            ];

            $messages = [
                'name' => [
                    'required' => 'Nama wajib diisi.'
                ],
                'username' => [
                    'required' => 'Username wajib diisi.',
                    'is_unique' => 'Username sudah digunakan.'
                ],
                'email' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah digunakan.'
                ],
                'password' => [
                    'required' => 'Password wajib diisi.'
                ],
                'role' => [
                    'required' => 'Role wajib dipilih.',
                    'in_list' => 'Role tidak valid.'
                ]
            ];

            $validation->setRules($rules, $messages);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'error' => $validation->getErrors()
                ]);
            }

            // Simpan data ke database
            $userModel = new User();

            $userModel->save([
                'name' => $this->request->getPost('name'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => Hash::make($this->request->getPost('password')),
                'role' => $this->request->getPost('role')
            ]);

            return $this->response->setJSON([
                'status' => 1,
                'msg' => 'Data pengguna berhasil ditambahkan.'
            ]);
        }

        // Jika bukan AJAX
        return redirect()->back();
    }

    public function datatablesUser()
    {
        $columns = [
            [
                'db' => 'id',
                'dt' => 0,
            ],
            [
                'db' => 'name',
                'dt' => 1,
            ],
            [
                'db' => 'username',
                'dt' => 2,
            ],
            [
                'db' => 'email',
                'dt' => 3,
            ],
            [
                'db' => 'role',
                'dt' => 4,
                'formatter' => function ($d, $row) {
                    return ucfirst($d);
                }
            ],
            [
                'db' => 'id',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    return '
                    <div class="btn-group">
                    <button data-id=' . $d . ' class="btn btn-sm btn-warning btn-edit-user" title="edit">
                    <i class="fa fa-edit"></i>
                    </button> ' .
                        '<button data-id="' . $d . '" class="btn btn-sm btn-danger btn-delete btn-delete-user" title="hapus">
                        <i class="fa fa-trash"></i>
                        </button>
                        </div>';
                }
            ],
        ];

        return $this->response->setJSON(SSP::simple($_GET, $this->sql_details, 'users', 'id', $columns));
    }

    public function dataUser()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $id = $request->getVar('id');
            $userModel = new User();

            $data = $userModel->find($id);
            return $this->response->setJSON(['data' => $data]);
        }
    }

    public function dataUserUpdate()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $id = $this->request->getPost('id');

            // Ambil user yang sedang diupdate
            $userModel = new User();
            $user = $userModel->find($id);

            if (!$user) {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Data pengguna tidak ditemukan.'
                ]);
            }

            $rules = [
                'name' => 'required',
                'username' => "required|is_unique[users.username,id,{$id}]",
                'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
                'role' => 'required|in_list[admin,guru,kepala,ortu]'
            ];

            // Jika password diisi, tambahkan validasi
            if ($this->request->getPost('password')) {
                $rules['password'] = 'required';
            }

            $messages = [
                'name' => [
                    'required' => 'Nama wajib diisi.'
                ],
                'username' => [
                    'required' => 'Username wajib diisi.',
                    'is_unique' => 'Username sudah digunakan.'
                ],
                'email' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah digunakan.'
                ],
                'password' => [
                    'required' => 'Password wajib diisi.'
                ],
                'role' => [
                    'required' => 'Role wajib dipilih.',
                    'in_list' => 'Role tidak valid.'
                ]
            ];

            $validation->setRules($rules, $messages);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'error' => $validation->getErrors()
                ]);
            }

            $updateData = [
                'name' => $this->request->getPost('name'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'role' => $this->request->getPost('role'),
            ];

            if ($this->request->getPost('password')) {
                $updateData['password'] = Hash::make($this->request->getPost('password'));
            }

            $userModel->update($id, $updateData);

            return $this->response->setJSON([
                'status' => 1,
                'msg' => 'Data pengguna berhasil diperbarui.',

            ]);
        }

        return redirect()->back();
    }
    public function dataUserDrop()
    {
        $id = $this->request->getGet('id');

        if ($id == 1) {
            // User dengan id 1 tidak bisa dihapus
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User tidak bisa di hapus'
            ]);
        }

        // Contoh hapus user dari database
        $userModel = new User();

        if ($userModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'User berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menghapus user'
            ]);
        }
    }
}