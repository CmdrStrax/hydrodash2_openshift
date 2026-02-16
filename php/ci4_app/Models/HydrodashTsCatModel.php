<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashTsCatModel extends Model
{
    protected $table = 'ts_categories';

    public function getCat()
    {
        $this->select('id, name_short');
        return $this->findAll();
    }
}
