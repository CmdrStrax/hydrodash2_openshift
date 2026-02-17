<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashMvAirtempModel extends Model
{
    protected $table = 'mv_airtemp';

    public function getEntries($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

}
