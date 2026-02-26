<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;
use App\Models\MenuModel;

use App\Models\HydrodashDsModel;
use App\Models\HydrodashDsInfoModel;
use App\Models\HydrodashDsGeoModel;
use App\Models\HydrodashDsStatModel;
use App\Models\HydrodashDsResModel;

use App\Models\HydrodashTsModel;
use App\Models\HydrodashTsCatModel;
use App\Models\HydrodashTsLogModel;

use App\Models\HydrodashMvDischargeModel;
use App\Models\HydrodashMvDischargeBasinModel;
use App\Models\HydrodashMvWatertempModel;
use App\Models\HydrodashMvWatertempBasinModel;
use App\Models\HydrodashMvPrecipModel;
use App\Models\HydrodashMvPrecipBasinModel;
use App\Models\HydrodashMvAirtempModel;
use App\Models\HydrodashMvAirtempBasinModel;
use App\Models\HydrodashMvGwModel;
use App\Models\HydrodashMvGwBasinModel;
use App\Models\HydrodashMvSpringsModel;
use App\Models\HydrodashMvSpringsBasinModel;

use DateTime;
use DateTimeZone;
use DatePeriod;
use DateInterval;

class Hydrodash extends BaseController
{
    public function discharge()
    {   
        $config = new \Config\Site();

        $data['title'] = 'Abfluss';

        $model_menu = model(MenuModel::class); 
        $model_ds = model(HydrodashMvDischargeModel::class);
        $model_basin = model(HydrodashMvDischargeBasinModel::class);

        $data['ds'] = $model_ds->getEntries();
        $data['menu'] = $model_menu->getMenu('Abfluss');
        $data['sub'] = 'discharge';

        $data['yesterday'] = "";
        $data['last_30days_from'] = "";
        $data['last_month'] = "";
        $data["last_lastmonth"] = "";
        $data["this_year"] = "";
        $data["last_year"] = "";

        if (count($data['ds']) > 0) {
            $data['yesterday'] = (new DateTime($data['ds'][0]["res_last_day_mean_from"]))->format('d.m.Y');
            $data['last_30days_from'] = (new DateTime($data['ds'][0]["res_last_30days_mean_from"]))->format('d.m.Y');
            $data['last_month'] = Time::createFromFormat('Y-m-d H:i:s', $data['ds'][0]["res_last_month_mean_from"])->toLocalizedString('MMMM yyyy');
            $data["last_lastmonth"] = Time::createFromFormat('Y-m-d H:i:s', $data['ds'][0]["res_last_lastmonth_mean_from"])->toLocalizedString('MMMM yyyy');
            $data["this_year"] = (new DateTime($data['ds'][0]["res_this_year_mean_to"]))->format('d.m.Y');
            $data["last_year"] = (new DateTime($data['ds'][0]["res_last_year_mean_from"]))->format('Y');
        } 
		
		$data['geoserver_wms_url'] = $config->geoserver_wms_url;
		$data['geoserver_wfs_url'] = $config->geoserver_wfs_url;

        $data['basins'] = $model_basin->getEntriesAvg();

        return view('templates/header', $data)
            . view('templates/menu')
            . view('hydrodash/overview/discharge')
            . view('templates/footer');
    }

    public function watertemp()
    {
        $config = new \Config\Site();

        $data['title'] = 'Wassertemperatur';

        $model_menu = model(MenuModel::class); 
        $model_ds = model(HydrodashMvWatertempModel::class);
        $model_basin = model(HydrodashMvWatertempBasinModel::class);

        $data['ds'] = $model_ds->getEntries();
        $data['menu'] = $model_menu->getMenu('Wassertemperatur');
        $data['sub'] = 'watertemp';

        $data['yesterday'] = "";
        $data['last_30days_from'] = "";
        $data['last_month'] = "";
        $data["last_lastmonth"] = "";
        $data["this_year"] = "";
        $data["last_year"] = "";

        if (count($data['ds']) > 0) {
            $data['yesterday'] = (new DateTime($data['ds'][0]["res_last_day_mean_from"]))->format('d.m.Y');
            $data['last_30days_from'] = (new DateTime($data['ds'][0]["res_last_30days_mean_from"]))->format('d.m.Y');
            $data['last_month'] = Time::createFromFormat('Y-m-d H:i:s', $data['ds'][0]["res_last_month_mean_from"])->toLocalizedString('MMMM yyyy');
            $data["last_lastmonth"] = Time::createFromFormat('Y-m-d H:i:s', $data['ds'][0]["res_last_lastmonth_mean_from"])->toLocalizedString('MMMM yyyy');
            $data["this_year"] = (new DateTime($data['ds'][0]["res_this_year_mean_to"]))->format('d.m.Y');
            $data["last_year"] = (new DateTime($data['ds'][0]["res_last_year_mean_from"]))->format('Y');
        } 
		
        $data['basins'] = $model_basin->getEntriesAvg();

		$data['geoserver_wms_url'] = $config->geoserver_wms_url;
		$data['geoserver_wfs_url'] = $config->geoserver_wfs_url;

        return view('templates/header', $data)
            . view('templates/menu')
            . view('hydrodash/overview/watertemp')
            . view('templates/footer');
    }

    public function precip()
    {
        $config = new \Config\Site();

        $data['title'] = 'Niederschlag';

        $model_menu = model(MenuModel::class); 
        $model_ds = model(HydrodashMvPrecipModel::class);
        $model_basin = model(HydrodashMvPrecipBasinModel::class);

        $data['ds'] = $model_ds->getEntries();
        $data['menu'] = $model_menu->getMenu('Niederschlag');
        $data['sub'] = 'precip';

        $data['last_30days_from'] = "";
        $data['last_30days_to'] = "";
        $data["last_lastmonth"] = "";
        $data['last_month'] = "";
        $data["this_year"] = "";
        $data["last_year"] = "";

        if (count($data['ds']) > 0) {
            $data['last_30days_from'] = (new DateTime($data['ds'][0]["res_last_30days_from"]))->format('d.m.Y');
            $data['last_30days_to'] = (new DateTime($data['ds'][0]["res_last_30days_to"]))->format('d.m.Y');
            $data["last_lastmonth"] = Time::createFromFormat('Y-m-d H:i:s', $data['ds'][0]["res_last_lastmonth_from"])->toLocalizedString('MMMM yyyy');
            $data['last_month'] = Time::createFromFormat('Y-m-d H:i:s', $data['ds'][0]["res_last_month_from"])->toLocalizedString('MMMM yyyy');
            $data["this_year"] = (new DateTime($data['ds'][0]["res_this_year_to"]))->format('d.m.Y');
            $data["last_year"] = (new DateTime($data['ds'][0]["res_last_year_from"]))->format('Y');
        } 
		
        $data['basins'] = $model_basin->getEntriesAvg();

		$data['geoserver_wms_url'] = $config->geoserver_wms_url;
		$data['geoserver_wfs_url'] = $config->geoserver_wfs_url;

        return view('templates/header', $data)
            . view('templates/menu')
            . view('hydrodash/overview/precip')
            . view('templates/footer');
    }

    public function airtemp()
    {   
        $config = new \Config\Site();

        $data['title'] = 'Lufttemperatur';

        $model_menu = model(MenuModel::class); 
        $model_ds = model(HydrodashMvAirtempModel::class);
        $model_basin = model(HydrodashMvAirtempBasinModel::class);

        $data['ds'] = $model_ds->getEntries();
        $data['menu'] = $model_menu->getMenu('Lufttemperatur');
        $data['sub'] = 'airtemp';

        $data['yesterday'] = "";
        $data['last_30days_from'] = "";
        $data['last_month'] = "";
        $data["last_lastmonth"] = "";
        $data["this_year"] = "";
        $data["last_year"] = "";

        if (count($data['ds']) > 0) {
            $data['yesterday'] = (new DateTime($data['ds'][0]["res_last_day_mean_from"]))->format('d.m.Y');
            $data['last_30days_from'] = (new DateTime($data['ds'][0]["res_last_30days_mean_from"]))->format('d.m.Y');
            $data['last_month'] = Time::createFromFormat('Y-m-d H:i:s', $data['ds'][0]["res_last_month_mean_from"])->toLocalizedString('MMMM yyyy');
            $data["last_lastmonth"] = Time::createFromFormat('Y-m-d H:i:s', $data['ds'][0]["res_last_lastmonth_mean_from"])->toLocalizedString('MMMM yyyy');
            $data["this_year"] = (new DateTime($data['ds'][0]["res_this_year_mean_to"]))->format('d.m.Y');
            $data["last_year"] = (new DateTime($data['ds'][0]["res_last_year_mean_from"]))->format('Y');
        } 
		
        $data['basins'] = $model_basin->getEntriesAvg();

		$data['geoserver_wms_url'] = $config->geoserver_wms_url;
		$data['geoserver_wfs_url'] = $config->geoserver_wfs_url;

        return view('templates/header', $data)
            . view('templates/menu')
            . view('hydrodash/overview/airtemp')
            . view('templates/footer');
    }

    public function gw()
    {   
        $config = new \Config\Site();

        $data['title'] = 'Grundwasser';

        $model_menu = model(MenuModel::class); 
        $model_ds = model(HydrodashMvGwModel::class);
        $model_basin = model(HydrodashMvGwBasinModel::class);

        $data['ds'] = $model_ds->getEntries();
        $data['menu'] = $model_menu->getMenu('Grundwasser');
        $data['sub'] = 'gw';

        $data['yesterday'] = "";
        $data['last_30days_from'] = "";
        $data['last_month'] = "";
        $data["last_lastmonth"] = "";
        $data["this_year"] = "";
        $data["last_year"] = "";

        if (count($data['ds']) > 0) {
            $data['yesterday'] = (new DateTime($data['ds'][0]["res_last_day_from"]))->format('d.m.Y');
            $data['last_30days_from'] = (new DateTime($data['ds'][0]["res_last_30days_from"]))->format('d.m.Y');
            $data['last_month'] = Time::createFromFormat('Y-m-d H:i:s', $data['ds'][0]["res_last_month_from"])->toLocalizedString('MMMM yyyy');
            $data["last_lastmonth"] = Time::createFromFormat('Y-m-d H:i:s', $data['ds'][0]["res_last_lastmonth_from"])->toLocalizedString('MMMM yyyy');
            $data["this_year"] = (new DateTime($data['ds'][0]["res_this_year_to"]))->format('d.m.Y');
            $data["last_year"] = (new DateTime($data['ds'][0]["res_last_year_from"]))->format('Y');
        } 

        $data['basins'] = $model_basin->getEntriesAvg();
		
		$data['geoserver_wms_url'] = $config->geoserver_wms_url;
		$data['geoserver_wfs_url'] = $config->geoserver_wfs_url;

        return view('templates/header', $data)
            . view('templates/menu')
            . view('hydrodash/overview/gw')
            . view('templates/footer');
    }

    public function springs()
    {   
        $config = new \Config\Site();

        $data['title'] = 'Quellen';

        $model_menu = model(MenuModel::class); 
        $model_ds = model(HydrodashMvSpringsModel::class);
        $model_basin = model(HydrodashMvSpringsBasinModel::class);

        $data['ds'] = $model_ds->getEntries();
        $data['menu'] = $model_menu->getMenu('Quellen');
        $data['sub'] = 'springs';

        $data['yesterday'] = "";
        $data['last_30days_from'] = "";
        $data['last_month'] = "";
        $data["last_lastmonth"] = "";
        $data["this_year"] = "";
        $data["last_year"] = "";

        if (count($data['ds']) > 0) {
            $data['yesterday'] = (new DateTime($data['ds'][0]["res_last_day_mean_from"]))->format('d.m.Y');
            $data['last_30days_from'] = (new DateTime($data['ds'][0]["res_last_30days_mean_from"]))->format('d.m.Y');
            $data['last_month'] = Time::createFromFormat('Y-m-d H:i:s', $data['ds'][0]["res_last_month_mean_from"])->toLocalizedString('MMMM yyyy');
            $data["last_lastmonth"] = Time::createFromFormat('Y-m-d H:i:s', $data['ds'][0]["res_last_lastmonth_mean_from"])->toLocalizedString('MMMM yyyy');
            $data["this_year"] = (new DateTime($data['ds'][0]["res_this_year_mean_to"]))->format('d.m.Y');
            $data["last_year"] = (new DateTime($data['ds'][0]["res_last_year_mean_from"]))->format('Y');
        } 

        $data['basins'] = $model_basin->getEntriesAvg();

		$data['geoserver_wms_url'] = $config->geoserver_wms_url;
		$data['geoserver_wfs_url'] = $config->geoserver_wfs_url;

        return view('templates/header', $data)
            . view('templates/menu')
            . view('hydrodash/overview/springs')
            . view('templates/footer');
    }

    public function discharge_station(?int $id = -1)
    {   
        $model_menu = model(MenuModel::class); 
        $model_info = model(HydrodashDsInfoModel::class);
        $model_geo = model(HydrodashDsGeoModel::class); 
        $model_ts = model(HydrodashTsModel::class);
        $model_tscat = model(HydrodashTsCatModel::class); 
        $model_tslog = model(HydrodashTsLogModel::class); 
        $model_kenn = model(HydrodashDsStatModel::class); 
        $model_res = model(HydrodashDsResModel::class); 
        $model_ds = model(HydrodashDsModel::class);

        $data['menu'] = $model_menu->getMenu('Abfluss');
        $data['backurl'] = '';

        // Get Metadata

        $data["info"] = $model_info->getInfo($id);
        $data["title"] = 'Abfluss ' . $data["info"]['name'];
        $data["ds_id"] = $id;

        // Get Categories

        $year = date('Y');
        $last_year = $year-1;

        $data["this_year"] = $year;
        $data["last_year"] = $year-1;

        $data["lt_comment"] = $model_tslog->getTsLogWithName($id, 'lt_webapp');
        $data["coord"] = $model_geo->getCoord($id);

        // Kennwerte

        $data["kenn"]['nqt'] = "-";
        $data["kenn"]['mjnq'] = "-";
        $data["kenn"]['mq'] = "-";
        $data["kenn"]['hq1'] = "-";
        $data["kenn"]['hq5'] = "-";
        $data["kenn"]['hq10'] = "-";
        $data["kenn"]['hq30'] = "-";
        $data["kenn"]['hq100'] = "-";
        $data["kenn"]['hq300'] = "-";
        $data["kenn"]['rhhq'] = "-";

        $kenn = $model_kenn->getKenn($id);

        foreach ($kenn as $k) {
            if ($k["name"] == "NQT"){
                $data["kenn"]['nqt'] = $k["val"];
            } elseif ($k["name"] == "MJNQ"){
                $data["kenn"]['mjnq'] = $k["val"];
            } elseif ($k["name"] == "MQ"){
                $data["kenn"]['mq'] = $k["val"];
            } elseif ($k["name"] == "HQ1"){
                $data["kenn"]['hq1'] = $k["val"];
            } elseif ($k["name"] == "HQ5"){
                $data["kenn"]['hq5'] = $k["val"];
            } elseif ($k["name"] == "HQ10"){
                $data["kenn"]['hq10'] = $k["val"];
            } elseif ($k["name"] == "HQ30"){
                $data["kenn"]['hq30'] = $k["val"];
            } elseif ($k["name"] == "HQ100"){
                $data["kenn"]['hq100'] = $k["val"];
            } elseif ($k["name"] == "HQ300"){
                $data["kenn"]['hq300'] = $k["val"];
            } elseif ($k["name"] == "RHHQ"){
                $data["kenn"]['rhhq'] = $k["val"];
            } 
        } 

        // Results

        $res = $model_res->getResultsForDs($id);

        $a1 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a2 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a3 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a4 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a5 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a6 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");

        $data["last_lastmonth_str"] = "NA";
        $data["last_month_str"] = "NA";

        foreach ($res as $r) {
            if ($r["name"] == "last_day_mean") {
                $a1 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_30days_mean") {
                $a2 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_lastmonth_mean") {
                $a3 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
                $data["last_lastmonth_str"] = Time::createFromFormat('Y-m-d H:i:s', $r["valid_from"])->toLocalizedString('MMMM yyyy');
            } elseif ($r["name"] == "last_month_mean") {
                $a4 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
                $data["last_month_str"] = Time::createFromFormat('Y-m-d H:i:s', $r["valid_from"])->toLocalizedString('MMMM yyyy');
            } elseif ($r["name"] == "this_year_mean") {
                $a5 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_year_mean") {
                $a6 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            }
        }

        $data["a1"] = $a1; 
        $data["a2"] = $a2; 
        $data["a3"] = $a3; 
        $data["a4"] = $a4; 
        $data["a5"] = $a5; 
        $data["a6"] = $a6; 

        $catch = $model_ds->getDatastreamCatchment($id);
        $data["ds_comment"] = $catch['comment'];

        if (!is_null($catch)) {
            $data["catchment_name"] = $model_ds->getDatastreamCatchment($id)["catchment_name"] ; 
        } else {
            $data["catchment_name"] = "-";
        }

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/sidebar')
            . view('hydrodash/station/discharge')
            . view('hydrodash/station/map')
            . view('templates/footer');
    }

    public function watertemp_station(?int $id = -1)
    {   
        $model_menu = model(MenuModel::class); 
        $model_info = model(HydrodashDsInfoModel::class);
        $model_geo = model(HydrodashDsGeoModel::class); 
        $model_ts = model(HydrodashTsModel::class);
        $model_tscat = model(HydrodashTsCatModel::class); 
        $model_tslog = model(HydrodashTsLogModel::class); 
        $model_res = model(HydrodashDsResModel::class); 
        $model_ds = model(HydrodashDsModel::class);

        $data['menu'] = $model_menu->getMenu('Wassertemperatur');
        $data['backurl'] = '';

        // Get Metadata

        $data["info"] = $model_info->getInfo($id);
        $data["title"] = 'Wassertemperatur ' . $data["info"]['name'];
        $data["ds_id"] = $id;

        // Get Categories

        $year = date('Y');
        $last_year = $year-1;

        $data["this_year"] = $year;
        $data["last_year"] = $year-1;

        $data["lt_comment"] = $model_tslog->getTsLogWithName($id, 'lt_webapp');
        $data["coord"] = $model_geo->getCoord($id);

        // Results

        $res = $model_res->getResultsForDs($id);

        $a1 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a2 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a3 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a4 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a5 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a6 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        
        $data["last_lastmonth_str"] = "NA";
        $data["last_month_str"] = "NA";

        foreach ($res as $r) {
            if ($r["name"] == "last_day_mean") {
                $a1 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_30days_mean") {
                $a2 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_lastmonth_mean") {
                $a3 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
                $data["last_lastmonth_str"] = Time::createFromFormat('Y-m-d H:i:s', $r["valid_from"])->toLocalizedString('MMMM yyyy');
            } elseif ($r["name"] == "last_month_mean") {
                $a4 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
                $data["last_month_str"] = Time::createFromFormat('Y-m-d H:i:s', $r["valid_from"])->toLocalizedString('MMMM yyyy');
            } elseif ($r["name"] == "this_year_mean") {
                $a5 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_year_mean") {
                $a6 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            }
        }

        $data["a1"] = $a1; 
        $data["a2"] = $a2; 
        $data["a3"] = $a3; 
        $data["a4"] = $a4; 
        $data["a5"] = $a5; 
        $data["a6"] = $a6; 

        $catch = $model_ds->getDatastreamCatchment($id);
        $data["ds_comment"] = $catch['comment'];

        if (!is_null($catch)) {
            $data["catchment_name"] = $model_ds->getDatastreamCatchment($id)["catchment_name"] ; 
        } else {
            $data["catchment_name"] = "-";
        }

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/sidebar')
            . view('hydrodash/station/watertemp')
            . view('hydrodash/station/map')
            . view('templates/footer');
    }

    public function precip_station(?int $id = -1)
    {   
        $model_menu = model(MenuModel::class); 
        $model_info = model(HydrodashDsInfoModel::class);
        $model_geo = model(HydrodashDsGeoModel::class); 
        $model_ts = model(HydrodashTsModel::class);
        $model_tscat = model(HydrodashTsCatModel::class); 
        $model_tslog = model(HydrodashTsLogModel::class); 
        $model_res = model(HydrodashDsResModel::class); 
        $model_ds = model(HydrodashDsModel::class);

        $data['menu'] = $model_menu->getMenu('Niederschlag');
        $data['backurl'] = '';

        // Get Metadata

        $data["info"] = $model_info->getInfo($id);
        $data["title"] = 'Niederschlag ' . $data["info"]['name'];
        $data["ds_id"] = $id;

        // Get Categories

        $year = date('Y');
        $last_year = $year-1;

        $data["this_year"] = $year;
        $data["last_year"] = $year-1;

        $data["lt_comment"] = $model_tslog->getTsLogWithName($id, 'lt_webapp');
        $data["coord"] = $model_geo->getCoord($id);

        // Results

        $res = $model_res->getResultsForDs($id);

        $a1 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a2 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a3 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a4 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a5 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        
        $data["last_lastmonth_str"] = "NA";
        $data["last_month_str"] = "NA";

        foreach ($res as $r) {
            if ($r["name"] == "last_30days_sum") {
                $a1 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_lastmonth_sum") {
                $a2 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
                $data["last_lastmonth_str"] = Time::createFromFormat('Y-m-d H:i:s', $r["valid_from"])->toLocalizedString('MMMM yyyy');
            } elseif ($r["name"] == "last_month_sum") {
                $a3 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
                $data["last_month_str"] = Time::createFromFormat('Y-m-d H:i:s', $r["valid_from"])->toLocalizedString('MMMM yyyy');
            } elseif ($r["name"] == "this_year_sum") {
                $a4 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_year_sum") {
                $a5 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            }
        }

        $data["a1"] = $a1;
        $data["a2"] = $a2;
        $data["a3"] = $a3;
        $data["a4"] = $a4;
        $data["a5"] = $a5;

        $catch = $model_ds->getDatastreamCatchment($id);
        $data["ds_comment"] = $catch['comment'];

        if (!is_null($catch)) {
            $data["catchment_name"] = $model_ds->getDatastreamCatchment($id)["catchment_name"] ; 
        } else {
            $data["catchment_name"] = "-";
        }

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/sidebar')
            . view('hydrodash/station/precip')
            . view('hydrodash/station/map')
            . view('templates/footer');
    }

    public function airtemp_station(?int $id = -1)
    {   
        $model_menu = model(MenuModel::class); 
        $model_info = model(HydrodashDsInfoModel::class);
        $model_geo = model(HydrodashDsGeoModel::class); 
        $model_ts = model(HydrodashTsModel::class);
        $model_tscat = model(HydrodashTsCatModel::class); 
        $model_tslog = model(HydrodashTsLogModel::class); 
        $model_res = model(HydrodashDsResModel::class); 
        $model_ds = model(HydrodashDsModel::class);

        $data['menu'] = $model_menu->getMenu('Lufttemperatur');
        $data['backurl'] = '';

        // Get Metadata

        $data["info"] = $model_info->getInfo($id);
        $data["title"] = 'Lufttemperatur ' . $data["info"]['name'];
        $data["ds_id"] = $id;

        // Get Categories

        $year = date('Y');
        $last_year = $year-1;

        $data["this_year"] = $year;
        $data["last_year"] = $year-1;

        $data["lt_comment"] = $model_tslog->getTsLogWithName($id, 'lt_webapp');
        $data["coord"] = $model_geo->getCoord($id);

        $data["this_year_heat_days"] = $model_tslog->getTsLogWithName($id, 'this_year_heat_days');
        $data["last_year_heat_days"] = $model_tslog->getTsLogWithName($id, 'last_year_heat_days');
        $data["this_year_tropic_days"] = $model_tslog->getTsLogWithName($id, 'this_year_tropic_days');
        $data["last_year_tropic_days"] = $model_tslog->getTsLogWithName($id, 'last_year_tropic_days');
        $data["this_saison_frost_days"] = $model_tslog->getTsLogWithName($id, 'this_saison_frost_days');
        $data["last_saison_frost_days"] = $model_tslog->getTsLogWithName($id, 'last_saison_frost_days');
        $data["this_saison_ice_days"] = $model_tslog->getTsLogWithName($id, 'this_saison_ice_days');
        $data["last_saison_ice_days"] = $model_tslog->getTsLogWithName($id, 'last_saison_ice_days');

        // Results

        $res = $model_res->getResultsForDs($id);

        $a1 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a2 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a3 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a4 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a5 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a6 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        
        $data["last_lastmonth_str"] = "NA";
        $data["last_month_str"] = "NA";

        foreach ($res as $r) {
            if ($r["name"] == "last_day_mean") {
                $a1 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_30days_mean") {
                $a2 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_lastmonth_mean") {
                $a3 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
                $data["last_lastmonth_str"] = Time::createFromFormat('Y-m-d H:i:s', $r["valid_from"])->toLocalizedString('MMMM yyyy');
            } elseif ($r["name"] == "last_month_mean") {
                $a4 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
                $data["last_month_str"] = Time::createFromFormat('Y-m-d H:i:s', $r["valid_from"])->toLocalizedString('MMMM yyyy');
            } elseif ($r["name"] == "this_year_mean") {
                $a5 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_year_mean") {
                $a6 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            }
        }

        $data["a1"] = $a1; 
        $data["a2"] = $a2; 
        $data["a3"] = $a3; 
        $data["a4"] = $a4; 
        $data["a5"] = $a5; 
        $data["a6"] = $a6; 

        $catch = $model_ds->getDatastreamCatchment($id);
        $data["ds_comment"] = $catch['comment'];

        if (!is_null($catch)) {
            $data["catchment_name"] = $model_ds->getDatastreamCatchment($id)["catchment_name"] ; 
        } else {
            $data["catchment_name"] = "-";
        }

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/sidebar')
            . view('hydrodash/station/airtemp')
            . view('hydrodash/station/map')
            . view('templates/footer');
    }

    public function gw_station(?int $id = -1)
    {   
        $model_menu = model(MenuModel::class); 
        $model_info = model(HydrodashDsInfoModel::class);
        $model_geo = model(HydrodashDsGeoModel::class); 
        $model_ts = model(HydrodashTsModel::class);
        $model_tscat = model(HydrodashTsCatModel::class); 
        $model_tslog = model(HydrodashTsLogModel::class); 
        $model_res = model(HydrodashDsResModel::class); 
        $model_ds = model(HydrodashDsModel::class);

        $data['menu'] = $model_menu->getMenu('Grundwasser');
        $data['backurl'] = '';

        // Get Metadata

        $data["info"] = $model_info->getInfo($id);
        $data["title"] = 'Grundwasser ' . $data["info"]['name'];
        $data["ds_id"] = $id;

        // Get Categories

        $year = date('Y');
        $last_year = $year-1;

        $data["this_year"] = $year;
        $data["last_year"] = $year-1;

        $data["lt_comment"] = $model_tslog->getTsLogWithName($id, 'lt_webapp');
        $data["coord"] = $model_geo->getCoord($id);

        // Results

        $res = $model_res->getResultsForDs($id);

        $a1 = array("val"=>0, "val_lt_min"=>0, "val_lt"=>0, "val_lt_max"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a2 = array("val"=>0, "val_lt_min"=>0, "val_lt"=>0, "val_lt_max"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a3 = array("val"=>0, "val_lt_min"=>0, "val_lt"=>0, "val_lt_max"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a4 = array("val"=>0, "val_lt_min"=>0, "val_lt"=>0, "val_lt_max"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a5 = array("val"=>0, "val_lt_min"=>0, "val_lt"=>0, "val_lt_max"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a6 = array("val"=>0, "val_lt_min"=>0, "val_lt"=>0, "val_lt_max"=>0, "from"=>"", "to"=>"", "last_operation"=>"");

        $data["last_lastmonth_str"] = "NA";
        $data["last_month_str"] = "NA";

        foreach ($res as $r) {
            if ($r["name"] == "last_day_mean") {
                $a1 = array("val"=>$r["val"], "val_lt_min"=>$r["val_lt_min"], "val_lt"=>$r["val_lt"], "val_lt_max"=>$r["val_lt_max"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_30days_mean") {
                $a2 = array("val"=>$r["val"], "val_lt_min"=>$r["val_lt_min"], "val_lt"=>$r["val_lt"], "val_lt_max"=>$r["val_lt_max"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_lastmonth_mean") {
                $a3 = array("val"=>$r["val"], "val_lt_min"=>$r["val_lt_min"], "val_lt"=>$r["val_lt"], "val_lt_max"=>$r["val_lt_max"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
                $data["last_lastmonth_str"] = Time::createFromFormat('Y-m-d H:i:s', $r["valid_from"])->toLocalizedString('MMMM yyyy');
            } elseif ($r["name"] == "last_month_mean") {
                $a4 = array("val"=>$r["val"], "val_lt_min"=>$r["val_lt_min"], "val_lt"=>$r["val_lt"], "val_lt_max"=>$r["val_lt_max"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
                $data["last_month_str"] = Time::createFromFormat('Y-m-d H:i:s', $r["valid_from"])->toLocalizedString('MMMM yyyy');
            } elseif ($r["name"] == "this_year_mean") {
                $a5 = array("val"=>$r["val"], "val_lt_min"=>$r["val_lt_min"], "val_lt"=>$r["val_lt"], "val_lt_max"=>$r["val_lt_max"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_year_mean") {
                $a6 = array("val"=>$r["val"], "val_lt_min"=>$r["val_lt_min"], "val_lt"=>$r["val_lt"], "val_lt_max"=>$r["val_lt_max"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            }
        }

        $data["a1"] = $a1; 
        $data["a2"] = $a2; 
        $data["a3"] = $a3; 
        $data["a4"] = $a4; 
        $data["a5"] = $a5; 
        $data["a6"] = $a6; 

        $catch = $model_ds->getDatastreamCatchment($id);
        $data["ds_comment"] = $catch['comment'];

        if (!is_null($catch)) {
            $data["catchment_name"] = $model_ds->getDatastreamCatchment($id)["catchment_name"] ; 
        } else {
            $data["catchment_name"] = "-";
        }

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/sidebar')
            . view('hydrodash/station/gw')
            . view('hydrodash/station/map')
            . view('templates/footer');
    }

    public function springs_station(?int $id = -1)
    {   
        $model_menu = model(MenuModel::class); 
        $model_info = model(HydrodashDsInfoModel::class);
        $model_geo = model(HydrodashDsGeoModel::class); 
        $model_ts = model(HydrodashTsModel::class);
        $model_tscat = model(HydrodashTsCatModel::class); 
        $model_tslog = model(HydrodashTsLogModel::class); 
        $model_res = model(HydrodashDsResModel::class); 
        $model_ds = model(HydrodashDsModel::class);

        $data['menu'] = $model_menu->getMenu('Quellen');
        $data['backurl'] = '';

        // Get Metadata

        $data["info"] = $model_info->getInfo($id);
        $data["title"] = 'Quelle ' . $data["info"]['name'];
        $data["ds_id"] = $id;

        // Get Categories

        $year = date('Y');
        $last_year = $year-1;

        $data["this_year"] = $year;
        $data["last_year"] = $year-1;

        $data["lt_comment"] = $model_tslog->getTsLogWithName($id, 'lt_webapp');
        $data["coord"] = $model_geo->getCoord($id);

        // Results

        $res = $model_res->getResultsForDs($id);

        $a1 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a2 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a3 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a4 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a5 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");
        $a6 = array("val"=>0, "val_lt"=>0, "from"=>"", "to"=>"", "last_operation"=>"");

        $data["last_lastmonth_str"] = "NA";
        $data["last_month_str"] = "NA";

        foreach ($res as $r) {
            if ($r["name"] == "last_day_mean") {
                $a1 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_30days_mean") {
                $a2 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_lastmonth_mean") {
                $a3 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
                $data["last_lastmonth_str"] = Time::createFromFormat('Y-m-d H:i:s', $r["valid_from"])->toLocalizedString('MMMM yyyy');
            } elseif ($r["name"] == "last_month_mean") {
                $a4 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
                $data["last_month_str"] = Time::createFromFormat('Y-m-d H:i:s', $r["valid_from"])->toLocalizedString('MMMM yyyy');
            } elseif ($r["name"] == "this_year_mean") {
                $a5 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            } elseif ($r["name"] == "last_year_mean") {
                $a6 = array("val"=>$r["val"], "val_lt"=>$r["val_lt"], "from"=>$r["valid_from"], "to"=>$r["valid_to"], "timestamp"=>$r["last_modified_at"]);
            }
        }

        $data["a1"] = $a1; 
        $data["a2"] = $a2; 
        $data["a3"] = $a3; 
        $data["a4"] = $a4; 
        $data["a5"] = $a5; 
        $data["a6"] = $a6; 

        $catch = $model_ds->getDatastreamCatchment($id);
        $data["ds_comment"] = $catch['comment'];

        if (!is_null($catch)) {
            $data["catchment_name"] = $model_ds->getDatastreamCatchment($id)["catchment_name"] ; 
        } else {
            $data["catchment_name"] = "-";
        }

        return view('templates/header', $data)
            . view('templates/menu')
            . view('templates/sidebar')
            . view('hydrodash/station/springs')
            . view('hydrodash/station/map')
            . view('templates/footer');
    }

    public function discharge_chart(?int $id = -1)
    {   
        helper('text'); 

        $model_ts = model(HydrodashTsModel::class);
        $model_tscat = model(HydrodashTsCatModel::class); 
        $model_res = model(HydrodashDsResModel::class); 
        $model_tslog = model(HydrodashTsLogModel::class); 

        //
        // Get Categories
        //

        $ts_cat = $model_tscat->getCat();

        $cat_live = -1;
        $cat_min = -1;
        $cat_mean = -1;
        $cat_max = -1;

        foreach($ts_cat as $c) {
            if ($c['name_short'] == 'live') {
                $cat_live = $c['id'];
            } elseif ($c['name_short'] == 'lt_min') { 
                $cat_min = $c['id'];
            } elseif ($c['name_short'] == 'lt_mean') { 
                $cat_mean = $c['id'];
            } elseif ($c['name_short'] == 'lt_max') { 
                $cat_max = $c['id'];
            } 
        } 

        //
        // Prepare operation
        // 

        $tz_utc = new DateTimeZone('UTC');

        $year = date('Y');
        $last_year = $year-1;

        $leap_year = $year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0);
        $leap_last_year = $last_year % 4 == 0 && ($last_year % 100 != 0 || $last_year % 400 == 0);

        $timestamps = [];
        $ts_min = [];
        $ts_mean = [];
        $ts_max = [];
        $ts_ty = [];
        $ts_ly = [];
        $ts_ty_last = [];

        // Array epoch times

        $beg_epoch = mktime(0,0,0,1,1,$year);
        $end_epoch = mktime(1,0,0,1,1,$year+1);
        $ly_start_epoch = mktime(0,0,0,1,1,$year-1);

        $beg = new DateTime(date(DATE_ATOM, $beg_epoch), $tz_utc);
        $end = new DateTime(date(DATE_ATOM, $end_epoch), $tz_utc);
        
        $range = new DatePeriod($beg, new DateInterval('P1D'), $end);

        foreach ($range as $dt) {
            array_push($timestamps, $dt->getTimestamp());
        }

        $epoch_leap1_2020 = mktime(0,0,0,2,29,2020);
        $epoch_leap2_2020 = mktime(0,0,0,3,1,2020);

        $epoch_leap1_ly = mktime(0,0,0,2,29,$last_year);
        $epoch_leap2_ly = mktime(0,0,0,3,1,$last_year);

        $epoch_leap1_ty = mktime(0,0,0,2,29,$year);
        $epoch_leap2_ty = mktime(0,0,0,3,1,$year);

        // Array data

        $ts = $model_ts->getTs($id);

        $last_min = 0;
        $last_mean = 0;
        $last_max = 0;
        $last_ty = 0;
        $last_ly = 0;

        $last_min_val = 0;
        $last_mean_val = 0;
        $last_max_val = 0;
        $last_ly_val = 0;
        $last_ty_val = 0;

        $first_ty = true;
        $first_ty_val = 0;
        $first_ty_dt = 0;
        $first_ly = true;
        $first_ly_val = 0;
        $first_ly_dt = 0;

        $first_min = true;
        $first_min_val = 0;
        $first_mean = true;
        $first_mean_val = 0;
        $first_max = true;
        $first_max_val = 0;

        $now = time();

        foreach ($ts as $t) {
            if (!is_numeric($t['val'])) {
                continue;
            } 

            // Skip 29.02. if no leap year

            if (!$leap_year && ($t['dt_epoch'] == $epoch_leap1_2020 || ($leap_last_year && $t['dt_epoch'] == $epoch_leap1_ly))) {
                continue;
            }

            if ($t['cat_id'] == $cat_max) {
                
                //
                // Long-term Max
                //

                if ($first_max) {
                    $first_max_val = floatval($t['val']);
                    $first_max = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_max != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_max) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_max)/86400)-1; $x++){
                        array_push($ts_max, null);  
                    } 
                } 

                array_push($ts_max, floatval($t['val']));

                $last_max_val = floatval($t['val']);
                $last_max = $t['dt_epoch'];
            } elseif ($t['cat_id'] == $cat_mean) {

                //
                // Long-term Mean
                //

                if ($first_mean) {
                    $first_mean_val = floatval($t['val']);
                    $first_mean = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_mean != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_mean) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_mean)/86400)-1; $x++){
                        array_push($ts_mean, null);  
                    } 
                } 

                array_push($ts_mean, floatval($t['val']));

                $last_mean_val = floatval($t['val']);
                $last_mean = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_min) {

                //
                // Long-term Min
                //


                if ($first_min) {
                    $first_min_val = floatval($t['val']);
                    $first_min = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_min != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_min) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_min)/86400)-1; $x++){
                        array_push($ts_mean, null);  
                    } 
                } 

                array_push($ts_min, floatval($t['val']));

                $last_min_val = floatval($t['val']);
                $last_min = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_live && $t['dt_epoch'] >= $ly_start_epoch && $t['dt_epoch'] < $beg_epoch) {

                //
                // Last-year data
                //

                if ($first_ly) {
                    $first_ly_val = floatval($t['val']);
                    $first_ly_dt = $t ['dt_epoch'];
                    $first_ly = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_ly != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_ly) && ($t['dt_epoch'] - $last_ly) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_ly)/86400)-1; $x++){
                        array_push($ts_ly, null);  
                    } 
                } 

                array_push($ts_ly, floatval($t['val']));

                $last_ly_val = floatval($t['val']);
                $last_ly = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_live && $t['dt_epoch'] >= $beg_epoch) {                
                
                //
                // This-year data
                //

                if ($first_ty) {
                    $first_ty_val = floatval($t['val']);
                    $first_ty_dt = $t ['dt_epoch'];
                    $first_ty = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_ty != 0 && ($t['dt_epoch'] - $last_ty) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_ty)/86400)-1; $x++){
                        array_push($ts_ty, null);  
                        array_push($ts_ty_last, null); // Point at last value in uplot
                    }
                }

                if ($t['dt_epoch'] < $now) { 
                    array_push($ts_ty, floatval($t['val']));
                    array_push($ts_ty_last, null); // Point at last value in uplot

                    $last_ty_val = floatval($t['val']); 
                    $last_ty = $t['dt_epoch']; 
                }
            }
        }

        array_push($ts_min, $first_min_val);
        array_push($ts_mean, $first_mean_val);
        array_push($ts_max, $first_max_val);
        array_push($ts_ly, $first_ty_val);
        array_push($ts_ty, null);
        array_pop($ts_ty_last);
        array_push($ts_ty_last, $last_ty_val, null);

        // If nec. fill nulls at beginning

        if (($first_ly_dt - $ly_start_epoch) >= 172800) {
            for ($x = 1; $x <= intval(($first_ly_dt - $ly_start_epoch)/86400)-1; $x++){
                array_unshift($ts_ly, null);  
            }
        }

        if (($first_ty_dt - $beg_epoch) >= 172800) {
            for ($x = 1; $x <= intval(($first_ty_dt - $beg_epoch)/86400)-1; $x++){
                array_unshift($ts_ty, null);
                array_unshift($ts_ty_last, null);
            }
        }

        $data["ts"] = $timestamps;
        $data["ts_min"] =  $ts_min; 
        $data["ts_mean"] =  $ts_mean;
        $data["ts_max"] =  $ts_max;
        $data["ts_ly"] =  $ts_ly;
        $data["ts_ty"] =  $ts_ty;
        $data["ts_ty_last"] =  $ts_ty_last;

        //
        // Results
        //

        $res = $model_res->getResultsForDs($id);

        $a1 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a2 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a3 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a4 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a5 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a6 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 

        foreach ($res as $r) {
            if ($r["name"] == "last_day_mean") {
                $a1 = get_col_station_discharge($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_30days_mean") {
                $a2 = get_col_station_discharge($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_lastmonth_mean") {
                $a3 = get_col_station_discharge($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_month_mean") {
                $a4 = get_col_station_discharge($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "this_year_mean") {
                $a5 = get_col_station_discharge($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_year_mean") {
                $a6 = get_col_station_discharge($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            }
        }

        $data["analysis_1"] = $a1; 
        $data["analysis_2"] = $a2; 
        $data["analysis_3"] = $a3; 
        $data["analysis_4"] = $a4; 
        $data["analysis_5"] = $a5;
        $data["analysis_6"] = $a6;
        
        $in_tz = new DateTimeZone('UTC');
        $out_tz = new DateTimeZone('Europe/Vienna');

        $data["lt_comment"] = $model_tslog->getTsLogWithName($id, 'lt_webapp')['comment'];
        $data["last_modified"] = convertTimezone($model_tslog->getTsLogWithName($id, 'lt_webapp')['last_modified_at'], $in_tz, $out_tz, 'd.m.Y H:i:s');

        return $this->response->setJSON($data);
    }

    public function watertemp_chart(?int $id = -1)
    {   
        helper('text'); 

        $model_ts = model(HydrodashTsModel::class);
        $model_tscat = model(HydrodashTsCatModel::class); 
        $model_res = model(HydrodashDsResModel::class); 
        $model_tslog = model(HydrodashTsLogModel::class); 

        //
        // Get Categories
        //

        $ts_cat = $model_tscat->getCat();

        $cat_live = -1;
        $cat_min = -1;
        $cat_mean = -1;
        $cat_max = -1;

        foreach($ts_cat as $c) {
            if ($c['name_short'] == 'live') {
                $cat_live = $c['id'];
            } elseif ($c['name_short'] == 'lt_min') { 
                $cat_min = $c['id'];
            } elseif ($c['name_short'] == 'lt_mean') { 
                $cat_mean = $c['id'];
            } elseif ($c['name_short'] == 'lt_max') { 
                $cat_max = $c['id'];
            } 
        } 

        //
        // Prepare operation
        // 

        $tz_utc = new DateTimeZone('UTC');

        $year = date('Y');
        $last_year = $year-1;

        $leap_year = $year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0);
        $leap_last_year = $last_year % 4 == 0 && ($last_year % 100 != 0 || $last_year % 400 == 0);

        $timestamps = [];
        $ts_min = [];
        $ts_mean = [];
        $ts_max = [];
        $ts_ty = [];
        $ts_ly = [];
        $ts_ty_last = [];

        // Array epoch times

        $beg_epoch = mktime(0,0,0,1,1,$year);
        $end_epoch = mktime(1,0,0,1,1,$year+1);
        $ly_start_epoch = mktime(0,0,0,1,1,$year-1);

        $beg = new DateTime(date(DATE_ATOM, $beg_epoch), $tz_utc);
        $end = new DateTime(date(DATE_ATOM, $end_epoch), $tz_utc);
        
        $range = new DatePeriod($beg, new DateInterval('P1D'), $end);

        foreach ($range as $dt) {
            array_push($timestamps, $dt->getTimestamp());
        }

        $epoch_leap1_2020 = mktime(0,0,0,2,29,2020);
        $epoch_leap2_2020 = mktime(0,0,0,3,1,2020);

        $epoch_leap1_ly = mktime(0,0,0,2,29,$last_year);
        $epoch_leap2_ly = mktime(0,0,0,3,1,$last_year);

        $epoch_leap1_ty = mktime(0,0,0,2,29,$year);
        $epoch_leap2_ty = mktime(0,0,0,3,1,$year);

        // Array data

        $ts = $model_ts->getTs($id);

        $last_min = 0;
        $last_mean = 0;
        $last_max = 0;
        $last_ty = 0;
        $last_ly = 0;

        $last_min_val = 0;
        $last_mean_val = 0;
        $last_max_val = 0;
        $last_ly_val = 0;
        $last_ty_val = 0;

        $first_ty = true;
        $first_ty_val = 0;
        $first_ty_dt = 0;
        $first_ly = true;
        $first_ly_val = 0;
        $first_ly_dt = 0;

        $first_min = true;
        $first_min_val = 0;
        $first_mean = true;
        $first_mean_val = 0;
        $first_max = true;
        $first_max_val = 0;

        $now = time();

        foreach ($ts as $t) {
            if (!is_numeric($t['val'])) {
                continue;
            } 

            // Skip 29.02. if no leap year

            if (!$leap_year && ($t['dt_epoch'] == $epoch_leap1_2020 || ($leap_last_year && $t['dt_epoch'] == $epoch_leap1_ly))) {
                continue;
            }

            if ($t['cat_id'] == $cat_max) {
                
                //
                // Long-term Max
                //

                if ($first_max) {
                    $first_max_val = floatval($t['val']);
                    $first_max = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_max != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_max) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_max)/86400)-1; $x++){
                        array_push($ts_max, null);  
                    } 
                } 

                array_push($ts_max, floatval($t['val']));

                $last_max_val = floatval($t['val']);
                $last_max = $t['dt_epoch'];
            } elseif ($t['cat_id'] == $cat_mean) {

                //
                // Long-term Mean
                //

                if ($first_mean) {
                    $first_mean_val = floatval($t['val']);
                    $first_mean = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_mean != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_mean) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_mean)/86400)-1; $x++){
                        array_push($ts_mean, null);  
                    } 
                } 

                array_push($ts_mean, floatval($t['val']));

                $last_mean_val = floatval($t['val']);
                $last_mean = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_min) {

                //
                // Long-term Min
                //


                if ($first_min) {
                    $first_min_val = floatval($t['val']);
                    $first_min = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_min != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_min) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_min)/86400)-1; $x++){
                        array_push($ts_mean, null);  
                    } 
                } 

                array_push($ts_min, floatval($t['val']));

                $last_min_val = floatval($t['val']);
                $last_min = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_live && $t['dt_epoch'] >= $ly_start_epoch && $t['dt_epoch'] < $beg_epoch) {

                //
                // Last-year data
                //

                if ($first_ly) {
                    $first_ly_val = floatval($t['val']);
                    $first_ly_dt = $t ['dt_epoch'];
                    $first_ly = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_ly != 0 && ($t['dt_epoch'] != $epoch_leap2_ly) && ($t['dt_epoch'] - $last_ly) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_ly)/86400)-1; $x++){
                        array_push($ts_ly, null);  
                    } 
                } 

                array_push($ts_ly, floatval($t['val']));

                $last_ly_val = floatval($t['val']);
                $last_ly = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_live && $t['dt_epoch'] >= $beg_epoch) {                
                
                //
                // This-year data
                //

                if ($first_ty) {
                    $first_ty_val = floatval($t['val']);
                    $first_ty_dt = $t ['dt_epoch'];
                    $first_ty = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_ty != 0 && ($t['dt_epoch'] - $last_ty) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_ty)/86400)-1; $x++){
                        array_push($ts_ty, null);  
                        array_push($ts_ty_last, null); // Point at last value in uplot
                    }
                }

                if ($t['dt_epoch'] < $now) { 
                    array_push($ts_ty, floatval($t['val']));
                    array_push($ts_ty_last, null); // Point at last value in uplot

                    $last_ty_val = floatval($t['val']); 
                    $last_ty = $t['dt_epoch']; 
                }
            }
        }

        array_push($ts_min, $first_min_val);
        array_push($ts_mean, $first_mean_val);
        array_push($ts_max, $first_max_val);
        array_push($ts_ly, $first_ty_val);
        array_push($ts_ty, null);
        array_pop($ts_ty_last);
        array_push($ts_ty_last, $last_ty_val, null);

        // If nec. fill nulls at beginning

        if (($first_ly_dt - $ly_start_epoch) >= 172800) {
            for ($x = 1; $x <= intval(($first_ly_dt - $ly_start_epoch)/86400)-1; $x++){
                array_unshift($ts_ly, null);  
            }
        }

        if (($first_ty_dt - $beg_epoch) >= 172800) {
            for ($x = 1; $x <= intval(($first_ty_dt - $beg_epoch)/86400)-1; $x++){
                array_unshift($ts_ty, null);  
                array_unshift($ts_ty_last, null);
            }
        }

        $data["ts"] = $timestamps;
        $data["ts_min"] = $ts_min; 
        $data["ts_mean"] = $ts_mean;
        $data["ts_max"] = $ts_max;
        $data["ts_ly"] = $ts_ly;
        $data["ts_ty"] = $ts_ty;
        $data["ts_ty_last"] = $ts_ty_last;

        //
        // Results
        //

        $res = $model_res->getResultsForDs($id);

        $a1 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a2 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a3 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a4 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a5 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a6 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 

        foreach ($res as $r) {
            if ($r["name"] == "last_day_mean") {
                $a1 = get_col_station_watertemp($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_30days_mean") {
                $a2 = get_col_station_watertemp($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_lastmonth_mean") {
                $a3 = get_col_station_watertemp($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_month_mean") {
                $a4 = get_col_station_watertemp($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "this_year_mean") {
                $a5 = get_col_station_watertemp($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_year_mean") {
                $a6 = get_col_station_watertemp($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            }
        }

        $data["analysis_1"] = $a1; 
        $data["analysis_2"] = $a2; 
        $data["analysis_3"] = $a3; 
        $data["analysis_4"] = $a4; 
        $data["analysis_5"] = $a5; 
        $data["analysis_6"] = $a6; 

        $in_tz = new DateTimeZone('UTC');
        $out_tz = new DateTimeZone('Europe/Vienna');

        $data["lt_comment"] = $model_tslog->getTsLogWithName($id, 'lt_webapp')['comment'];
        $data["last_modified"] = convertTimezone($model_tslog->getTsLogWithName($id, 'lt_webapp')['last_modified_at'], $in_tz, $out_tz, 'd.m.Y H:i:s');

        return $this->response->setJSON($data);
    }

    public function precip_chart(?int $id = -1)
    {   
        helper('text'); 

        $model_ts = model(HydrodashTsModel::class);
        $model_tscat = model(HydrodashTsCatModel::class); 
        $model_res = model(HydrodashDsResModel::class); 
        $model_tslog = model(HydrodashTsLogModel::class); 

        //
        // Get Categories
        //

        $ts_cat = $model_tscat->getCat();

        $cat_live = -1;
        $cat_min = -1;
        $cat_mean = -1;
        $cat_max = -1;

        foreach($ts_cat as $c) {
            if ($c['name_short'] == 'live') {
                $cat_live = $c['id'];
            } elseif ($c['name_short'] == 'lt_min') { 
                $cat_min = $c['id'];
            } elseif ($c['name_short'] == 'lt_mean') { 
                $cat_mean = $c['id'];
            } elseif ($c['name_short'] == 'lt_max') { 
                $cat_max = $c['id'];
            } 
        } 

        //
        // Prepare operation
        // 

        $tz_utc = new DateTimeZone('UTC');

        $year = date('Y');
        $last_year = $year-1;

        $leap_year = $year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0);
        $leap_last_year = $last_year % 4 == 0 && ($last_year % 100 != 0 || $last_year % 400 == 0);

        $timestamps = [];
        $ts_min = [];
        $ts_mean = [];
        $ts_max = [];
        $ts_ty = [];
        $ts_ly = [];
        $ts_ty_last = [];

        // Array epoch times

        $beg_epoch = mktime(0,0,0,1,1,$year);
        $end_epoch = mktime(1,0,0,1,1,$year+1);
        $ly_start_epoch = mktime(0,0,0,1,1,$year-1);

        $beg = new DateTime(date(DATE_ATOM, $beg_epoch), $tz_utc);
        $end = new DateTime(date(DATE_ATOM, $end_epoch), $tz_utc);
        
        $range = new DatePeriod($beg, new DateInterval('P1D'), $end);

        foreach ($range as $dt) {
            array_push($timestamps, $dt->getTimestamp());
        }

        $epoch_leap1_2020 = mktime(7,0,0,2,29,2020);
        $epoch_leap2_2020 = mktime(7,0,0,3,1,2020);

        $epoch_leap1_ly = mktime(7,0,0,2,29,$last_year);
        $epoch_leap2_ly = mktime(7,0,0,3,1,$last_year);

        $epoch_leap1_ty = mktime(7,0,0,2,29,$year);
        $epoch_leap2_ty = mktime(7,0,0,3,1,$year);

        // Array data

        $ts = $model_ts->getTs($id);

        $last_min = 0;
        $last_mean = 0;
        $last_max = 0;
        $last_ty = 0;
        $last_ly = 0;

        $last_min_val = 0;
        $last_mean_val = 0;
        $last_max_val = 0;
        $last_ly_val = 0;
        $last_ty_val = 0;

        $first_ty = true;
        $first_ty_val = 0;
        $first_ty_dt = 0;
        $first_ly = true;
        $first_ly_val = 0;
        $first_ly_dt = 0;

        $first_min = true;
        $first_min_val = 0;
        $first_mean = true;
        $first_mean_val = 0;
        $first_max = true;
        $first_max_val = 0;

        $now = time() + 3600;

        $cumu_min = 0;
        $cumu_mean = 0;
        $cumu_max = 0;
        $cumu_ly = 0;
        $cumu_ty = 0;

        foreach ($ts as $t) {
            if (!is_numeric($t['val'])) {
                continue;
            } 

            // Skip 29.02. if no leap year

            if (!$leap_year && ($t['dt_epoch'] == $epoch_leap1_2020 || ($leap_last_year && $t['dt_epoch'] == $epoch_leap1_ly))) {
                continue;
            }

            if ($t['cat_id'] == $cat_max) {
                
                //
                // Long-term Max
                //

                if ($first_max) {
                    $first_max_val = floatval($t['val']);
                    $first_max = false;
                    $max_val = 0;
                } else {
                    $max_val = $t['val'];
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_max != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_max) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_max)/86400)-1; $x++){
                        array_push($ts_max, null);  
                    } 
                } 

                $cumu_max += floatval($max_val); 
                array_push($ts_max, $cumu_max);

                $last_max_val = $cumu_max;
                $last_max = $t['dt_epoch'];
            } elseif ($t['cat_id'] == $cat_mean) {

                //
                // Long-term Mean
                //

                if ($first_mean) {
                    $first_mean_val = floatval($t['val']);
                    $first_mean = false;
                    $mean_val = 0;
                } else {
                    $mean_val = $t['val'];
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_mean != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_mean) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_mean)/86400)-1; $x++){
                        array_push($ts_mean, null);  
                    } 
                } 

                $cumu_mean += floatval($mean_val); 
                array_push($ts_mean, $cumu_mean);

                $last_mean_val = $cumu_mean;
                $last_mean = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_min) {

                //
                // Long-term Min
                //


                if ($first_min) {
                    $first_min_val = 0;
                    $first_min = false;
                    $min_val = 0;
                } else {
                    $min_val = $t['val'];
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_min != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_min) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_min)/86400)-1; $x++){
                        array_push($ts_mean, null);  
                    } 
                } 

                $cumu_min += floatval($min_val); 
                array_push($ts_min, $cumu_min);

                $last_min_val = $cumu_min;
                $last_min = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_live && $t['dt_epoch'] >= $ly_start_epoch && $t['dt_epoch'] < $beg_epoch) {

                //
                // Last-year data
                //

                if ($first_ly) {
                    $first_ly_val = 0; //floatval($t['val']);
                    $first_ly_dt = $t ['dt_epoch'];
                    $first_ly = false;
                    $ly_val = 0;
                } else {
                    $ly_val = $t['val'];
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_ly != 0 && ($t['dt_epoch'] != $epoch_leap2_ly) && ($t['dt_epoch'] - $last_ly) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_ly)/86400)-1; $x++){
                        array_push($ts_ly, null);  
                    } 
                } 

                
                $cumu_ly += floatval($ly_val); 
                array_push($ts_ly, $cumu_ly);

                $last_ly_val = $cumu_ly;
                $last_ly = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_live && $t['dt_epoch'] >= $beg_epoch) {                
                
                //
                // This-year data
                //

                if ($first_ty) {
                    $first_ty_val = floatval($t['val']);
                    $first_ty_dt = $t ['dt_epoch'];
                    $first_ty = false;
                    $ty_val = 0;
                } else {
                    $ty_val = $t['val'];
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_ty != 0 && ($t['dt_epoch'] - $last_ty) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_ty)/86400)-1; $x++){
                        array_push($ts_ty, null);  
                        array_push($ts_ty_last, null); // Point at last value in uplot
                    }
                }

                if ($t['dt_epoch'] <= $now) { 
                    $cumu_ty += floatval($ty_val); 

                    array_push($ts_ty, $cumu_ty);
                    array_push($ts_ty_last, null); // Point at last value in uplot

                    $last_ty_val = $cumu_ty; 
                    $last_ty = $t['dt_epoch']; 
                }
            }
        }

        array_push($ts_min, $cumu_min+$first_min_val);
        array_push($ts_mean, $cumu_mean+$first_mean_val);
        array_push($ts_max, $cumu_max+$first_max_val);
        array_push($ts_ly, $last_ly_val);
        array_pop($ts_ty_last);
        array_push($ts_ty_last, $last_ty_val, null);

        // If nec. fill nulls at beginning

        if (($first_ly_dt - $ly_start_epoch) >= 172800) {
            for ($x = 1; $x <= intval(($first_ly_dt - $ly_start_epoch)/86400)-1; $x++){
                array_unshift($ts_ly, null);  
            }
        }

        if (($first_ty_dt - $beg_epoch) >= 172800) {
            for ($x = 1; $x <= intval(($first_ty_dt - $beg_epoch)/86400)-1; $x++){
                array_unshift($ts_ty, null);  
                array_unshift($ts_ty_last, null);
            }
        }

        $data["ts"] = $timestamps;
        $data["ts_min"] =  $ts_min; 
        $data["ts_mean"] =  $ts_mean;
        $data["ts_max"] =  $ts_max;
        $data["ts_ly"] =  $ts_ly;
        $data["ts_ty"] =  $ts_ty;
        $data["ts_ty_last"] =  $ts_ty_last;

        //
        // Results
        //

        $res = $model_res->getResultsForDs($id);

        $a1 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a2 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a3 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a4 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a5 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 

        foreach ($res as $r) {
            if ($r["name"] == "last_30days_sum") {
                $a1 = get_col_station_precip($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_lastmonth_sum") {
                $a2 = get_col_station_precip($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_month_sum") {
                $a3 = get_col_station_precip($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "this_year_sum") {
                $a4 = get_col_station_precip($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_year_sum") {
                $a5 = get_col_station_precip($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            }
        }

        $data["analysis_1"] = $a1; 
        $data["analysis_2"] = $a2; 
        $data["analysis_3"] = $a3; 
        $data["analysis_4"] = $a4; 
        $data["analysis_5"] = $a5; 

        $in_tz = new DateTimeZone('UTC');
        $out_tz = new DateTimeZone('Europe/Vienna');

        $data["lt_comment"] = $model_tslog->getTsLogWithName($id, 'lt_webapp')['comment'];
        $data["last_modified"] = convertTimezone($model_tslog->getTsLogWithName($id, 'lt_webapp')['last_modified_at'], $in_tz, $out_tz, 'd.m.Y H:i:s');

        return $this->response->setJSON($data);
    }

    public function airtemp_chart(?int $id = -1)
    {   
        helper('text'); 

        $model_ts = model(HydrodashTsModel::class);
        $model_tscat = model(HydrodashTsCatModel::class); 
        $model_res = model(HydrodashDsResModel::class); 
        $model_tslog = model(HydrodashTsLogModel::class); 

        //
        // Get Categories
        //

        $ts_cat = $model_tscat->getCat();

        $cat_live = -1;
        $cat_min = -1;
        $cat_mean = -1;
        $cat_max = -1;

        foreach($ts_cat as $c) {
            if ($c['name_short'] == 'live') {
                $cat_live = $c['id'];
            } elseif ($c['name_short'] == 'lt_min') { 
                $cat_min = $c['id'];
            } elseif ($c['name_short'] == 'lt_mean') { 
                $cat_mean = $c['id'];
            } elseif ($c['name_short'] == 'lt_max') { 
                $cat_max = $c['id'];
            } 
        } 

        //
        // Prepare operation
        // 

        $tz_utc = new DateTimeZone('UTC');

        $year = date('Y');
        $last_year = $year-1;

        $leap_year = $year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0);
        $leap_last_year = $last_year % 4 == 0 && ($last_year % 100 != 0 || $last_year % 400 == 0);

        $timestamps = [];
        $ts_min = [];
        $ts_mean = [];
        $ts_max = [];
        $ts_ty = [];
        $ts_ly = [];
        $ts_ty_last = [];

        // Array epoch times

        $beg_epoch = mktime(0,0,0,1,1,$year);
        $end_epoch = mktime(1,0,0,1,1,$year+1);
        $ly_start_epoch = mktime(0,0,0,1,1,$year-1);

        $beg = new DateTime(date(DATE_ATOM, $beg_epoch), $tz_utc);
        $end = new DateTime(date(DATE_ATOM, $end_epoch), $tz_utc);
        
        $range = new DatePeriod($beg, new DateInterval('P1D'), $end);

        foreach ($range as $dt) {
            array_push($timestamps, $dt->getTimestamp());
        }

        $epoch_leap1_2020 = mktime(0,0,0,2,29,2020);
        $epoch_leap2_2020 = mktime(0,0,0,3,1,2020);

        $epoch_leap1_ly = mktime(0,0,0,2,29,$last_year);
        $epoch_leap2_ly = mktime(0,0,0,3,1,$last_year);

        $epoch_leap1_ty = mktime(0,0,0,2,29,$year);
        $epoch_leap2_ty = mktime(0,0,0,3,1,$year);

        // Array data

        $ts = $model_ts->getTs($id);

        $last_min = 0;
        $last_mean = 0;
        $last_max = 0;
        $last_ty = 0;
        $last_ly = 0;

        $last_min_val = 0;
        $last_mean_val = 0;
        $last_max_val = 0;
        $last_ly_val = 0;
        $last_ty_val = 0;

        $first_ty = true;
        $first_ty_val = 0;
        $first_ty_dt = 0;
        $first_ly = true;
        $first_ly_val = 0;
        $first_ly_dt = 0;

        $first_min = true;
        $first_min_val = 0;
        $first_mean = true;
        $first_mean_val = 0;
        $first_max = true;
        $first_max_val = 0;

        $now = time();

        foreach ($ts as $t) {
            if (!is_numeric($t['val'])) {
                continue;
            } 

            // Skip 29.02. if no leap year

            if (!$leap_year && ($t['dt_epoch'] == $epoch_leap1_2020 || ($leap_last_year && $t['dt_epoch'] == $epoch_leap1_ly))) {
                continue;
            }

            if ($t['cat_id'] == $cat_max) {
                
                //
                // Long-term Max
                //

                if ($first_max) {
                    $first_max_val = floatval($t['val']);
                    $first_max = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_max != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_max) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_max)/86400)-1; $x++){
                        array_push($ts_max, null);  
                    } 
                } 

                array_push($ts_max, floatval($t['val']));

                $last_max_val = floatval($t['val']);
                $last_max = $t['dt_epoch'];
            } elseif ($t['cat_id'] == $cat_mean) {

                //
                // Long-term Mean
                //

                if ($first_mean) {
                    $first_mean_val = floatval($t['val']);
                    $first_mean = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_mean != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_mean) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_mean)/86400)-1; $x++){
                        array_push($ts_mean, null);  
                    } 
                } 

                array_push($ts_mean, floatval($t['val']));

                $last_mean_val = floatval($t['val']);
                $last_mean = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_min) {

                //
                // Long-term Min
                //


                if ($first_min) {
                    $first_min_val = floatval($t['val']);
                    $first_min = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_min != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_min) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_min)/86400)-1; $x++){
                        array_push($ts_mean, null);  
                    } 
                } 

                array_push($ts_min, floatval($t['val']));

                $last_min_val = floatval($t['val']);
                $last_min = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_live && $t['dt_epoch'] >= $ly_start_epoch && $t['dt_epoch'] < $beg_epoch) {

                //
                // Last-year data
                //

                if ($first_ly) {
                    $first_ly_val = floatval($t['val']);
                    $first_ly_dt = $t ['dt_epoch'];
                    $first_ly = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_ly != 0 && ($t['dt_epoch'] != $epoch_leap2_ly) && ($t['dt_epoch'] - $last_ly) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_ly)/86400)-1; $x++){
                        array_push($ts_ly, null);  
                    } 
                } 

                array_push($ts_ly, floatval($t['val']));

                $last_ly_val = floatval($t['val']);
                $last_ly = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_live && $t['dt_epoch'] >= $beg_epoch) {                
                
                //
                // This-year data
                //

                if ($first_ty) {
                    $first_ty_val = floatval($t['val']);
                    $first_ty_dt = $t ['dt_epoch'];
                    $first_ty = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_ty != 0 && ($t['dt_epoch'] - $last_ty) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_ty)/86400)-1; $x++){
                        array_push($ts_ty, null);  
                        array_push($ts_ty_last, null); // Point at last value in uplot
                    }
                }

                if ($t['dt_epoch'] < $now) { 
                    array_push($ts_ty, floatval($t['val']));
                    array_push($ts_ty_last, null); // Point at last value in uplot

                    $last_ty_val = floatval($t['val']); 
                    $last_ty = $t['dt_epoch']; 
                }
            }
        }

        array_push($ts_min, $first_min_val);
        array_push($ts_mean, $first_mean_val);
        array_push($ts_max, $first_max_val);
        array_push($ts_ly, $first_ty_val);
        array_push($ts_ty, null);
        array_pop($ts_ty_last);
        array_push($ts_ty_last, $last_ty_val, null);

        // If nec. fill nulls at beginning

        if (($first_ly_dt - $ly_start_epoch) >= 172800) {
            for ($x = 1; $x <= intval(($first_ly_dt - $ly_start_epoch)/86400)-1; $x++){
                array_unshift($ts_ly, null);  
            }
        }

        if (($first_ty_dt - $beg_epoch) >= 172800) {
            for ($x = 1; $x <= intval(($first_ty_dt - $beg_epoch)/86400)-1; $x++){
                array_unshift($ts_ty, null);  
                array_unshift($ts_ty_last, null);
            }
        }

        $data["ts"] = $timestamps;
        $data["ts_min"] =  $ts_min; 
        $data["ts_mean"] =  $ts_mean;
        $data["ts_max"] =  $ts_max;
        $data["ts_ly"] =  $ts_ly;
        $data["ts_ty"] =  $ts_ty;
        $data["ts_ty_last"] =  $ts_ty_last;

        //
        // Results
        //

        $res = $model_res->getResultsForDs($id);

        $a1 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a2 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a3 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a4 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a5 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a6 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 

        foreach ($res as $r) {
            if ($r["name"] == "last_day_mean") {
                $a1 = get_col_station_airtemp($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_30days_mean") {
                $a2 = get_col_station_airtemp($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_lastmonth_mean") {
                $a3 = get_col_station_airtemp($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_month_mean") {
                $a4 = get_col_station_airtemp($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "this_year_mean") {
                $a5 = get_col_station_airtemp($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_year_mean") {
                $a6 = get_col_station_airtemp($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            }
        }

        $data["analysis_1"] = $a1; 
        $data["analysis_2"] = $a2; 
        $data["analysis_3"] = $a3; 
        $data["analysis_4"] = $a4; 
        $data["analysis_5"] = $a5; 
        $data["analysis_6"] = $a6; 

        $in_tz = new DateTimeZone('UTC');
        $out_tz = new DateTimeZone('Europe/Vienna');

        $data["lt_comment"] = $model_tslog->getTsLogWithName($id, 'lt_webapp')['comment'];
        $data["last_modified"] = convertTimezone($model_tslog->getTsLogWithName($id, 'lt_webapp')['last_modified_at'], $in_tz, $out_tz, 'd.m.Y H:i:s');

        return $this->response->setJSON($data);
    }

    public function gw_chart(?int $id = -1)
    {   
        helper('text'); 

        $model_ts = model(HydrodashTsModel::class);
        $model_tscat = model(HydrodashTsCatModel::class); 
        $model_res = model(HydrodashDsResModel::class); 
        $model_tslog = model(HydrodashTsLogModel::class); 
        $model_dsinfo = model(HydrodashDsInfoModel::class);

        //
        // Altitude
        //

        $alt = 0;
        $info = $model_dsinfo->getInfo($id);
        
        if (count($info) > 0) {
            $alt = $info["altitude"];
        }

        //
        // Get Categories
        //

        $ts_cat = $model_tscat->getCat();

        $cat_live = -1;
        $cat_min = -1;
        $cat_mean = -1;
        $cat_max = -1;

        foreach($ts_cat as $c) {
            if ($c['name_short'] == 'live') {
                $cat_live = $c['id'];
            } elseif ($c['name_short'] == 'lt_min') { 
                $cat_min = $c['id'];
            } elseif ($c['name_short'] == 'lt_mean') { 
                $cat_mean = $c['id'];
            } elseif ($c['name_short'] == 'lt_max') { 
                $cat_max = $c['id'];
            } 
        } 

        //
        // Prepare operation
        // 

        $tz_utc = new DateTimeZone('UTC');

        $year = date('Y');
        $last_year = $year-1;

        $leap_year = $year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0);
        $leap_last_year = $last_year % 4 == 0 && ($last_year % 100 != 0 || $last_year % 400 == 0);

        $timestamps = [];
        $ts_alt = [];
        $ts_min = [];
        $ts_mean = [];
        $ts_max = [];
        $ts_ty = [];
        $ts_ly = [];
        $ts_ty_last = [];

        // Array epoch times

        $beg_epoch = mktime(0,0,0,1,1,$year);
        $end_epoch = mktime(1,0,0,1,1,$year+1);
        $ly_start_epoch = mktime(0,0,0,1,1,$year-1);

        $beg = new DateTime(date(DATE_ATOM, $beg_epoch), $tz_utc);
        $end = new DateTime(date(DATE_ATOM, $end_epoch), $tz_utc);
        
        $range = new DatePeriod($beg, new DateInterval('P1D'), $end);

        foreach ($range as $dt) {
            array_push($timestamps, $dt->getTimestamp());
        }

        $epoch_leap1_2020 = mktime(0,0,0,2,29,2020);
        $epoch_leap2_2020 = mktime(0,0,0,3,1,2020);

        $epoch_leap1_ly = mktime(0,0,0,2,29,$last_year);
        $epoch_leap2_ly = mktime(0,0,0,3,1,$last_year);

        $epoch_leap1_ty = mktime(0,0,0,2,29,$year);
        $epoch_leap2_ty = mktime(0,0,0,3,1,$year);

        // Array data

        $ts = $model_ts->getTs($id);

        $last_min = 0;
        $last_mean = 0;
        $last_max = 0;
        $last_ty = 0;
        $last_ly = 0;

        $last_min_val = 0;
        $last_mean_val = 0;
        $last_max_val = 0;
        $last_ly_val = 0;
        $last_ty_val = 0;

        $first_ty = true;
        $first_ty_val = 0;
        $first_ty_dt = 0;
        $first_ly = true;
        $first_ly_val = 0;
        $first_ly_dt = 0;

        $first_min = true;
        $first_min_val = 0;
        $first_mean = true;
        $first_mean_val = 0;
        $first_max = true;
        $first_max_val = 0;

        $now = time();

        foreach ($ts as $t) {
            if (!is_numeric($t['val'])) {
                continue;
            } 

            // Skip 29.02. if no leap year

            if (!$leap_year && ($t['dt_epoch'] == $epoch_leap1_2020 || ($leap_last_year && $t['dt_epoch'] == $epoch_leap1_ly))) {
                continue;
            }

            array_push($ts_alt, $alt);  

            if ($t['cat_id'] == $cat_max) {
                
                //
                // Long-term Max
                //

                if ($first_max) {
                    $first_max_val = floatval($t['val']);
                    $first_max = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_max != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_max) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_max)/86400)-1; $x++){
                        array_push($ts_max, null);  
                    } 
                } 

                array_push($ts_max, $alt-floatval($t['val']));

                $last_max_val = $alt-floatval($t['val']);
                $last_max = $t['dt_epoch'];
            } elseif ($t['cat_id'] == $cat_mean) {

                //
                // Long-term Mean
                //

                if ($first_mean) {
                    $first_mean_val = floatval($t['val']);
                    $first_mean = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_mean != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_mean) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_mean)/86400)-1; $x++){
                        array_push($ts_mean, null);  
                    } 
                } 

                array_push($ts_mean, $alt-floatval($t['val']));

                $last_mean_val = $alt-floatval($t['val']);
                $last_mean = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_min) {

                //
                // Long-term Min
                //


                if ($first_min) {
                    $first_min_val = floatval($t['val']);
                    $first_min = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_min != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_min) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_min)/86400)-1; $x++){
                        array_push($ts_mean, null);  
                    } 
                } 

                array_push($ts_min, $alt-floatval($t['val']));

                $last_min_val = $alt-floatval($t['val']);
                $last_min = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_live && $t['dt_epoch'] >= $ly_start_epoch && $t['dt_epoch'] < $beg_epoch) {

                //
                // Last-year data
                //

                if ($first_ly) {
                    $first_ly_val = floatval($t['val']);
                    $first_ly_dt = $t ['dt_epoch'];
                    $first_ly = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_ly != 0 && ($t['dt_epoch'] != $epoch_leap2_ly) && ($t['dt_epoch'] - $last_ly) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_ly)/86400)-1; $x++){
                        array_push($ts_ly, null);  
                    } 
                } 

                array_push($ts_ly, $alt-floatval($t['val']));

                $last_ly_val = $alt-floatval($t['val']);
                $last_ly = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_live && $t['dt_epoch'] >= $beg_epoch) {                
                
                //
                // This-year data
                //

                if ($first_ty) {
                    $first_ty_val = $alt-floatval($t['val']);
                    $first_ty_dt = $t ['dt_epoch'];
                    $first_ty = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_ty != 0 && ($t['dt_epoch'] - $last_ty) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_ty)/86400)-1; $x++){
                        array_push($ts_ty, null);  
                        array_push($ts_ty_last, null); // Point at last value in uplot
                    }
                }

                if ($t['dt_epoch'] < $now) { 
                    array_push($ts_ty, $alt-floatval($t['val']));
                    array_push($ts_ty_last, null); // Point at last value in uplot

                    $last_ty_val = $alt-floatval($t['val']); 
                    $last_ty = $t['dt_epoch']; 
                }
            }
        }

        array_push($ts_min, $alt-$first_min_val);
        array_push($ts_mean, $alt-$first_mean_val);
        array_push($ts_max, $alt-$first_max_val);
        array_push($ts_ly, $first_ty_val);
        array_push($ts_ty, null);
        array_pop($ts_ty_last);
        array_push($ts_ty_last, $last_ty_val, null);

        // If nec. fill nulls at beginning

        if (($first_ly_dt - $ly_start_epoch) >= 172800) {
            for ($x = 1; $x <= intval(($first_ly_dt - $ly_start_epoch)/86400)-1; $x++){
                array_unshift($ts_ly, null);  
            }
        }

        if (($first_ty_dt - $beg_epoch) >= 172800) {
            for ($x = 1; $x <= intval(($first_ty_dt - $beg_epoch)/86400)-1; $x++){
                array_unshift($ts_ty, null);  
                array_unshift($ts_ty_last, null);
            }
        }

        $data["ts"] = $timestamps;
        $data["ts_alt"] =  $ts_alt; 
        $data["ts_min"] =  $ts_max; // min = max (altitude - flurabstand)
        $data["ts_mean"] =  $ts_mean;
        $data["ts_max"] =  $ts_min; // max = min (altitude - flurabstand)
        $data["ts_ly"] =  $ts_ly;
        $data["ts_ty"] =  $ts_ty;
        $data["ts_ty_last"] =  $ts_ty_last;

        //
        // Results
        //

        $res = $model_res->getResultsForDs($id);

        $a1 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a2 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a3 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a4 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a5 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a6 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 

        foreach ($res as $r) {
            if ($r["name"] == "last_day_mean") {
                $a1 = get_col_station_groundwater($r["val"], $r["val_lt_min"], $r["val_lt"], $r["val_lt_max"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_30days_mean") {
                $a2 = get_col_station_groundwater($r["val"], $r["val_lt_min"], $r["val_lt"], $r["val_lt_max"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_lastmonth_mean") {
                $a3 = get_col_station_groundwater($r["val"], $r["val_lt_min"], $r["val_lt"], $r["val_lt_max"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_month_mean") {
                $a4 = get_col_station_groundwater($r["val"], $r["val_lt_min"], $r["val_lt"], $r["val_lt_max"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "this_year_mean") {
                $a5 = get_col_station_groundwater($r["val"], $r["val_lt_min"], $r["val_lt"], $r["val_lt_max"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_year_mean") {
                $a6 = get_col_station_groundwater($r["val"], $r["val_lt_min"], $r["val_lt"], $r["val_lt_max"], $r["valid_from"], $r["valid_to"]);
            }
        }

        $data["analysis_1"] = $a1; 
        $data["analysis_2"] = $a2; 
        $data["analysis_3"] = $a3; 
        $data["analysis_4"] = $a4; 
        $data["analysis_5"] = $a5;
        $data["analysis_6"] = $a6;

        $in_tz = new DateTimeZone('UTC');
        $out_tz = new DateTimeZone('Europe/Vienna');

        $data["lt_comment"] = $model_tslog->getTsLogWithName($id, 'lt_webapp')['comment'];
        $data["last_modified"] = convertTimezone($model_tslog->getTsLogWithName($id, 'lt_webapp')['last_modified_at'], $in_tz, $out_tz, 'd.m.Y H:i:s');

        return $this->response->setJSON($data);
    }

    public function springs_chart(?int $id = -1)
    {   
        helper('text'); 

        $model_ts = model(HydrodashTsModel::class);
        $model_tscat = model(HydrodashTsCatModel::class); 
        $model_res = model(HydrodashDsResModel::class); 
        $model_tslog = model(HydrodashTsLogModel::class); 

        //
        // Get Categories
        //

        $ts_cat = $model_tscat->getCat();

        $cat_live = -1;
        $cat_min = -1;
        $cat_mean = -1;
        $cat_max = -1;

        foreach($ts_cat as $c) {
            if ($c['name_short'] == 'live') {
                $cat_live = $c['id'];
            } elseif ($c['name_short'] == 'lt_min') { 
                $cat_min = $c['id'];
            } elseif ($c['name_short'] == 'lt_mean') { 
                $cat_mean = $c['id'];
            } elseif ($c['name_short'] == 'lt_max') { 
                $cat_max = $c['id'];
            } 
        } 

        //
        // Prepare operation
        // 

        $tz_utc = new DateTimeZone('UTC');

        $year = date('Y');
        $last_year = $year-1;

        $leap_year = $year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0);
        $leap_last_year = $last_year % 4 == 0 && ($last_year % 100 != 0 || $last_year % 400 == 0);

        $timestamps = [];
        $ts_min = [];
        $ts_mean = [];
        $ts_max = [];
        $ts_ty = [];
        $ts_ly = [];
        $ts_ty_last = [];

        // Array epoch times

        $beg_epoch = mktime(0,0,0,1,1,$year);
        $end_epoch = mktime(1,0,0,1,1,$year+1);
        $ly_start_epoch = mktime(0,0,0,1,1,$year-1);

        $beg = new DateTime(date(DATE_ATOM, $beg_epoch), $tz_utc);
        $end = new DateTime(date(DATE_ATOM, $end_epoch), $tz_utc);
        
        $range = new DatePeriod($beg, new DateInterval('P1D'), $end);

        foreach ($range as $dt) {
            array_push($timestamps, $dt->getTimestamp());
        }

        $epoch_leap1_2020 = mktime(0,0,0,2,29,2020);
        $epoch_leap2_2020 = mktime(0,0,0,3,1,2020);

        $epoch_leap1_ly = mktime(0,0,0,2,29,$last_year);
        $epoch_leap2_ly = mktime(0,0,0,3,1,$last_year);

        $epoch_leap1_ty = mktime(0,0,0,2,29,$year);
        $epoch_leap2_ty = mktime(0,0,0,3,1,$year);

        // Array data

        $ts = $model_ts->getTs($id);

        $last_min = 0;
        $last_mean = 0;
        $last_max = 0;
        $last_ty = 0;
        $last_ly = 0;

        $last_min_val = 0;
        $last_mean_val = 0;
        $last_max_val = 0;
        $last_ly_val = 0;
        $last_ty_val = 0;

        $first_ty = true;
        $first_ty_val = 0;
        $first_ty_dt = 0;
        $first_ly = true;
        $first_ly_val = 0;
        $first_ly_dt = 0;

        $first_min = true;
        $first_min_val = 0;
        $first_mean = true;
        $first_mean_val = 0;
        $first_max = true;
        $first_max_val = 0;

        $now = time();

        foreach ($ts as $t) {
            if (!is_numeric($t['val'])) {
                continue;
            } 

            // Skip 29.02. if no leap year

            if (!$leap_year && ($t['dt_epoch'] == $epoch_leap1_2020 || ($leap_last_year && $t['dt_epoch'] == $epoch_leap1_ly))) {
                continue;
            }

            if ($t['cat_id'] == $cat_max) {
                
                //
                // Long-term Max
                //

                if ($first_max) {
                    $first_max_val = floatval($t['val']);
                    $first_max = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_max != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_max) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_max)/86400)-1; $x++){
                        array_push($ts_max, null);  
                    } 
                } 

                array_push($ts_max, floatval($t['val']));

                $last_max_val = floatval($t['val']);
                $last_max = $t['dt_epoch'];
            } elseif ($t['cat_id'] == $cat_mean) {

                //
                // Long-term Mean
                //

                if ($first_mean) {
                    $first_mean_val = floatval($t['val']);
                    $first_mean = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_mean != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_mean) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_mean)/86400)-1; $x++){
                        array_push($ts_mean, null);  
                    } 
                } 

                array_push($ts_mean, floatval($t['val']));

                $last_mean_val = floatval($t['val']);
                $last_mean = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_min) {

                //
                // Long-term Min
                //


                if ($first_min) {
                    $first_min_val = floatval($t['val']);
                    $first_min = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_min != 0 && (!$leap_year && $t['dt_epoch'] != $epoch_leap2_2020) && ($t['dt_epoch'] - $last_min) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_min)/86400)-1; $x++){
                        array_push($ts_mean, null);  
                    } 
                } 

                array_push($ts_min, floatval($t['val']));

                $last_min_val = floatval($t['val']);
                $last_min = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_live && $t['dt_epoch'] >= $ly_start_epoch && $t['dt_epoch'] < $beg_epoch) {

                //
                // Last-year data
                //

                if ($first_ly) {
                    $first_ly_val = floatval($t['val']);
                    $first_ly_dt = $t ['dt_epoch'];
                    $first_ly = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_ly != 0 && ($t['dt_epoch'] != $epoch_leap2_ly) && ($t['dt_epoch'] - $last_ly) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_ly)/86400)-1; $x++){
                        array_push($ts_ly, null);  
                    } 
                } 

                array_push($ts_ly, floatval($t['val']));

                $last_ly_val = floatval($t['val']);
                $last_ly = $t['dt_epoch']; 
            } elseif ($t['cat_id'] == $cat_live && $t['dt_epoch'] >= $beg_epoch) {                
                
                //
                // This-year data
                //

                if ($first_ty) {
                    $first_ty_val = floatval($t['val']);
                    $first_ty_dt = $t ['dt_epoch'];
                    $first_ty = false;
                }

                // Fill nulls if gap > 1d between dataset

                if ($last_ty != 0 && ($t['dt_epoch'] - $last_ty) >= 172800) {
                    for ($x = 1; $x <= intval(($t['dt_epoch'] - $last_ty)/86400)-1; $x++){
                        array_push($ts_ty, null);  
                        array_push($ts_ty_last, null); // Point at last value in uplot
                    }
                }

                if ($t['dt_epoch'] < $now) { 
                    array_push($ts_ty, floatval($t['val']));
                    array_push($ts_ty_last, null); // Point at last value in uplot

                    $last_ty_val = floatval($t['val']); 
                    $last_ty = $t['dt_epoch']; 
                }
            }
        }

        array_push($ts_min, $first_min_val);
        array_push($ts_mean, $first_mean_val);
        array_push($ts_max, $first_max_val);
        array_push($ts_ly, $first_ty_val);
        array_push($ts_ty, null);
        array_pop($ts_ty_last);
        array_push($ts_ty_last, $last_ty_val, null);

        // If nec. fill nulls at beginning

        if (($first_ly_dt - $ly_start_epoch) >= 172800) {
            for ($x = 1; $x <= intval(($first_ly_dt - $ly_start_epoch)/86400)-1; $x++){
                array_unshift($ts_ly, null);  
            }
        }

        if (($first_ty_dt - $beg_epoch) >= 172800) {
            for ($x = 1; $x <= intval(($first_ty_dt - $beg_epoch)/86400)-1; $x++){
                array_unshift($ts_ty, null);
                array_unshift($ts_ty_last, null);
            }
        }

        $data["ts"] = $timestamps;
        $data["ts_min"] =  $ts_min; 
        $data["ts_mean"] =  $ts_mean;
        $data["ts_max"] =  $ts_max;
        $data["ts_ly"] =  $ts_ly;
        $data["ts_ty"] =  $ts_ty;
        $data["ts_ty_last"] =  $ts_ty_last;

        //
        // Results
        //

        $res = $model_res->getResultsForDs($id);

        $a1 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a2 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a3 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a4 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a5 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 
        $a6 = ['#fff', '', '', '', 0, '', '#fff', '#fff']; 

        foreach ($res as $r) {
            if ($r["name"] == "last_day_mean") {
                $a1 = get_col_station_springs($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_30days_mean") {
                $a2 = get_col_station_springs($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_lastmonth_mean") {
                $a3 = get_col_station_springs($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_month_mean") {
                $a4 = get_col_station_springs($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "this_year_mean") {
                $a5 = get_col_station_springs($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            } elseif ($r["name"] == "last_year_mean") {
                $a6 = get_col_station_springs($r["val"], $r["val_lt"], $r["valid_from"], $r["valid_to"]);
            }
        }

        $data["analysis_1"] = $a1; 
        $data["analysis_2"] = $a2; 
        $data["analysis_3"] = $a3; 
        $data["analysis_4"] = $a4; 
        $data["analysis_5"] = $a5;
        $data["analysis_6"] = $a6;

        $in_tz = new DateTimeZone('UTC');
        $out_tz = new DateTimeZone('Europe/Vienna');

        $data["lt_comment"] = $model_tslog->getTsLogWithName($id, 'lt_webapp')['comment'];
        $data["last_modified"] = convertTimezone($model_tslog->getTsLogWithName($id, 'lt_webapp')['last_modified_at'], $in_tz, $out_tz, 'd.m.Y H:i:s');

        return $this->response->setJSON($data);
    }
        
    public function info()
    {   
        $data['title'] = 'Berechnungsgrundlage';

        $model_menu = model(MenuModel::class); 
        $model_ds = model(HydrodashMvDischargeModel::class);

        $data['ds'] = $model_ds->getEntries();
        $data['menu'] = $model_menu->getMenu('');
        $data['sub'] = '';
    
        return view('templates/header', $data)
            . view('templates/menu')
            . view('hydrodash/info')
            . view('templates/footer');
    }

}