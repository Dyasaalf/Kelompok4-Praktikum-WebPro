<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class AdminAuth extends BaseController
{
    protected AdminModel $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    // Tampilkan form login admin
    public function login()
    {
        // Kalau sudah login, langsung ke dashboard
        if (session()->get('admin_id')) {
            return redirect()->to('/admin/dashboard');
        }

        $data['title'] = 'Login Admin';

        return view('auth/admin_login', $data);
    }

    // Proses login admin
    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $this->adminModel->findByUsername($username);

        if (! $admin || ! password_verify($password, $admin['password'])) {
            return redirect()->to('/login/admin')->withInput()->with('error', 'Username atau password salah.');
        }

        session()->set([
            'admin_id'       => $admin['id'],
            'admin_username' => $admin['username'],
            'admin_nama'     => $admin['nama'],
            'isAdminLoggedIn' => true,
        ]);

        return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, ' . $admin['nama'] . '!');
    }

    // Logout admin
    public function logout()
    {
        session()->remove(['admin_id', 'admin_username', 'admin_nama', 'isAdminLoggedIn']);

        return redirect()->to('/login/admin')->with('success', 'Anda berhasil logout.');
    }
}
