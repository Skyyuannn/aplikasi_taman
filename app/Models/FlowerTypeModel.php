<?php

namespace App\Models;

use CodeIgniter\Model;

class FlowerTypeModel extends Model
{
    protected $table            = 't_flowers_type';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['type', 'created_date'];
}
