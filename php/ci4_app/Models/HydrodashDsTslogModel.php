<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashDsTslogModel extends Model
{
    protected $table = 'ds_tslog';

    public function getEntry($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['ds_id' => $id])->orderBy('last_modified_at')->findAll();
    }

}
