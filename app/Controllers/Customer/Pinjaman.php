<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\BukuModel;

class Pinjaman extends BaseController
{
    protected BukuModel $bukuModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

    // Tampilkan daftar buku yang sedang dipinjam oleh anggota yang login
    public function index()
    {
        $anggotaId = session()->get('anggota_id');

        $data['title']    = 'Pinjaman Saya';
        $data['pinjaman']  = $this->bukuModel->pinjamanAnggota((int) $anggotaId);

        return view('customer/pinjaman', $data);
    }

    // Proses pengembalian buku
    public function kembalikan($idBuku)
    {
        $anggotaId = session()->get('anggota_id');

        $berhasil = $this->bukuModel->kembalikanBuku((int) $idBuku, (int) $anggotaId);

        if (! $berhasil) {
            return redirect()->to('customer/pinjaman-saya')->with('error', 'Buku tidak dapat dikembalikan (data tidak sesuai).');
        }

        return redirect()->to('customer/pinjaman-saya')->with('success', 'Buku berhasil dikembalikan. Terima kasih!');
    }
}
