<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\BukuModel;

class Dashboard extends BaseController
{
    protected BukuModel $bukuModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

    // Tampilkan semua buku yang terdaftar (bisa dicari)
    public function index()
    {
        $keyword = $this->request->getGet('q');

        if ($keyword) {
            $data['buku'] = $this->bukuModel->like('judul', $keyword)
                ->orLike('kode_buku', $keyword)
                ->orLike('pengarang', $keyword)
                ->orderBy('judul', 'ASC')
                ->findAll();
        } else {
            $data['buku'] = $this->bukuModel->orderBy('judul', 'ASC')->findAll();
        }

        $data['title'] = 'Daftar Buku';

        return view('customer/dashboard', $data);
    }

    // Proses pinjam buku - langsung ubah status buku jadi "dipinjam"
    public function pinjam($idBuku)
    {
        $anggotaId = session()->get('anggota_id');

        $berhasil = $this->bukuModel->pinjamBuku((int) $idBuku, (int) $anggotaId);

        if (! $berhasil) {
            return redirect()->to('customer/buku')->with('error', 'Buku tidak dapat dipinjam (mungkin sudah dipinjam orang lain atau stok habis).');
        }

        return redirect()->to('customer/buku')->with('success', 'Buku berhasil dipinjam. Silakan cek menu "Pinjaman Saya".');
    }
}
