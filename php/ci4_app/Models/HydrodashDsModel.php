<?php

namespace App\Models;

use CodeIgniter\Model;

class HydrodashDsModel extends Model
{
    protected $table = 'ds';
    protected $allowedFields = ['zrid', 'zrid_lt', 'zrid_info', 'stat', 'lt_from', 'lt_to', 'start_hour', 'pos', 'comment', 'comment_admin' ,'active', 'last_modified_by'];

    public function getDatastreams($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

    public function getDatastreamsWithInfo($id = false)
    {
        $this->select("ds.*, ds_info.name, ds_info.hzbnr, ds_info.dbmnr, ds_info.ae, ds_info.altitude, ds_info.stream, ds_info.operator, ds_info.parameter, ds_info.webjob, ds_catchments.name as catchment_name");
        $this->join('ds_info', 'ds_info.ds_id = ds.id', 'left');
        $this->join('ds_catchments', 'ds.catchment_id = ds_catchments.id', 'left');
        $this->orderBy('ds_info.parameter ASC, ds_catchments.pos ASC');

        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['ds.id' => $id])->first();
    }

    public function getDatastreamsWithInfoAdmin($id = false)
    {
        $this->select("ds.id, ds.zrid, ds.active, ds.lt_from, ds.lt_to, ds.last_modified_at, ds.last_modified_by, ds_info.name, ds_info.hzbnr, ds_info.dbmnr, ds_info.ae, ds_info.altitude, ds_info.stream, ds_info.operator, ds_info.parameter, ds_info.webjob, ds_catchments.name as catchment_name, ds_tslog.last_modified_at as last_ts, ds_results.last_modified_at as last_analyse");
        $this->join('ds_info', 'ds_info.ds_id = ds.id', 'left');
        $this->join('ds_catchments', 'ds.catchment_id = ds_catchments.id', 'left');
        $this->join('ds_tslog', 'ds_tslog.ds_id = ds.id', 'left');
        $this->join('ds_analysis', 'ds_analysis.ds_id = ds.id', 'left');
        $this->join('ds_results', 'ds_results.analysis_id = ds_analysis.id', 'left');

        $this->orderBy('ds_info.parameter ASC, ds_catchments.pos ASC');

        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['ds.id' => $id])->first();
    }

    public function getDatastreamsForParam($id = false, $param = '%')
    {
        $this->select("ds.*, ds_info.name, ds_info.hzbnr, ds_info.dbmnr, ds_info.ae, ds_info.altitude, ds_info.stream, ds_info.operator, ds_info.parameter, ds_tslog.comment, ds_catchments.name as catchment_name");
        $this->join('ds_info', 'ds_info.ds_id = ds.id');
        $this->join('ds_tslog', 'ds_tslog.ds_id = ds.id');
        $this->join('ds_catchments', 'ds.catchment_id = ds_catchments.id');
        $this->where(['ds_tslog.name' => 'lt_webapp']);
        $this->where(['ds_info.parameter' => $param]);

        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['ds.id' => $id])->first();
    }

    public function getDatastreamCatchment($id = false)
    {
        $this->select("ds.id, ds_catchments.name as catchment_name, ds.comment as comment");
        $this->join('ds_catchments', 'ds.catchment_id = ds_catchments.id');

        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['ds.id' => $id])->first();
    }

    public function updateEntries($id, $data) {
        return $this->update($id, $data);
    }

}
