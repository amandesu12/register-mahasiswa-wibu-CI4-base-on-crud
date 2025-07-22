<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use CodeIgniter\RESTful\ResourceController;

class Mahasiswa extends ResourceController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MahasiswaModel();
    }

    /**
     * READ: Menampilkan semua data mahasiswa
     */
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $mahasiswa = $this->model->search($keyword);
        } else {
            $mahasiswa = $this->model;
        }

        $data = [
            'mahasiswa' => $mahasiswa->paginate(5, 'mahasiswa'),
            'pager'     => $this->model->pager,
            'keyword'   => $keyword,
        ];
        return view('mahasiswa/index', $data);
    }

    /**
     * Menampilkan form untuk membuat data baru
     */
    public function new()
    {
        return view('mahasiswa/form');
    }

    /**
     * CREATE: Menyimpan data baru
     */
    public function create()
    {
        // Aturan validasi
        $rules = [
            'nim'   => 'required|is_unique[mahasiswa.nim]',
            'nama'  => 'required',
            'email' => 'required|valid_email|is_unique[mahasiswa.email]',
            'jurusan' => 'required',
            'berkas' => 'uploaded[berkas]|max_size[berkas,5120]|ext_in[berkas,pdf,docx,jpg,png,jpeg]'
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembali ke form dengan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil file berkas
        $fileBerkas = $this->request->getFile('berkas');
        // Generate nama random
        $namaBerkas = $fileBerkas->getRandomName();
        // Pindahkan file ke folder public/uploads
        $fileBerkas->move('uploads', $namaBerkas);

        $this->model->save([
            'nim' => $this->request->getVar('nim'),
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'jurusan' => $this->request->getVar('jurusan'),
            'berkas' => $namaBerkas,
        ]);

        session()->setFlashdata('pesan', 'Data pendaftar berhasil ditambahkan.');
        return redirect()->to('/mahasiswa');
    }

    /**
     * Menampilkan form untuk mengedit data
     */
    public function edit($id = null)
    {
        $data = [
            'mahasiswa' => $this->model->find($id)
        ];

        if (empty($data['mahasiswa'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data mahasiswa tidak ditemukan.');
        }

        return view('mahasiswa/form', $data);
    }

    /**
     * UPDATE: Memperbarui data yang ada
     */
    public function update($id = null)
    {
        // Aturan validasi
         $rules = [
            'nim'   => 'required|is_unique[mahasiswa.nim,id,' . $id . ']',
            'nama'  => 'required',
            'email' => 'required|valid_email|is_unique[mahasiswa.email,id,' . $id . ']',
            'jurusan' => 'required',
            'berkas' => 'max_size[berkas,5120]|ext_in[berkas,pdf,docx,jpg,png,jpeg]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileBerkas = $this->request->getFile('berkas');
        $namaBerkasLama = $this->request->getVar('berkasLama'); // Hidden input nanti di form

        // Cek apakah ada file baru yang diupload
        if ($fileBerkas->getError() == 4) {
            $namaBerkas = $namaBerkasLama;
        } else {
            // Generate nama baru
            $namaBerkas = $fileBerkas->getRandomName();
            // Pindahkan file
            $fileBerkas->move('uploads', $namaBerkas);
            // Hapus file lama jika ada
            if ($namaBerkasLama && file_exists('uploads/' . $namaBerkasLama)) {
                unlink('uploads/' . $namaBerkasLama);
            }
        }

        $this->model->save([
            'id' => $id,
            'nim' => $this->request->getVar('nim'),
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'jurusan' => $this->request->getVar('jurusan'),
            'berkas' => $namaBerkas,
        ]);

        session()->setFlashdata('pesan', 'Data pendaftar berhasil diubah.');
        return redirect()->to('/mahasiswa');
    }

    /**
     * DELETE: Menghapus data
     */
    public function delete($id = null)
    {
        // Cari data berdasarkan ID untuk mendapatkan nama file
        $data = $this->model->find($id);
        if ($data && file_exists('uploads/' . $data['berkas'])) {
             // Hapus file fisik
            unlink('uploads/' . $data['berkas']);
        }

        $this->model->delete($id);
        session()->setFlashdata('pesan', 'Data pendaftar berhasil dihapus.');
        return redirect()->to('/mahasiswa');
    }
}