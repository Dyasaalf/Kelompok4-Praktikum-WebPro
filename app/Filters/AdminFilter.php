<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    /**
     * Jalan sebelum controller diakses.
     * Cek apakah admin sudah login (session 'admin_id').
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('admin_id')) {
            return redirect()->to('/login/admin')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi khusus setelah controller dijalankan.
    }
}
