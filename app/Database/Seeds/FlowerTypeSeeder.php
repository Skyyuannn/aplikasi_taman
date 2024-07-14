<?php

namespace App\Database\Seeds;

use App\Models\FlowerTypeModel;
use CodeIgniter\Database\Seeder;

class FlowerTypeSeeder extends Seeder
{
    public function run()
    {
        $flowerTypeObject = new FlowerTypeModel();

        $flowerTypeObject->insertBatch([
            [
                "id" => 1,
                "type" => "No Category",
                "created_date" => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
