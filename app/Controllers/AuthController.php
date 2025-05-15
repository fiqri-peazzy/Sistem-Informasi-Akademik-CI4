<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User;
use App\Libraries\CiAuth;
use App\Libraries\Hash;

class AuthController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions'];
    public function loginForm()
    {
        $data = [
            'pageTitle' => 'login',
            'validation' => null
        ];
        return view('backend/pages/auth/login', $data);
    }

    public function loginHandler()
    {
        $fieldType = filter_var($this->request->getVar('login_id'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if ($fieldType == 'email') {
            $isValid = $this->validate([
                'login_id' => [
                    'rules' => 'required|valid_email|is_not_unique[users.email]',
                    'errors' => [
                        'required' => 'Harap Masukan Email untuk login',
                        'valid_email' => 'Masukan Email yang valid',
                        'is_not_unique' => 'Email tidak terdaftar di sistem'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[5]|max_length[45]',
                    'errors' => [
                        'required' => 'Password wajib diisi',
                        'min_length' => 'Password minimal 5 karakter',
                        'max_length' => 'Password maximal 45 karakter',
                    ]
                ]

            ]);
        } else {
            $isValid = $this->validate([
                'login_id' => [
                    'rules' => 'required|is_not_unique[users.username]',
                    'errors' => [
                        'required' => 'Harap masukan username untuk login',
                        'is_not_unique' => 'username tidak terdaftar'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[5]|max_length[45]',
                    'errors' => [
                        'required' => 'Harap Masukan Password',
                        'min_length' => 'Password minimal 5 karakter',
                        'max_length' => 'Password maximal 45 karakter',
                    ]
                ]

            ]);
        }

        if (!$isValid) {
            return view('backend/pages/auth/login', [
                'pageTitle' => 'Login',
                'validation' => $this->validator
            ]);
        } else {

            $user = new User();
            $userInfo = $user->where($fieldType, $this->request->getVar('login_id'))->first();
            $cek_password = Hash::check($this->request->getVar('password'), $userInfo['password']);

            if (!$cek_password) {
                return redirect()->route('admin.login.form')->with('fail', 'Password Salah')->withInput();
            } else {
                CiAuth::setCiAuth($userInfo);
                return redirect()->route('admin.home');
            }
        }
    }
}