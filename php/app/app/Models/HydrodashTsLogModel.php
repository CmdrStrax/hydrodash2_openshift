<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashTsLogModel extends Model
{
    protected $table = 'ds_tslog';

    public function getTsLog($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['ds_id' => $id])->first();
    }

    public function getTsLogWithName($id = false, $name = "")
    {
        return $this->where(['ds_id' => $id])->where(['name' => $name])->first();
    }
}
