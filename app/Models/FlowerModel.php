<?php

namespace App\Models;

use CodeIgniter\Model;

class FlowerModel extends Model
{
    protected $table            = 't_flowers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['name', 'type', 'qty', 'image', 'created_date'];

    public function getFlowers($search = null)
    {
        $this->select("*");
        if ($search != '') {
            $this->like('name', (string)$search);
            $this->orLike('type', (string)$search);
        }
        $this->orderBy('created_date', 'desc');
        return $this->findAll();
    }

    public function sumFlowerQty()
    {
        $this->selectSum("qty");
        return $this->first();
    }
}
