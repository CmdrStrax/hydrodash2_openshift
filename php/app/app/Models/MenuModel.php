<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    private $menu = array (
        array("Abfluss", ""),
        array("Wassertemperatur", "watertemp"),
        array("|",""),
        array("Niederschlag", "precip"),
        array("Lufttemperatur", "airtemp"),
        array("|",""),
        array("Grundwasser", "gw"),
        array("Quellen", "springs"),
    );

    private $menu_admin_side = array(
        array("Geber", "admin", "home"),
        array("Einzugsgebiete", "admin/catchment", "table"),
        array("-", "", ""),
        array("Jobs", "admin/jobs", "jobs"),
        array("Materialized Views", "admin/mv", "table"),
        array("-", "", ""),
        array("Benutzerverwaltung", "admin/usermgt", "users"),
    );

    public function getMenu($active = '')
    {
        for ($i = 0; $i < count($this->menu); $i++) {
            if ($this->menu[$i][0] == $active){
                array_push($this->menu[$i], ' active');
            } else if ($this->menu[$i][0] == "|") {
                array_push($this->menu[$i], ' disabled d-none d-lg-block');
            } else {
                array_push($this->menu[$i], '');
            } 
        }

        return $this->menu;
    }

    public function getMenuAdminSide($active = '')
    {
        for ($i = 0; $i < count($this->menu_admin_side); $i++) {
            if ($this->menu_admin_side[$i][0] == $active){
                array_push($this->menu_admin_side[$i], ' active');
            } else {
                array_push($this->menu_admin_side[$i], '');
            } 
        }

        return $this->menu_admin_side;
    }
}
