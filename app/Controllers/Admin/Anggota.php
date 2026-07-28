<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    protected AnggotaModel $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
    }

    // READ - Tampilkan semua data anggota
    public function index()
    {
        $keyword = $this->request->getGet('q');

        if ($keyword) {
            $data['anggota'] = $this->anggotaModel->like('nama', $keyword)
                ->orLike('nis_nim', $keyword)
                ->findAll();
        } else {
            $data['anggota'] = $this->anggotaModel->orderBy('id', 'DESC')->findAll();
        }

        $data['title'] = 'Data Anggota';

        return view('admin/anggota/index', $data);
    }

    // CREATE - Form tambah anggota
    public function create()
    {
        $data['title'] = 'Tambah Anggota';

        return view('admin/anggota/create', $data);
    }

    // CREATE - Simpan data anggota baru (termasuk akun login: NIS/NIM + password)
    public function save()
    {
        $rules = $this->anggotaModel->validationRules;
        $rules['password'] = 'required|min_length[6]';

        if (! $this->validate($rules, $this->anggotaModel->validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->anggotaModel->save([
            'nis_nim'       => $this->request->getPost('nis_nim'),
            'password'      => $this->request->getPost('password'),
            'nama'          => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
        ]);

        return redirect()->to('admin/anggota')->with('success', 'Data anggota berhasil ditambahkan.');
    }

    // UPDATE - Form edit anggota
    public function edit($id)
    {
        $anggota = $this->anggotaModel->find($id);

        if (! $anggota) {
            return redirect()->to('admin/anggota')->with('error', 'Data anggota tidak ditemukan.');
        }

        $data['title']   = 'Edit Anggota';
        $data['anggota'] = $anggota;

        return view('admin/anggota/edit', $data);
    }

    // UPDATE - Simpan perubahan data anggota (password dikosongkan = tidak berubah)
    public function update($id)
    {
        $anggota = $this->anggotaModel->find($id);

        if (! $anggota) {
            return redirect()->to('admin/anggota')->with('error', 'Data anggota tidak ditemukan.');
        }

        $rules = $this->anggotaModel->validationRules;
        $rules['nis_nim'] = str_replace('{id}', $id, $rules['nis_nim']);

        if (! $this->validate($rules, $this->anggotaModel->validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'nis_nim'       => $this->request->getPost('nis_nim'),
            'nama'          => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
        ];

        // Password hanya diupdate kalau field diisi
        $password = $this->request->getPost('password');
        if (! empty($password)) {
            $updateData['password'] = $password;
        }

        $this->anggotaModel->update($id, $updateData);

        return redirect()->to('admin/anggota')->with('success', 'Data anggota berhasil diperbarui.');
    }

    // DELETE - Hapus data anggota
    public function delete($id)
    {
        $anggota = $this->anggotaModel->find($id);

        if (! $anggota) {
            return redirect()->to('admin/anggota')->with('error', 'Data anggota tidak ditemukan.');
        }

        $this->anggotaModel->delete($id);

        return redirect()->to('admin/anggota')->with('success', 'Data anggota berhasil dihapus.');
    }
}
