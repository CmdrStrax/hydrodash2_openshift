<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashMvGwModel extends Model
{
    protected $table = 'mv_groundwater';

    public function getEntries($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

}
