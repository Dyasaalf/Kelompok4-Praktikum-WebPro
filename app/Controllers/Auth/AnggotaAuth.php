<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;

class AnggotaAuth extends BaseController
{
    protected AnggotaModel $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
    }

    // Tampilkan form login anggota
    public function login()
    {
        if (session()->get('anggota_id')) {
            return redirect()->to('/customer/buku');
        }

        $data['title'] = 'Login Anggota';

        return view('auth/anggota_login', $data);
    }

    // Proses login anggota
    public function attemptLogin()
    {
        $nisNim   = $this->request->getPost('nis_nim');
        $password = $this->request->getPost('password');

        $anggota = $this->anggotaModel->findByNisNim($nisNim);

        if (! $anggota || empty($anggota['password']) || ! password_verify($password, $anggota['password'])) {
            return redirect()->to('/login/anggota')->withInput()->with('error', 'NIS/NIM atau password salah.');
        }

        session()->set([
            'anggota_id'     => $anggota['id'],
            'anggota_nis'    => $anggota['nis_nim'],
            'anggota_nama'   => $anggota['nama'],
            'isAnggotaLoggedIn' => true,
        ]);

        return redirect()->to('/customer/buku')->with('success', 'Selamat datang, ' . $anggota['nama'] . '!');
    }

    // Logout anggota
    public function logout()
    {
        session()->remove(['anggota_id', 'anggota_nis', 'anggota_nama', 'isAnggotaLoggedIn']);

        return redirect()->to('/login/anggota')->with('success', 'Anda berhasil logout.');
    }
}
