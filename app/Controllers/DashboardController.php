<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FlowerModel;
use App\Models\FlowerTypeModel;

helper('download');

class DashboardController extends BaseController
{
    public function index()
    {
        $data['totalFlowers'] = (new FlowerModel())->sumFlowerQty();
        $data['flowers'] = (new FlowerModel())->findAll();
        $data['flowersType'] = (new FlowerTypeModel())->findAll();
        return view("dashboard/index", $data);
    }
}
