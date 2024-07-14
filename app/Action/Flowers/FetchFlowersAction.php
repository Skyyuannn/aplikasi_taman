<?php

namespace App\Action\Flowers;

class FetchFlowersAction
{
    private $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function execute($data)
    {
        $searchColumns = [
            'f.name',
            'f.qty',
        ];

        $query = $this->db->table('t_flowers as f')
            ->select('
                f.id,
                f.name,
                f.qty,
                f.image,
                f.created_date,
                ft.type,')
            ->join('t_flowers_type as ft', 'ft.id = f.type');

        if (filled($data['category'])) {
            $query = $query->where('ft.type', $data['category']);
        }
        if (filled($data['filter_year'])) {
            $query = $query->where('YEAR(f.created_date)', $data['filter_year']);
        }

        if (filled($data['search']['value'])) {
            foreach ($searchColumns as $key => $column) {
                if ($key === 0) {
                    $query = $query->like($column, $data['search']['value']);
                } else {
                    $query = $query->orLike($column, $data['search']['value']);
                }
            }
            $query = $query->groupEnd(); 
        }

        return $query;
    }
}
