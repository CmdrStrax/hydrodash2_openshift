<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Site extends BaseConfig {

    public $geoserver_wms_url = 'http://localhost/geoserver/hydrodash/wms?tiled=true';
    public $geoserver_wfs_url = 'http://localhost/geoserver/hydrodash/wfs';

    public $log_nightly = '';
    public $log_jobs = '';

     public function __construct() {
        parent::__construct();
        
        if (getenv("GEOSERVER_WMS_URL") != False) {
        	$this->geoserver_wms_url = getenv("GEOSERVER_WMS_URL");
        }
        
        if (getenv("GEOSERVER_WFS_URL") != False) {
        	$this->geoserver_wfs_url = getenv("GEOSERVER_WFS_URL");
        } 
    }
}
