<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nim', 'nama', 'email', 'jurusan', 'berkas'];
    protected $useTimestamps    = true;

    public function search($keyword)
    {
        return $this->table('mahasiswa')->like('nama', $keyword)->orLike('nim', $keyword)->orLike('jurusan', $keyword);
    }
}