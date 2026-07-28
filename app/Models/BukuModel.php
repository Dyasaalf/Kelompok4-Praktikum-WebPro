<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table            = 'buku';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'kode_buku',
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'stok',
        'status',
        'anggota_id',
        'tanggal_pinjam',
    ];

    // Timestamps otomatis diisi oleh model saat insert/update
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validasi
    protected $validationRules = [
        'kode_buku' => 'required|min_length[3]|max_length[20]|is_unique[buku.kode_buku,id,{id}]',
        'judul'     => 'required|min_length[3]|max_length[150]',
        'pengarang' => 'required|max_length[100]',
        'penerbit'  => 'permit_empty|max_length[100]',
        'tahun_terbit' => 'permit_empty|numeric',
        'stok'      => 'required|numeric',
    ];

    protected $validationMessages = [
        'kode_buku' => [
            'required'   => 'Kode buku wajib diisi.',
            'is_unique'  => 'Kode buku sudah digunakan, gunakan kode lain.',
        ],
        'judul' => [
            'required' => 'Judul buku wajib diisi.',
        ],
        'pengarang' => [
            'required' => 'Nama pengarang wajib diisi.',
        ],
        'stok' => [
            'required' => 'Stok wajib diisi.',
            'numeric'  => 'Stok harus berupa angka.',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Tandai buku sebagai dipinjam oleh anggota tertentu.
     * Mengurangi stok dan mengubah status jadi "dipinjam".
     */
    public function pinjamBuku(int $idBuku, int $idAnggota): bool
    {
        $buku = $this->find($idBuku);

        if (! $buku || $buku['status'] === 'dipinjam' || $buku['stok'] < 1) {
            return false;
        }

        return (bool) $this->update($idBuku, [
            'status'         => 'dipinjam',
            'anggota_id'     => $idAnggota,
            'tanggal_pinjam' => date('Y-m-d H:i:s'),
            'stok'           => $buku['stok'] - 1,
        ]);
    }

    /**
     * Kembalikan buku: kembalikan stok dan reset status jadi "tersedia".
     */
    public function kembalikanBuku(int $idBuku, int $idAnggota): bool
    {
        $buku = $this->find($idBuku);

        if (! $buku || $buku['status'] !== 'dipinjam' || (int) $buku['anggota_id'] !== $idAnggota) {
            return false;
        }

        return (bool) $this->update($idBuku, [
            'status'         => 'tersedia',
            'anggota_id'     => null,
            'tanggal_pinjam' => null,
            'stok'           => $buku['stok'] + 1,
        ]);
    }

    /**
     * Daftar buku yang sedang dipinjam oleh anggota tertentu.
     */
    public function pinjamanAnggota(int $idAnggota): array
    {
        return $this->where('anggota_id', $idAnggota)
            ->where('status', 'dipinjam')
            ->findAll();
    }
}
