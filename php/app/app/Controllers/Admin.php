<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; 
use CodeIgniter\Database\Exceptions\DatabaseException;

use App\Models\MenuModel;
use App\Models\HydrodashDsModel;
use App\Models\HydrodashDsAnalysisModel;
use App\Models\HydrodashDsCatchmentModel;
use App\Models\HydrodashDsJobsModel;
use App\Models\HydrodashDsJobsArchiveModel;
use App\Models\HydrodashDsTslogModel;
use App\Models\HydrodashDsGeoModel;
use CodeIgniter\Shield\Entities\User;

class Admin extends BaseController
{
    //
    // Init Session (Admin-Messages)
    //

    protected $session;

    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
    }
    
    private function _my_refresh_mv($param) 
    {
        $db = db_connect();

        if ($param == "Abfluss") {
            $db->query('REFRESH MATERIALIZED VIEW "mv_discharge"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_discharge_basins"');
        } elseif ($param == "WTemperatur") {
            $db->query('REFRESH MATERIALIZED VIEW "mv_watertemp"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_watertemp_basins"');
        } elseif ($param == "Niederschlag") {
            $db->query('REFRESH MATERIALIZED VIEW "mv_precip"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_precip_basins"');
        } elseif ($param == "Temperatur") {
            $db->query('REFRESH MATERIALIZED VIEW "mv_airtemp"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_airtemp_basins"');
        } elseif ($param == "GWS") {
            $db->query('REFRESH MATERIALIZED VIEW "mv_groundwater"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_groundwater_basins"');
        } elseif ($param == "QUWQ") {
            $db->query('REFRESH MATERIALIZED VIEW "mv_springs"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_springs_basins"');
        }
    }

    //
    // Station
    //

    // Overview

    public function admin()
    {
        $model_menu = model(MenuModel::class); 
        $model_ds = model(HydrodashDsModel::class);

        $data['title'] = 'Admin - Geber';
        $data['menu'] = $model_menu->getMenu();
        $data['menu_admin_side'] = $model_menu->getMenuAdminSide('Geber');
        $data['user'] = auth()->user()->username;
        $data['ds'] = $model_ds->getDatastreamsWithInfoAdmin();
        $data['cat'] = 'admin';

        // Show Alert if stations active in dashboard and inactive in webjob

        $data["webjob"] = FALSE;

        foreach ($data["ds"] as $d) {
            if ($d["active"] == "t" && $d["webjob"] == "f") {
                $data["webjob"] = TRUE;
            }
        }

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/menu_adminside')
            . view('admin/devices')
            . view('templates/footer');
    }

    public function update_device(?int $id = null)
    {
        $model_menu = model(MenuModel::class); 
        $model_ds = model(HydrodashDsModel::class);
        $model_ds_analysis = model(HydrodashDsAnalysisModel::class);
        $model_ds_jobs = model(HydrodashDsJobsModel::class);
        $model_ds_tslog = model(HydrodashDsTslogModel::class);
        $model_ds_geo = model(HydrodashDsGeoModel::class);

        $data['menu'] = $model_menu->getMenu();
        $data['menu_admin_side'] = $model_menu->getMenuAdminSide('Geber');
        $data['user'] = auth()->user()->username;
        $data['ds'] = $model_ds->getDatastreamsWithInfo($id);
        $data['ds_coord'] = $model_ds_geo->getCoord($id);
        $data['cat'] = 'admin';
        $data['analysis'] = $model_ds_analysis->getAnalysis($id);
        $data['jobs'] = $model_ds_jobs->getEntry($id);
        $data['tslog'] = $model_ds_tslog->getEntry($id);
        $data['analyselog'] = $model_ds_analysis->getAnalyseResults($id);

        if ($data['ds']['name'] != '') {
            $data['title'] = 'Admin - Geber ' . $data['ds']['name'];
        } else {
            $data['title'] = 'Admin - Geber ' . $data['ds']['zrid'];
        }

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/menu_adminside')
            . view('admin/update_device')
            . view('templates/footer');
    }

    public function update_device_post(?int $id = null)
    {
        helper('form');
        $data = $this->request->getPost(['zrid', 'zrid_lt', 'zrid_info', 'lt_from', 'lt_to', 'stat', 'start_hour', 'pos', 'comment', 'comment_admin', 'active', 'x_offset', 'y_offset']);

        if (! $this->validateData($data, [
            'zrid' => 'required',
            'zrid_lt' => 'permit_empty',
            'zrid_info' => 'permit_empty',
            'lt_from' => 'required|valid_date[Y-m-d]',
            'lt_to' => 'required|valid_date[Y-m-d]',
            'stat' => 'required|max_length[50]',
            'start_hour' => 'permit_empty|decimal',
            'pos' => 'permit_empty|decimal',
            'comment' => 'permit_empty|max_length[200]',
            'comment_admin' => 'permit_empty|max_length[200]',
            'active' => 'permit_empty',
            'x_offset' => 'permit_empty|integer',
            'y_offset' => 'permit_empty|integer',
        ])) {
            return $this->update_device($id);
        }

        $post = $this->validator->getValidated();

        $model = model(HydrodashDsModel::class);

        $zrid  = empty($post['zrid']) ? NULL : $post['zrid'];
        $zrid_lt  = empty($post['zrid_lt']) ? NULL : $post['zrid_lt'];
        $zrid_info  = empty($post['zrid_info']) ? NULL : $post['zrid_info'];
        $lt_from  = empty($post['lt_from']) ? NULL : $post['lt_from'];
        $lt_to  = empty($post['lt_to']) ? NULL : $post['lt_to'];
        $stat  = empty($post['stat']) ? NULL : $post['stat'];
        $start_hour  = empty($post['start_hour']) ? 0 : $post['start_hour'];
        $pos  = empty($post['pos']) ? NULL : $post['pos'];
        $comment = empty($post['comment']) ? NULL : $post['comment'];
        $comment_admin = empty($post['comment_admin']) ? NULL : $post['comment_admin'];
        $active = empty($post['active']) ? NULL : $post['active'];

        $model->updateEntries($id, [
            'zrid' => $zrid,
            'zrid_lt' => $zrid_lt,
            'zrid_info'  => $zrid_info,
            'lt_from'  => date('Y-m-d H:i:s', strtotime($post['lt_from'])),
            'lt_to'  => date('Y-m-d H:i:s', strtotime($post['lt_to'])),
            'stat'  => $stat,
            'start_hour'  => $start_hour,
            'pos'  => $pos,
            'comment' => $comment,
            'comment_admin' => $comment_admin,
            'active' => $active,
            'last_modified_by' => auth()->user()->username,
        ]);

        $model_geo = model(HydrodashDsGeoModel::class);

        $x_offset = empty($post['x_offset']) ? 0 : $post['x_offset'];
        $y_offset = empty($post['y_offset']) ? 0 : $post['y_offset'];

        $model_geo->updateEntry($id, [
            'x_offset' => $x_offset,
            'y_offset' => $y_offset,
        ]);

        $info = $model->getDatastreamsWithInfo($id);

        if ($info["parameter"] != "") {
            $adminmsg = "Datensatz geändert und Materialized Views für Parameter \"" . $info["parameter"] . "\" refreshed.";
            $this->_my_refresh_mv($info["parameter"]);
        } else {
            $adminmsg = "Datensatz geändert.";
        }

        return redirect()->to(base_url('admin/device/update/' . $id . '#ds_def'))->with('adminmessage', $adminmsg);
    }

    public function new_device()
    {
        helper('form');

        $model_menu = model(MenuModel::class); 
        $model_ds = model(HydrodashDsModel::class);

        $data['title'] = 'Admin - Neuer Geber';
        $data['menu'] = $model_menu->getMenu();
        $data['menu_admin_side'] = $model_menu->getMenuAdminSide('Geber');
        $data['user'] = auth()->user()->username;
        $data['cat'] = 'admin';

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/menu_adminside')
            . view('admin/new_device')
            . view('templates/footer');
    }

    public function new_device_post()
    {
        helper('form');

        $data = $this->request->getPost(['zrid', 'zrid_lt', 'zrid_info', 'lt_from', 'lt_to', 'stat', 'start_hour', 'pos', 'comment']);

        if (! $this->validateData($data, [
            'zrid' => 'required',
            'zrid_lt' => 'permit_empty',
            'zrid_info' => 'permit_empty',
            'lt_from' => 'required|valid_date[Y-m-d]',
            'lt_to' => 'required|valid_date[Y-m-d]',
            'stat' => 'required|max_length[50]',
            'start_hour' => 'permit_empty|decimal',
            'pos' => 'permit_empty|decimal',
            'comment' => 'permit_empty|max_length[200]',
        ])) {
            return $this->new_device();
        }

        $post = $this->validator->getValidated();

        $model = model(HydrodashDsModel::class);

        $zrid  = empty($post['zrid']) ? NULL : $post['zrid'];
        $zrid_lt  = empty($post['zrid_lt']) ? NULL : $post['zrid_lt'];
        $zrid_info  = empty($post['zrid_info']) ? NULL : $post['zrid_info'];
        $lt_from  = empty($post['lt_from']) ? NULL : $post['lt_from'];
        $lt_to  = empty($post['lt_to']) ? NULL : $post['lt_to'];
        $stat  = empty($post['stat']) ? NULL : $post['stat'];
        $start_hour  = empty($post['start_hour']) ? 0 : $post['start_hour'];
        $pos  = empty($post['pos']) ? NULL : $post['pos'];
        $comment = empty($post['comment']) ? NULL : $post['comment'];
        $active = false;

        $model->save([
            'zrid' => $zrid,
            'zrid_lt' => $zrid_lt,
            'zrid_info'  => $zrid_info,
            'lt_from'  => date('Y-m-d H:i:s', strtotime($post['lt_from'])),
            'lt_to'  => date('Y-m-d H:i:s', strtotime($post['lt_to'])),
            'stat'  => $stat,
            'start_hour'  => $start_hour,
            'pos'  => $pos,
            'comment' => $comment,
            'active' => $active,
            'last_modified_by' => auth()->user()->username,
        ]);

        $id = $model->getInsertID();

        return redirect()->to(base_url('admin/device/update/' . $id))->with('adminmessage', "Geber " . $zrid . " angelegt.");
    }

    public function device_job_create($id = null)
    {
        $model = model(HydrodashDsJobsModel::class);

        if (!is_null($model->getEntry($id))) {
            return redirect()->to(base_url('admin/device/update/' . $id . '#job'))->with('adminmessage_jobs', "Für den Geber existiert bereits ein ausstehender Job.");
        }

        $model->insert([
            'ds_id' => $id,
            'initiated_by' => auth()->user()->username,
        ]);

        return redirect()->to(base_url('admin/device/update/' . $id . '#job'));
    }

    public function device_job_delete($id = null)
    {
        $model = model(HydrodashDsJobsModel::class);

        if (is_null($model->getEntry($id))) {
            return redirect()->to(base_url('admin/device/update/' . $id . '#job'))->with('adminmessage_jobs', "Kein Job vorhanden.");
        }

        $model->where('ds_id', $id)->delete();

        return redirect()->to(base_url('admin/device/update/' . $id . '#job'))->with('adminmessage_jobs', "Job gelöscht.");
    }

    public function delete_device($id = null)
    {
        $model = model(HydrodashDsModel::class);

        $ds = $model->getDatastreamsWithInfo($id);

        if ($ds["name"] != "") {
            $g = $ds["name"] . ' (' .  $ds["parameter"] . ')';
        } else {
            $g = $ds["zrid"]; 
        }

        $model->where('id', $id)->delete();

        if ($ds["parameter"] != "") {
            $this->_my_refresh_mv($ds["parameter"]);
            $adminmsg = "Geber " . $g . " gelöscht und Materalized Views für Parameter \"" . $ds["parameter"] . "\" refreshed.";
        } else {
            $g = $ds["zrid"]; 
            $adminmsg = "Geber " . $g . " gelöscht.";
        } 
        
        return redirect()->route('admin')->with('adminmessage', $adminmsg);
    }

    public function active_device($id = null)
    {
        $model = model(HydrodashDsModel::class);

        $ds = $model->getDatastreamsWithInfo($id);

        if ($ds["name"] != "") {
            $g_short = $ds["name"]; 
            $g = $ds["name"] . ' (' .  $ds["parameter"] . ')';
        } else {
            $g = $ds["zrid"]; 
            $g_short = $g;
        }

        if ($ds["active"] == "t") {
            $model->where('id', $id)->updateEntries($id, [ 'active' => FALSE, 'last_modified_by' => auth()->user()->username ]);
            $i = 'Geber ' . $g . ' wurde deaktiviert';
            $a = FALSE;
            $a_str = 'f';
        } else {
            $model->where('id', $id)->updateEntries($id, [ 'active' => TRUE, 'last_modified_by' => auth()->user()->username ]);
            $i = 'Geber ' . $g . ' wurde aktiviert';
            $a = TRUE;
            $a_str = 't';
        }

        $this->_my_refresh_mv($ds["parameter"]);

        $now = new \DateTime();      
        $data = array('id' => $id, 'name' => $g_short, 'text' => $i, 'active' => $a, 'active_str' => $a_str, 'dt' => $now->format('Y-m-d H:i:s'));    

        return $this->response->setJSON($data);
    }

    public function new_analysis(?int $id = null)
    {
        helper('form');

        $model_menu = model(MenuModel::class); 
        $model = model(HydrodashDsAnalysisModel::class);

        $data['title'] = 'Admin - Neue Analyse';
        $data['menu'] = $model_menu->getMenu();
        $data['menu_admin_side'] = $model_menu->getMenuAdminSide('Geber');
        $data['user'] = auth()->user()->username;
        $data['cat'] = 'admin';
        $data['id'] = $id;
        $analyses = $model->getAnalysis($id);
        $analyses_arr = array();

        foreach ($analyses as $a) {
            array_push($analyses_arr, $a['name']);
        }

        $data['analyses'] = $analyses_arr;

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/menu_adminside')
            . view('admin/new_analysis')
            . view('templates/footer');
    }

    public function new_analysis_post(?int $id = null)
    {
        helper('form');

        $data = $this->request->getPost(['name', 'name_short', 'stat', 'period', 'comment']);

        if (! $this->validateData($data, [
            'name' => 'required',
            'name_short' => 'permit_empty',
            'stat' => 'permit_empty',
            'period' => 'permit_empty',
            'comment' => 'permit_empty|max_length[100]',
        ])) {
            return $this->new_analysis($id);
        }

        $post = $this->validator->getValidated();
        $model = model(HydrodashDsAnalysisModel::class);

        $name  = empty($post['name']) ? NULL : $post['name'];
        $name_short  = empty($post['name_short']) ? NULL : $post['name_short'];
        $stat  = empty($post['stat']) ? NULL : $post['stat'];
        $period  = empty($post['period']) ? NULL : $post['period'];
        $comment  = empty($post['comment']) ? NULL : $post['comment'];

        // Check unique

        if ($model->getAnalysisExists($id, $name)) {
            return redirect()->to(base_url('admin/analysis/new/' . $id))->with('adminmessage', "Analyse existiert für Geber bereits.");
        }

        $model->save([
            'ds_id' => $id,
            'name' => $name,
            'name_short' => $name_short,
            'stat' => $stat,
            'period' => $period,
            'comment' => $comment,
            'last_modified_by' => auth()->user()->username,
        ]);

        return redirect()->to(base_url('admin/device/update/' . $id . '#analysis'))->with('adminmessage_analyse', "Analyse angelegt.");
    }

    public function new_analysis_set(?int $id = null, ?string $set = null)
    {
        $model = model(HydrodashDsAnalysisModel::class);
        $an = $model->getAnalysis($id);
        $analysis = array();

        foreach ($an as $a) {
            array_push($analysis, $a['name']);
        }

        if ($set == 'standard') {
            if (!in_array('last_day_mean', $analysis)) {
                $model->save([
                    'ds_id' => $id,
                    'name' => 'last_day_mean',
                    'name_short' => 'ldm',
                    'stat' => 'mean',
                    'period' => '1d',
                    'last_modified_by' => auth()->user()->username,
                ]);
            }

            if (!in_array('last_30days_mean', $analysis)) {
                $model->save([
                    'ds_id' => $id,
                    'name' => 'last_30days_mean',
                    'name_short' => 'l30dm',
                    'stat' => 'mean',
                    'period' => '30d',
                    'last_modified_by' => auth()->user()->username,
                ]);
            }

            if (!in_array('last_lastmonth_mean', $analysis)) {
                $model->save([
                    'ds_id' => $id,
                    'name' => 'last_lastmonth_mean',
                    'name_short' => 'llmm',
                    'stat' => 'mean',
                    'period' => '1m',
                    'last_modified_by' => auth()->user()->username,
                ]);
            }

            if (!in_array('last_month_mean', $analysis)) {
                $model->save([
                    'ds_id' => $id,
                    'name' => 'last_month_mean',
                    'name_short' => 'lmm',
                    'stat' => 'mean',
                    'period' => '1m',
                    'last_modified_by' => auth()->user()->username,
                ]);
            }
            
            if (!in_array('this_year_mean', $analysis)) {
                $model->save([
                    'ds_id' => $id,
                    'name' => 'this_year_mean',
                    'name_short' => 'tym',
                    'stat' => 'mean',
                    'period' => '',
                    'last_modified_by' => auth()->user()->username,
                ]);
            }

            if (!in_array('last_year_mean', $analysis)) {
                $model->save([
                    'ds_id' => $id,
                    'name' => 'last_year_mean',
                    'name_short' => 'lym',
                    'stat' => 'mean',
                    'period' => '1y',
                    'last_modified_by' => auth()->user()->username,
                ]);
            }

            return redirect()->to(base_url('admin/device/update/' . $id . '#analysis'))->with('adminmessage_analysis', "Analyseset \"" . $set . "\" angelegt.");
        } elseif ($set == 'niederschlag') {
            if (!in_array('last_30days_sum', $analysis)) {
                $model->save([
                    'ds_id' => $id,
                    'name' => 'last_30days_sum',
                    'name_short' => 'l30ds',
                    'stat' => 'sum',
                    'period' => '30d',
                    'last_modified_by' => auth()->user()->username,
                ]);
            }

            if (!in_array('last_lastmonth_sum', $analysis)) {
                $model->save([
                    'ds_id' => $id,
                    'name' => 'last_lastmonth_sum',
                    'name_short' => 'llms',
                    'stat' => 'sum',
                    'period' => '1m',
                    'last_modified_by' => auth()->user()->username,
                ]);
            }

            if (!in_array('last_month_sum', $analysis)) {
                $model->save([
                    'ds_id' => $id,
                    'name' => 'last_month_sum',
                    'name_short' => 'lms',
                    'stat' => 'sum',
                    'period' => '1m',
                    'last_modified_by' => auth()->user()->username,
                ]);
            }
            
            if (!in_array('this_year_sum', $analysis)) {
                $model->save([
                    'ds_id' => $id,
                    'name' => 'this_year_sum',
                    'name_short' => 'tys',
                    'stat' => 'sum',
                    'period' => '',
                    'last_modified_by' => auth()->user()->username,
                ]);
            }

            if (!in_array('last_year_sum', $analysis)) {
                $model->save([
                    'ds_id' => $id,
                    'name' => 'last_year_sum',
                    'name_short' => 'lys',
                    'stat' => 'sum',
                    'period' => '1y',
                    'last_modified_by' => auth()->user()->username,
                ]);
            }

            return redirect()->to(base_url('admin/device/update/' . $id . '#analysis'))->with('adminmessage_analysis', "Analyseset \"" . $set . "\" angelegt.");
        } else {
            return redirect()->to(base_url('admin/device/update/' . $id . '#analysis'))->with('adminmessage_analysis', "Analyseset \"" . $set . "\" nicht definiert.");
        }
    }

    public function delete_analysis_device($id = null)
    {
        $model = model(HydrodashDsAnalysisModel::class);
        $model->where('ds_id', $id)->delete();
        return redirect()->to(base_url('admin/device/update/' . $id . '#analysis'))->with('adminmessage_analysis', "Alle Analysen für Geber gelöscht.");
    }

    public function delete_analysis($id = null)
    {
        $model = model(HydrodashDsAnalysisModel::class);
        $e = $model->getAnalysisSingle($id);
        $model->where('id', $id)->delete();
        return redirect()->to(base_url('admin/device/update/' . $e["ds_id"] . '#analysis'))->with('adminmessage_analysis', "Analyse \"" . $e["name"] . "\" gelöscht.");
    }

    public function catchment()
    {
        $model_menu = model(MenuModel::class); 
        $model_catch = model(HydrodashDsCatchmentModel::class);

        $data['title'] = 'Admin - Einzugsgebiete';
        $data['menu'] = $model_menu->getMenu();
        $data['menu_admin_side'] = $model_menu->getMenuAdminSide('Einzugsgebiete');
        $data['user'] = auth()->user()->username;
        $data['catchments'] = $model_catch->getEntryCount();
        $data['cat'] = 'admin';

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/menu_adminside')
            . view('admin/catchments')
            . view('templates/footer');
    }

    public function update_catchment(?int $id = null)
    {
        $model_menu = model(MenuModel::class); 
        $model_catch = model(HydrodashDsCatchmentModel::class);

        $data['title'] = 'Admin - Einzugsgebiete';
        $data['menu'] = $model_menu->getMenu();
        $data['menu_admin_side'] = $model_menu->getMenuAdminSide('Einzugsgebiete');
        $data['user'] = auth()->user()->username;
        $data['catchment'] = $model_catch->getEntryCount($id);
        $data['cat'] = 'admin';

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/menu_adminside')
            . view('admin/update_catchment')
            . view('templates/footer');
    }

    public function update_catchment_post(?int $id = null)
    {
        helper('form');
        $data = $this->request->getPost(['name', 'name_short', 'pos']);

        $model = model(HydrodashDsCatchmentModel::class);
        $e = $model->getEntry($id);

        if ($e["name"] == $data["name"]) {
            if (! $this->validateData($data, [
                'name_short' => 'permit_empty',
                'pos' => 'permit_empty|integer',
            ])) {
                return $this->update_catchment($id);
            }

            $post = $this->validator->getValidated();

            $name_short  = empty($post['name_short']) ? NULL : $post['name_short'];
            $pos  = empty($post['pos']) ? NULL : $post['pos'];

            $model->updateEntries($id, [
                'name_short' => $name_short,
                'pos'  => $pos,
                'last_modified_by' => auth()->user()->username,
            ]);
        } else {
            if (! $this->validateData($data, [
                'name' => 'required|is_unique["ds_catchments.name"]',
                'name_short' => 'permit_empty',
                'pos' => 'permit_empty|integer',
            ])) {
                return $this->update_catchment($id);
            }

            $post = $this->validator->getValidated();

            $name  = empty($post['name']) ? NULL : $post['name'];
            $name_short  = empty($post['name_short']) ? NULL : $post['name_short'];
            $pos  = empty($post['pos']) ? NULL : $post['pos'];

            $model->updateEntries($id, [
                'name' => $name,
                'name_short' => $name_short,
                'pos'  => $pos,
                'last_modified_by' => auth()->user()->username,
            ]);
        }

        $this->_my_refresh_mv("Abfluss");
        $this->_my_refresh_mv("WTemperatur");
        $this->_my_refresh_mv("Niederschlag");
        $this->_my_refresh_mv("Temperatur");
        $this->_my_refresh_mv("GWS");
        $this->_my_refresh_mv("UWQ");

        return redirect()->to(base_url('admin/catchment/'))->with('adminmessage', "Datensatz \"" . $data["name"] . "\" geändert und refreshed alle Materialized Views.");
    }

    public function new_catchment()
    {
        helper('form');

        $model_menu = model(MenuModel::class); 

        $data['title'] = 'Admin - Neues Einzugsgebiet';
        $data['menu'] = $model_menu->getMenu();
        $data['menu_admin_side'] = $model_menu->getMenuAdminSide('Einzugsgebiete');
        $data['user'] = auth()->user()->username;
        $data['cat'] = 'admin';

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/menu_adminside')
            . view('admin/new_catchment')
            . view('templates/footer');
    }

    public function new_catchment_post()
    {
        helper('form');

        $data = $this->request->getPost(['name', 'name_short', 'pos']);

        if (! $this->validateData($data, [
            'name' => 'required|is_unique["ds_catchments.name"]',
            'name_short' => 'permit_empty',
            'pos' => 'permit_empty|integer',
        ])) {
            return $this->new_catchment();
        }

        $post = $this->validator->getValidated();

        $model = model(HydrodashDsCatchmentModel::class);

        $name  = empty($post['name']) ? NULL : $post['name'];
        $name_short  = empty($post['name_short']) ? NULL : $post['name_short'];
        $pos  = empty($post['pos']) ? NULL : $post['pos'];

        $model->save([
            'name' => $name,
            'name_short' => $name_short,
            'pos'  => $pos,
            'last_modified_by' => auth()->user()->username,
        ]);

        return redirect()->to(base_url('admin/catchment/'))->with('adminmessage', "Einzugsgebiet " . $name . " angelegt.");
    }

    public function delete_catchment($id = null)
    {
        $model = model(HydrodashDsCatchmentModel::class);
        $e = $model->getEntry($id);
        $model->where('id', $id)->delete();
        return redirect()->to(base_url('admin/catchment/'))->with('adminmessage', "Einzugsgebiet \"" . $e["name"] . "\" gelöscht.");
    }

    public function jobs()
    {
        $model_menu = model(MenuModel::class); 
        $model_jobs = model(HydrodashDsJobsModel::class);
        $model_jobs_archive = model(HydrodashDsJobsArchiveModel::class);

        $data['title'] = 'Admin - Jobs';
        $data['menu'] = $model_menu->getMenu();
        $data['menu_admin_side'] = $model_menu->getMenuAdminSide('Jobs');
        $data['user'] = auth()->user()->username;
        $data['jobs'] = $model_jobs->getEntriesWithInfo();
        $data['jobs_archive'] = $model_jobs_archive->getEntriesWithInfo();

        $data['cat'] = 'admin';

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/menu_adminside')
            . view('admin/jobs')
            . view('templates/footer');
    }

    public function job_delete($id = null)
    {
        $model = model(HydrodashDsJobsModel::class);

        if (is_null($model->getEntry($id))) {
            return redirect()->to(base_url('admin/jobs/' . $id))->with('adminmessage_jobs', "Kein Job vorhanden.");
        }

        $model->where('ds_id', $id)->delete();

        return redirect()->to(base_url('admin/jobs/'))->with('adminmessage_jobs', "Job gelöscht.");
    }

    public function logs()
    {
        $config = new \Config\Site();
        $model_menu = model(MenuModel::class); 

        $data['title'] = 'Admin - Logs';
        $data['menu'] = $model_menu->getMenu();
        $data['menu_admin_side'] = $model_menu->getMenuAdminSide('Logs');
        $data['user'] = auth()->user()->username;
        $data['cat'] = 'admin';

        $data['log_nightly'] = $config->log_nightly;
		$data['log_jobs'] = $config->log_jobs;

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/menu_adminside')
            . view('admin/logs')
            . view('templates/footer');
    }

    public function mv()
    {
        $model_menu = model(MenuModel::class); 

        $data['title'] = 'Admin - Materialized Views';
        $data['menu'] = $model_menu->getMenu();
        $data['menu_admin_side'] = $model_menu->getMenuAdminSide('Materialized Views');
        $data['user'] = auth()->user()->username;
        $data['cat'] = 'admin';

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/menu_adminside')
            . view('admin/mv')
            . view('templates/footer');
    }

    public function refresh_mv(String $mv = null)
    {
        $db = db_connect();
        $adminmsg = "";

        try {
            $db->transException(true)->transStart();
            $db->query('REFRESH MATERIALIZED VIEW "mv_' . $mv . '"');
            $db->transComplete();

            $adminmsg = "Refreshed Materialized View \"mv_" . $mv . "\"";            
        } catch (DatabaseException $e) {
            $msg = $e->getMessage();

            if (str_contains($msg, 'does not exist')) {
                $adminmsg = "Materalized View \"" . $mv . "\" existiert nicht.";
            } else {
                $adminmsg = "Fehler in Transaktion (PG: " . $msg . ")";
            }
        }

        return redirect()->to(base_url('admin/mv/'))->with('adminmessage_mv', $adminmsg);
    }

    public function refresh_mv_all()
    {
        $db = db_connect();

        try {
            $db->transException(true)->transStart();
            $db->query('REFRESH MATERIALIZED VIEW "mv_discharge"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_discharge_basins"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_watertemp"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_watertemp_basins"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_airtemp"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_airtemp_basins"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_precip"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_precip_basins"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_groundwater"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_groundwater_basins"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_springs"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_springs_basins"');

            $db->transComplete();
        } catch (DatabaseException $e) {
            $msg = $e->getMessage();

            return redirect()->to(base_url('admin/mv/'))->with('adminmessage_mv', "Fehler in Transaktion (PG: " . $msg . ")"); 
        }

        return redirect()->to(base_url('admin/mv/'))->with('adminmessage_mv', "Alle materialized views refreshed.");
    }

}