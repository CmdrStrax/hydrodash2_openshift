<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashDsCatchmentModel extends Model
{
    protected $table = 'ds_catchments';
    protected $allowedFields = ['name', 'name_short', 'pos', 'last_modified_by'];

    public function getEntry($id = false)
    {
        if ($id === false) {
            return $this->orderBy('pos')->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

    public function getEntryCount($id = false)
    {
        $this->select('ds_catchments.*, coalesce(s.count, 0) as count', false);
        $this->join('(SELECT o.id, count(s.id) as count FROM ds s INNER JOIN ds_catchments o ON s.catchment_id = o.id GROUP BY o.id) s', 
            's.id = ds_catchments.id', 'left');

        if ($id === false) {
            return $this->orderBy('pos')->findAll();
        } else {
            return $this->where(['ds_catchments.id' => $id])->first();
        }
    }

    public function updateEntries($id, $data) {
        return $this->update($id, $data);
    }
}
