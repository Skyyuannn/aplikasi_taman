<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FlowerModel;
use App\Models\FlowerTypeModel;

class FlowerTypeController extends BaseController
{
    protected $flowerType;
    public function __construct()
    {
        $this->flowerType = new FlowerTypeModel();
    }

    public function index()
    {
        return view('master_data/tipe_tanaman/index');
    }

    public function fetchFlowersType()
    {
        $data = $this->flowerType->findAll();
        $result = array();
        $index = 0;
        foreach ($data as $val) {
            if ($val['id'] != 1) {
                $index++;
                $row = array();
                $row['no'] = $index;
                $row['name'] = $val['type'];
                $actionButton = '';
                $actionButton = '<button data-toggle="tooltip"  data-original-title="Edit" class="btn btn-primary btn-sm" onclick="edit(' . $val['id'] . ')" >Edit</button>  ';
                $actionButton = $actionButton .= '<button type="button" data-toggle="tooltip" onclick="deleteData(' . $val['id'] . ')"  data-original-title="Delete" class="btn btn-danger btn-sm deleteButton">Delete</button>';
                $row['action'] = $actionButton;
                $result[] = (object)$row;
            }
        }

        return json_encode([
            'status' => 'success',
            'msg' => 'Jenis Tanaman berhasil ditemukan!',
            'data' => $result
        ]);
    }

    public function create()
    {
        $post = $this->request->getPost();

        $response = [
            'status' => 'failed',
            'msg' => 'Gagal menambahkan Jenis Tanaman!'
        ];

        try {
            $data = [];
            foreach ($post as $key => $val) {
                $data[$key] = $val;
            }
            $data['created_date'] = date('Y-m-d H:i:s');

            $flowersType = $this->flowerType->insert($data);

            if ($flowersType) {
                $response['status'] = 'success';
                $response['msg'] = 'Jenis Tanaman berhasil ditambahkan';
            } else {
                $response['error'] = $this->flowerType->error();
            }
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
        }

        return json_encode($response);
    }

    public function update($id)
    {
        $post = $this->request->getPost();

        $response = [
            'status' => 'failed',
            'msg' => 'Gagal memperbarui Jenis Tanaman!'
        ];

        try {
            $data = [];
            foreach ($post as $key => $val) {
                $data[$key] = $val;
            }
            $data['type'] = $data['name'];

            $flowersType = $this->flowerType->update($id, $data);

            if ($flowersType) {
                $response['status'] = 'success';
                $response['msg'] = 'Jenis Tanaman berhasil diperbarui';
            } else {
                $response['error'] = $this->flowerType->error();
            }
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
        }

        return json_encode($response);
    }

    public function edit($id)
    {
        $data = $this->flowerType->find($id);
        return json_encode([
            'status' => 'success',
            'msg' => 'Data Tanaman berhasil ditemukan!',
            'data' => $data
        ]);
    }

    public function delete($id)
    {
        $flowerModel = new FlowerModel();
        $flowersType = $this->flowerType
            ->where('id', $id);

        $flowers = $flowerModel->where('type', $id)->findAll();
        foreach ($flowers as $flower) {
            $data['type'] = 1;
            $flowerModel->update($flower['id'], $data);
        }

        $response = [
            'status' => 'failed',
            'msg' => 'Gagal menghapus data tanaman!'
        ];

        if ($flowersType->delete()) {
            $response['status'] = 'success';
            $response['msg'] = 'Berhasil menghapus data tanaman!';
        }

        return json_encode($response);
    }
}
