<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userObject = new UserModel();

        $userObject->insertBatch([
            [
                "id" => 1,
                "name" => "Administrator",
                "username" => "admin",
                "password" => password_hash("admin", PASSWORD_DEFAULT),
                "created_date" => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
