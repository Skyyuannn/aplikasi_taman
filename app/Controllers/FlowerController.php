<?php

namespace App\Controllers;

use App\Action\Flowers\FetchIndexDataAction;
use App\Action\Flowers\UpdateFlowersDataAction;
use App\Controllers\BaseController;
use App\Models\FlowerModel;
use App\Models\FlowerTypeModel;

class FlowerController extends BaseController
{
    protected $flowerModel;
    public function __construct()
    {
        $this->flowerModel = new FlowerModel();
    }

    public function index()
    {
        $data['flowerType'] = (new FlowerTypeModel())->findAll();
        return view('flowers/data_tanaman/index', $data);
    }

    public function indexFilter()
    {
        $data['flowerType'] = (new FlowerTypeModel())->findAll();
        return view('flowers/data_tanaman/filtering_tanaman', $data);
    }

    public function loadData()
    {
        $postData = $this->request->getPost();
        $postData['filter_year'] = $this->request->getPost('filter_year'); 
        $postData['category'] = $this->request->getPost('category'); // Tambahkan baris ini

        return (new FetchIndexDataAction())->execute($postData);
    }

    public function fetchFlowersData()
    {
        $data = $this->flowerModel->findAll();
        $result = array();
        $index = 0;
        foreach ($data as $val) {
            $flowerType = (new FlowerTypeModel())->find($val['type']);
            $index++;
            $row = array();
            $row['no'] = $index;
            $row['name'] = $val['name'];
            $row['type'] = $flowerType['type'];
            $row['qty'] = $val['qty'];
            $row['image'] = '<img src="' . base_url() . '/uploads\/' . ($val['image'] != '' ? $val['image'] : 'no-image.jpg') . '" alt="..." class="img-thumbnail" width="100px"style="  width: 80px;height: 80px;object-fit: cover;">';
            $actionButton = '<button data-toggle="tooltip"  data-original-title="Edit" class="btn btn-primary btn-sm" onclick="edit(' . $val['id'] . ')" >Edit</button> ';
            $actionButton = $actionButton .= '<button type="button" data-toggle="tooltip" onclick="deleteData(' . $val['id'] . ')"  data-original-title="Delete" class="btn btn-danger btn-sm deleteButton">Delete</button>';
            $row['created_date'] = $val['created_date'];
            $row['action'] = $actionButton;
            $result[] = (object)$row;
        }

        return json_encode([
            'status' => 'success',
            'msg' => 'Data Tanaman berhasil ditemukan!',
            'data' => $result
        ]);
    }

    public function update($id)
    {
        $post = $this->request->getPost();

        $response = [
            'status' => 'failed',
            'msg' => 'Gagal memperbarui data Tanaman!'
        ];

        $validateImage = $this->validate([
            'image' => [
                'uploaded[image]',
                'mime_in[image,image/jpg,image/jpeg,image/gif,image/png]',
            ],
        ]);

        try {
            $data = [];
            foreach ($post as $key => $val) {
                $data[$key] = $val;
            }
            if ($validateImage) {
                $image = $this->request->getFile('image');
                $fileName = $image->getRandomName();
                $image->move('uploads/', $fileName);

                $data['image'] = $fileName;
                // $data['created_date'] = date('Y-m-d H:i:s');

                $flowers = $this->flowerModel->update($id, $data);
            } else {
                // $data['created_date'] = date('Y-m-d H:i:s');
                $flowers = $this->flowerModel->update($id, $data);
            }

            if ($flowers) {
                $response['status'] = 'success';
                $response['msg'] = 'Data tanaman berhasil diperbarui';
            } else {
                $response['error'] = $this->flowerModel->error();
            }
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
        }

        return json_encode($response);
    }

    public function create()
    {
        $post = $this->request->getPost();

        $response = [
            'status' => 'failed',
            'msg' => 'Gagal menambahkan data Tanaman!'
        ];

        $validateImage = $this->validate([
            'image' => [
                'uploaded[image]',
                'mime_in[image,image/jpg,image/jpeg,image/gif,image/png]',
            ],
        ]);

        try {
            $data = [];
            foreach ($post as $key => $val) {
                $data[$key] = $val;
            }
            if ($validateImage) {
                $image = $this->request->getFile('image');
                $fileName = $image->getRandomName();
                $image->move('uploads/', $fileName);

                $data['image'] = $fileName;
                $data['created_date'] = date('Y-m-d H:i:s');

                $flowers = $this->flowerModel->insert($data);
            } else {
                $data['created_date'] = date('Y-m-d H:i:s');
                $flowers = $this->flowerModel->insert($data);
            }

            if ($flowers) {
                $response['status'] = 'success';
                $response['msg'] = 'Data tanaman berhasil ditambahkan';
            } else {
                $response['error'] = $this->flowerModel->error();
            }
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
        }

        return json_encode($response);
    }

    public function edit($id)
    {
        $data = $this->flowerModel->find($id);
        return json_encode([
            'status' => 'success',
            'msg' => 'Data Tanaman berhasil ditemukan!',
            'data' => $data
        ]);
    }

    public function delete($id)
    {
        $flowers = $this->flowerModel
            ->where('id', $id);

        $response = [
            'status' => 'failed',
            'msg' => 'Gagal menghapus data tanaman!'
        ];

        if ($flowers->delete()) {
            $response['status'] = 'success';
            $response['msg'] = 'Berhasil menghapus data tanaman!';
        }

        return json_encode($response);
    }
}
