<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashMvSpringsModel extends Model
{
    protected $table = 'mv_springs';

    public function getEntries($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

}
