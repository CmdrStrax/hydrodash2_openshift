<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashMvSpringsBasinModel extends Model
{
    protected $table = 'mv_springs_basins';

    public function getEntries($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['gid' => $id])->first();
    }

    public function getEntriesAvg()
    {
        $this->select("avg(res_last_day) as res_last_day, avg(res_last_30days) as res_last_30days, avg(res_last_lastmonth) as res_last_lastmonth, avg(res_last_month) as res_last_month, avg(res_this_year) as res_this_year, avg(res_last_year) as res_last_year");

        return $this->first();
    }
}
