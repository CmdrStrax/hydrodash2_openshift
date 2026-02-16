<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashMvPrecipModel extends Model
{
    protected $table = 'mv_precip';

    public function getEntries($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

}
