<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashDsAnalysisModel extends Model
{
    protected $table = 'ds_analysis';
    protected $allowedFields = ['ds_id', 'name', 'name_short', 'stat', 'period', 'comment', 'last_modified_by'];

    public function getAnalysis($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['ds_id' => $id])->orderBy('name')->findAll();
    }

    public function getAnalysisSingle($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

    public function getAnalysisExists($id, $name)
    {
        $res = $this->where(['ds_id' => $id])->where(['name' => $name])->findAll();

        if (count($res) == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getAnalyseResults($id = false)
    {
        $this->select("ds_analysis.name, ds_results.comment, ds_results.num_values_expected, ds_results.num_values_live, ds_results.num_values_lt, ds_results.last_modified_at, ds_results.valid_from, ds_results.valid_to");
        $this->join('ds_results', 'ds_analysis.id = ds_results.analysis_id');
        $this->where(['ds_analysis.ds_id' => $id]);
        $this->orderBy('ds_results.last_modified_at');

        return $this->findAll();
    }


    public function updateEntries($id, $data) {
        return $this->update($id, $data);
    }

}
