<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BukuModel;

class Buku extends BaseController
{
    protected BukuModel $bukuModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

    // READ - Tampilkan semua data buku (bisa dicari & difilter berdasarkan kategori)
    public function index()
    {
        $keyword  = $this->request->getGet('q');
        $kategori = $this->request->getGet('kategori');

        $query = $this->bukuModel;

        if ($keyword) {
            $query = $query->groupStart()
                ->like('judul', $keyword)
                ->orLike('kode_buku', $keyword)
                ->orLike('pengarang', $keyword)
                ->groupEnd();
        }

        if ($kategori) {
            $query = $query->where('kategori', $kategori);
        }

        $data['buku']          = $query->orderBy('id', 'DESC')->findAll();
        $data['kategoriList']  = $this->bukuModel->getKategoriList();
        $data['kategoriAktif'] = $kategori;
        $data['title']         = 'Data Buku';

        return view('admin/buku/index', $data);
    }

    // CREATE - Form tambah buku
    public function create()
    {
        $data['title']        = 'Tambah Buku';
        $data['kategoriList'] = $this->bukuModel->getKategoriList();

        return view('admin/buku/create', $data);
    }

    // CREATE - Simpan data buku baru
    public function save()
    {
        if (! $this->validate($this->bukuModel->validationRules, $this->bukuModel->validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->bukuModel->save([
            'kode_buku'    => $this->request->getPost('kode_buku'),
            'judul'        => $this->request->getPost('judul'),
            'kategori'     => $this->request->getPost('kategori'),
            'pengarang'    => $this->request->getPost('pengarang'),
            'penerbit'     => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'stok'         => $this->request->getPost('stok'),
        ]);

        return redirect()->to('admin/buku')->with('success', 'Data buku berhasil ditambahkan.');
    }

    // UPDATE - Form edit buku
    public function edit($id)
    {
        $buku = $this->bukuModel->find($id);

        if (! $buku) {
            return redirect()->to('admin/buku')->with('error', 'Data buku tidak ditemukan.');
        }

        $data['title']        = 'Edit Buku';
        $data['buku']         = $buku;
        $data['kategoriList'] = $this->bukuModel->getKategoriList();

        return view('admin/buku/edit', $data);
    }

    // UPDATE - Simpan perubahan data buku
    public function update($id)
    {
        $buku = $this->bukuModel->find($id);

        if (! $buku) {
            return redirect()->to('admin/buku')->with('error', 'Data buku tidak ditemukan.');
        }

        $rules = $this->bukuModel->validationRules;
        $rules['kode_buku'] = str_replace('{id}', $id, $rules['kode_buku']);

        if (! $this->validate($rules, $this->bukuModel->validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->bukuModel->update($id, [
            'kode_buku'    => $this->request->getPost('kode_buku'),
            'judul'        => $this->request->getPost('judul'),
            'kategori'     => $this->request->getPost('kategori'),
            'pengarang'    => $this->request->getPost('pengarang'),
            'penerbit'     => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'stok'         => $this->request->getPost('stok'),
        ]);

        return redirect()->to('admin/buku')->with('success', 'Data buku berhasil diperbarui.');
    }

    // DELETE - Hapus data buku
    public function delete($id)
    {
        $buku = $this->bukuModel->find($id);

        if (! $buku) {
            return redirect()->to('admin/buku')->with('error', 'Data buku tidak ditemukan.');
        }

        $this->bukuModel->delete($id);

        return redirect()->to('admin/buku')->with('success', 'Data buku berhasil dihapus.');
    }
}
