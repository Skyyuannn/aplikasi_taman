<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class LoginController extends BaseController
{
    protected $userModel;
    protected $session;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
    }

    public function loginPage()
    {
        if (session('id')) {
            return redirect()->to('main/dashboard');
        }
        return view('auth/login');
    }

    public function registerPage()
    {
        return view('auth/register');
    }

    public function doLogin()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $this->userModel->where('username', $username)->first();
        if ($user) {
            $userPassword = $user['password'];
            $passwordVerify = password_verify($password, $userPassword);
            if ($passwordVerify) {
                $userSession = $this->setUserSession($user);
                return redirect()->to('main/dashboard');
            } else {
                $this->session->setFlashdata('error', 'Password is incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $this->session->setFlashdata('error', 'Username does not exist.');
            return redirect()->to('/login');
        }
    }

    public function doRegister()
    {
        if ($this->request->isAJAX()) {
            $post = $this->request->getVar();

            $validation = $this->validate([
                'name' => ['rules' => 'required', 'errors' => ['required' => 'Kolom nama harus diisi']],
                'username' => ['rules' => 'required|is_unique[t_users.username]', 'errors' => ['required' => 'Kolom username harus diisi', 'is_unique' => 'Username sudah terdaftar']],
                'confirmPassword' => ['label' => 'Password', 'rules' => 'required|min_length[6]|max_length[25]|matches[password]']
            ]);

            if (!$validation) {
                $response['status'] = 'error';
                $response['msg'] = [
                    'name' => $this->validator->getError('name'),
                    'username' => $this->validator->getError('username'),
                    'password' => $this->validator->getError('confirmPassword')
                ];
            } else {
                try {
                    $data = [];
                    foreach ($post as $key => $val) {
                        $data[$key] = $val;
                    }
                    $data['password'] = password_hash((string) $data['password'], PASSWORD_DEFAULT);
                    $data['created_date'] = date('Y-m-d H:i:s');

                    $user = $this->userModel->insert($data);

                    if ($user) {
                        $response['status'] = 'success';
                        $response['msg'] = 'Berhasil membuat akun';
                    } else {
                        $response['error'] = $this->userModel->error();
                    }
                } catch (\Exception $e) {
                    $response['error'] = $e->getMessage();
                }
            }
            return json_encode($response);
        }
    }

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'name' => $user['name'],
            'username' => $user['username'],
            'isLoggedIn' => true,
        ];
        session()->set($data);
        return $data;
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}
