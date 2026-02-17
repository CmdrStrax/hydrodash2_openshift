<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashDsStatModel extends Model
{
    protected $table = 'ds_statvalues';

    public function getKenn($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['ds_id' => $id])->findAll();
    }

}
