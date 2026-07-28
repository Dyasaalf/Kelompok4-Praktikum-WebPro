<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BukuModel;
use App\Models\AnggotaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $bukuModel    = new BukuModel();
        $anggotaModel = new AnggotaModel();

        $data['title']            = 'Dashboard Admin';
        $data['total_buku']       = $bukuModel->countAll();
        $data['total_anggota']    = $anggotaModel->countAll();
        $data['total_dipinjam']   = $bukuModel->where('status', 'dipinjam')->countAllResults();
        $data['buku_terbaru']     = $bukuModel->orderBy('id', 'DESC')->findAll(5);

        return view('admin/dashboard', $data);
    }
}
