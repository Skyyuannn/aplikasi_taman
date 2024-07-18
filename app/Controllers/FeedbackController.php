<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class FeedbackController extends Controller
{
    public function index()
    {
        // Tampilkan halaman feedback.php
        return view('Feedback/index');
    }

    public function submit()
    {
        // Tangkap data dari form
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $message = $this->request->getPost('message');


        // Simpan atau lakukan sesuai kebutuhan Anda, contoh sederhana bisa menyimpan ke database atau mengirim email admin
        // Misalnya, menyimpan ke database
        $feedbackModel = new \App\Models\FeedbackModel();
        $data = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $feedbackModel->insert($data);

        // Kirim respons JSON ke client
        return $this->response->setJSON(['status' => 'success']);
    }
}
