<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashDsGeoModel extends Model
{
    protected $table = 'ds_geo';
    protected $allowedFields = ['x_offset', 'y_offset'];
    protected $primaryKey = 'ds_id';
    protected $useAutoIncrement = false;

    public function getCoord($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        $this->select('ST_X(coord) as lon, ST_Y(coord) as lat, x_offset, y_offset');

        return $this->where(['ds_id' => $id])->first();
    }

    public function updateEntry($id, $data) {
        return $this->update($id, $data);
    }

}
