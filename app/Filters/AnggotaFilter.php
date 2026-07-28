<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AnggotaFilter implements FilterInterface
{
    /**
     * Jalan sebelum controller diakses.
     * Cek apakah anggota sudah login (session 'anggota_id').
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('anggota_id')) {
            return redirect()->to('/login/anggota')->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi khusus setelah controller dijalankan.
    }
}
