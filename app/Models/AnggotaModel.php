<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table            = 'anggota';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'nis_nim',
        'password',
        'nama',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'email',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nis_nim'       => 'required|min_length[3]|max_length[20]|is_unique[anggota.nis_nim,id,{id}]',
        'password'      => 'permit_empty|min_length[6]',
        'nama'          => 'required|min_length[3]|max_length[100]',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'alamat'        => 'permit_empty',
        'no_hp'         => 'permit_empty|max_length[20]',
        'email'         => 'permit_empty|valid_email',
    ];

    protected $validationMessages = [
        'nis_nim' => [
            'required'  => 'NIS/NIM wajib diisi.',
            'is_unique' => 'NIS/NIM sudah terdaftar.',
        ],
        'nama' => [
            'required' => 'Nama wajib diisi.',
        ],
        'password' => [
            'min_length' => 'Password minimal 6 karakter.',
        ],
        'jenis_kelamin' => [
            'required' => 'Jenis kelamin wajib dipilih.',
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid.',
        ],
    ];

    protected $skipValidation = false;

    // Hash password otomatis sebelum insert/update jika ada input password baru
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Cari anggota berdasarkan NIS/NIM, dipakai saat proses login.
     */
    public function findByNisNim(string $nisNim): ?array
    {
        return $this->where('nis_nim', $nisNim)->first();
    }

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && $data['data']['password'] !== '') {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            // Jangan timpa password lama kalau field dikosongkan saat update
            unset($data['data']['password']);
        }

        return $data;
    }
}
