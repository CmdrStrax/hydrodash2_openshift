<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashMvWatertempModel extends Model
{
    protected $table = 'mv_watertemp';

    public function getEntries($id = false)
    {
        if ($id === false) {
            return $this->orderBy('name')->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

}
