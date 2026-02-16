<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashDsResModel extends Model
{
    protected $table = 'ds_analysis';

    public function getResults($id = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

    public function getResultsForDs($id = false, $name = '%')
    {
        $this->select("ds_analysis.name, ds_results.val, ds_results.val_lt, ds_results.val_lt_min, ds_results.val_lt_max, ds_results.valid_from, ds_results.valid_to, ds_results.last_modified_at");
        $this->join('ds_results', 'ds_results.analysis_id = ds_analysis.id');
        $this->where(['ds_analysis.ds_id' => $id]);
        $this->like(['ds_analysis.name' => $name]);

        return $this->findAll();
    }
}
