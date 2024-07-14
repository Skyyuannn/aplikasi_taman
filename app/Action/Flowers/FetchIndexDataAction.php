<?php

namespace App\Action\Flowers;

use App\Action\Flowers\FetchFlowersAction;

class FetchIndexDataAction
{
    public function execute($request)
    {
        $flowers = $this->getDtData($request);
        $totalCount = $this->countDtResult($request);

        $data = [];
        $index = 0;
        foreach ($flowers as $val) {
            $index++;
            $row = array();
            $row['id'] = $index;
            $row['name'] = $val->name;
            $row['type'] = $val->type;
            $row['qty'] = $val->qty;
            $row['image'] = '<img src="' . base_url() . '/uploads\/' . ($val->image != '' ? $val->image : 'no-image.jpg') . '" alt="..." class="img-thumbnail" style="width: 80px;height: 80px;object-fit: cover;">';
            $row['created_date'] = $val->created_date;
            $data[] = $row;
        }

        return json_encode([
            'draw' => $request['draw'],
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $totalCount,
            'data' => $data
        ]);
    }

    private function getDtData($data)
    {
        $query = (new FetchFlowersAction)->execute($data);

        if ($data['length'] != -1) {
            $query = $query->limit($data['length'], $data['start']);
        }
        if (!empty($data['filter_year'])) {
            $query = $query->where('YEAR(f.created_date)', $data['filter_year']);  // Ubah ke f.created_date
        }

        // Tambahkan penanganan pencarian berdasarkan kategori
        if (!empty($data['category'])) {
            $query = $query->where('ft.type', $data['category']);
        }  

        return $query->get()->getResult();
    }

    private function countDtResult($data)
    {
        $query = (new FetchFlowersAction)->execute($data);

        // if (!empty($data['filter_year'])) {
        //     $query = $query->where('YEAR(created_date)', $data['filter_year']);
        // }

        return $query->countAllResults();
    }

    
}
