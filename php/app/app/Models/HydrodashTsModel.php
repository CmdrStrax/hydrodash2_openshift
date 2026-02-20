<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashTsModel extends Model
{
    protected $table = 'ts';

    public function getTs($id = false)
    {
        if ($id === false) {
            $this->select('ds_id, cat_id, dt, val');
            return $this->findAll();
        }

        $this->select('cat_id, dt, EXTRACT (EPOCH FROM dt) as dt_epoch, val');
        return $this->where(['ds_id' => $id])->where('dt <= now()')->orderBy('cat_id ASC, dt ASC')->findAll();
    }
}
