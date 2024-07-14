<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $user;
    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function index()
    {
        $post['user'] = $this->user->find(session('id'));
        return view('profile/index', $post);
    }

    public function update($id)
    {
        if ($this->request->isAJAX()) {
            $post = $this->request->getPost();

            $response = [
                'status' => 'failed',
                'msg' => 'Gagal memperbarui profile!'
            ];

            try {
                // $data = [];
                // foreach ($post as $key => $val) {
                //     $post[$key] = $val;
                // }
                if ($post['password'] != '') {
                    $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);

                    $profile = $this->user->update($id, $data);

                    $response['status'] = 'success';
                    $response['msg'] = 'Berhasil memperbarui password';
                } else {
                    $data['name'] = $post['name'];

                    $profile = $this->user->update($id, $data);

                    $response['status'] = 'success';
                    $response['msg'] = 'Profil berhasil diperbarui';
                }

                if ($profile) {
                    $response['status'] = $response['status'];
                    $response['msg'] = $response['msg'];
                } else {
                    $response['error'] = $this->user->error();
                }
            } catch (\Exception $e) {
                $response['error'] = $e->getMessage();
            }
            return json_encode($response);
        }
    }
}
