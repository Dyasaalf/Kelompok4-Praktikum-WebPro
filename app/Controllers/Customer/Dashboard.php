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

    // Tampilkan semua buku yang terdaftar (bisa dicari & difilter kategori)
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

        $data['buku']          = $query->orderBy('judul', 'ASC')->findAll();
        $data['kategoriList']  = $this->bukuModel->getKategoriList();
        $data['kategoriAktif'] = $kategori;
        $data['title']         = 'Daftar Buku';

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
