<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashDsInfoModel extends Model
{
    protected $table = 'ds_info';

    public function getInfo($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['ds_id' => $id])->first();
    }

}
