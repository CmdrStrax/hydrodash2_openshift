<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashMvDischargeModel extends Model
{
    protected $table = 'mv_discharge';

    public function getEntries($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
