<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashDsJobsArchiveModel extends Model
{
    protected $table = 'ds_jobs_archive';
    protected $allowedFields = ['ds_id', 'initiated_by'];
    protected $primaryKey = 'ds_id';
    protected $useAutoIncrement = false;


    public function getEntry($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['ds_id' => $id])->first();
    }


    public function getEntriesWithInfo()
    {
        $this->select("ds_info.name, ds_info.parameter, ds_jobs_archive.*, ds.zrid");
        $this->join('ds', 'ds.id = ds_jobs_archive.ds_id');
        $this->join('ds_info', 'ds_info.ds_id = ds_jobs_archive.ds_id', 'left');

        return $this->orderBy('ds_jobs_archive.finished_at')->findAll();
    }

}
