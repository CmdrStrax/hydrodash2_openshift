
<?php 
helper('text');
helper('url'); 
?>
<script type="text/javascript" class="init">
  $(document).ready(function () {
    dt_stations = $('#stations').DataTable({
      searching: true,
      paging: true,
      pageLength: -1,
      ordering: false,
      lengthMenu: [10, 25, 50, { label: 'Alle', value: -1 }],
      language: {
        url: '<?php echo base_url(); ?>js/dataTables.german.json',
      },
      responsive: true,
      rowGroup: { dataSrc: 1 },
      columns: [
        { width: '30%' }, 
        { visible: false }, 
        { width: '10%' }, 
        { width: '10%' }, 
        { width: '10%' }, 
        { width: '10%' }, 
        { width: '10%' }, 
        { width: '10%' }, 
        { width: '10%' }],
      fixedHeader: {
          header: true,
      },
    });
  });
</script>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="up" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/>  
  </symbol>
  <symbol id="up-right" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0z"/>  
  </symbol>
  <symbol id="right" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>  
  </symbol>
  <symbol id="down-right" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M14 13.5a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1 0-1h4.793L2.146 2.854a.5.5 0 1 1 .708-.708L13 12.293V7.5a.5.5 0 0 1 1 0z"/>  
  </symbol>
  <symbol id="down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1"/> 
  </symbol>
  <symbol id="info" viewBox="0 0 16 16">
    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
  </symbol>
</svg>

<div class="content">

<div id="map" style="width: 100%; height: 720px !important;">
  <div id="map_title" class="map_title"></div>
  <div id="map_title_mobile" class="map_title"></div>
</div>

<div class="container-fluid mt-3 mb-3">
  <table class="table table-hover nowrap" id="stations">
    <thead>
      <tr>
        <th data-priority="1" width="30%">Stationsname</th>
        <th data-priority="10" style="display:none;">Flussgebiet</th>
        <th data-priority="3" width="10%">Tagesmittel <small class="text-secondary">[m]</small><br /><small class="text-secondary" style="font-weight: normal !important;"><?= esc($yesterday); ?></small></th>
        <th data-priority="2" width="10%">Gestern <small class="text-secondary">[%]</small><br /><small class="text-secondary" style="font-weight: normal !important;"><?= esc($yesterday); ?></small></th>
        <th data-priority="2" width="10%">Letzte 30 Tage <small class="text-secondary">[%]</small><br /><small class="text-secondary" style="font-weight: normal !important;">ab <?= esc($last_30days_from); ?></small></th>
        <th data-priority="2" width="10%">Vor-Vormonat <small class="text-secondary">[%]</small><br /><small class="text-secondary" style="font-weight: normal !important;"><?= esc($last_lastmonth); ?></small></th>
        <th data-priority="2" width="10%">Vormonat <small class="text-secondary">[%]</small><br /><small class="text-secondary" style="font-weight: normal !important;"><?= esc($last_month); ?></small></th>
        <th data-priority="1" width="10%">Heuer <small class="text-secondary">[%]</small><br /><small class="text-secondary" style="font-weight: normal !important;">bis <?= esc($this_year); ?></small></th>
        <th data-priority="2" width="10%">Vorjahr <small class="text-secondary">[%]</small><br /><small class="text-secondary" style="font-weight: normal !important;"><?= esc($last_year); ?></small></th>
      </tr>
    </thead>
    <?php $last_fg = ""; ?>
    <?php foreach ($ds as $d): ?>
    <?php 
      $a1 = get_col_table_groundwater($d['res_last_day_mean'], $d['res_last_day_min_lt'], $d['res_last_day_mean_lt'], $d['res_last_day_max_lt']);
      $a2 = get_col_table_groundwater($d['res_last_30days_mean'], $d['res_last_30days_min_lt'], $d['res_last_30days_mean_lt'], $d['res_last_30days_max_lt']);
      $a3 = get_col_table_groundwater($d['res_last_lastmonth_mean'], $d['res_last_lastmonth_min_lt'], $d['res_last_lastmonth_mean_lt'], $d['res_last_lastmonth_max_lt']);
      $a4 = get_col_table_groundwater($d['res_last_month_mean'], $d['res_last_month_min_lt'], $d['res_last_month_mean_lt'], $d['res_last_month_max_lt']);
      $a5 = get_col_table_groundwater($d['res_this_year_mean'], $d['res_this_year_min_lt'], $d['res_this_year_mean_lt'], $d['res_this_year_max_lt']);
      $a6 = get_col_table_groundwater($d['res_last_year_mean'], $d['res_last_year_min_lt'], $d['res_last_year_mean_lt'], $d['res_last_year_max_lt']);
 
      $tooltip = '<a href="' . base_url() . 'info#gaps" title="Zu hoher Lückenanteil in Betrachtungszeitraum&#013;(fehlende Daten)">' . 
            '<svg class="bi me-2" width="16" height="16" fill="#8e959b" style="cursor: pointer; margin-left: 5px; margin-bottom: 2px;">' . 
            '<use xlink:href="#info"/>' .
            '</svg></a>';
    ?>
    <tr>
      <td><a href="<?php echo base_url(); ?><?php echo $sub; ?>/<?php echo $d['id'] ?>"><?php echo $d['name'] ?></a></td>
      <td style="display:none;"><?php echo $d['catchment_name'] ?></td>
      <td style="border-left: #ccc 1px solid;"><?php if (!is_null($d['res_last_day_mean'])) { echo round($d['res_last_day_mean'], 2) . ' mm<br /><small class="text-secondary">(' . (new DateTime($d['res_last_day_to']))->modify('-12 hour')->format('d.m.Y') . ')</small>'; } else { echo "<span class=\"text-secondary fst-italic\">Kein Messwert</span>"; } ?></td>
      <td style="background-color: <?= esc($a1[0]); ?>; border-left: #ccc 1px solid;"><?php if ($a1[1] != "") { echo $a1[1]; } else { echo '<span class="text-secondary fst-italic">Kein Messwert ' . $tooltip . '<br /></span>'; } ?><svg class="ms-1" width="16" height="16" fill="#777"><use xlink:href="#<?= esc($a1[3]); ?>"/></svg><br /><small class="text-secondary"><?php if ($a1[2] != "") { echo '(' . $a1[2] . ')'; } ?></small></td>
      <td style="background-color: <?= esc($a2[0]); ?>;"><?php if ($a2[1] != "") { echo $a2[1]; } else { echo '<span class="text-secondary fst-italic">Kein Messwert ' . $tooltip . '<br /></span>'; } ?><svg class="ms-1" width="16" height="16" fill="#777"><use xlink:href="#<?= esc($a2[3]); ?>"/></svg><br /><small class="text-secondary"><?php if ($a2[2] != "") { echo '(' . $a2[2] . ')'; } ?></small></td>
      <td style="background-color: <?= esc($a3[0]); ?>; border-left: #ccc 1px solid;"><?php if ($a3[1] != "") { echo $a3[1]; } else { echo '<span class="text-secondary fst-italic">Kein Messwert ' . $tooltip . '<br /></span>'; } ?><svg class="ms-1" width="16" height="16" fill="#777"><use xlink:href="#<?= esc($a3[3]); ?>"/></svg><br /><small class="text-secondary"><?php if ($a3[2] != "") { echo '(' . $a3[2] . ')'; } ?></small></td>
      <td style="background-color: <?= esc($a4[0]); ?>;"><?php if ($a4[1] != "") { echo $a4[1]; } else { echo '<span class="text-secondary fst-italic">Kein Messwert ' . $tooltip . '<br /></span>'; } ?><svg class="ms-1" width="16" height="16" fill="#777"><use xlink:href="#<?= esc($a4[3]); ?>"/></svg><br /><small class="text-secondary"><?php if ($a4[2] != "") { echo '(' . $a4[2] . ')'; } ?></small></td>
      <td style="background-color: <?= esc($a5[0]); ?>; border-left: #ccc 1px solid;"><?php if ($a5[1] != "") { echo $a5[1]; } else { echo '<span class="text-secondary fst-italic">Kein Messwert ' . $tooltip . '<br /></span>'; } ?><svg class="ms-1" width="16" height="16" fill="#777"><use xlink:href="#<?= esc($a5[3]); ?>"/></svg><br /><small class="text-secondary"><?php if ($a5[2] != "") { echo '(' . $a5[2] . ')'; } ?></small></td>
      <td style="background-color: <?= esc($a6[0]); ?>;"><?php if ($a6[1] != "") { echo $a6[1]; } else { echo '<span class="text-secondary fst-italic">Kein Messwert ' . $tooltip . '<br /></span>'; } ?><svg class="ms-1" width="16" height="16" fill="#777"><use xlink:href="#<?= esc($a6[3]); ?>"/></svg><br /><small class="text-secondary"><?php if ($a6[2] != "") { echo '(' . $a6[2] . ')'; } ?></small></td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
</div>
<script src="<?php echo base_url(); ?>geojson/geo.js"></script>
<script>
const monthNames = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
const monthNamesShort = ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"];

var d_a1_1 = new Date(null);
var d_a1_2 = new Date(null);

var d_a2_1 = new Date(null);
var d_a2_2 = new Date(null);

var d_a3_1 = new Date(null);
var d_a3_2 = new Date(null);

var d_a4_1 = new Date(null);
var d_a4_2 = new Date(null);

var d_a5_1 = new Date(null);
var d_a5_2 = new Date(null);

var d_a6_1 = new Date(null);
var d_a6_2 = new Date(null);

//
// Leaflet map
//

var map = L.map('map', { 
  center: [46.7535, 13.8612], 
  zoom: 9.5, 
  gestureHandling: true, 
  zoomSnap: 0.5, 
  zoomDelta: 0.5, 
  attributionControl: false,
  touchZoom: true
 });

var attr = L.control.attribution({ position: 'bottomleft' }).addTo(map); 
var graphicScale = L.control.graphicScale( { fill: 'line', position: 'bottomright', showSubunits: true } ); // Scale added to map later

map.addControl(new L.Control.Fullscreen({
    title: {
        'false': 'Fullscreen',
        'true': 'Fullscreen beenden'
    }
}));

map.createPane('bg');
map.getPane('bg').style.zIndex = 10;

map.createPane('brighten');
map.getPane('brighten').style.zIndex = 50;

map.createPane('vect');
map.getPane('vect').style.zIndex = 100;

map.createPane('vect_high');
map.getPane('vect_high').style.zIndex = 110;

map.createPane('vect_very_high');
map.getPane('vect_very_high').style.zIndex = 600;

map.createPane('vect_very_high_2');
map.getPane('vect_very_high_2').style.zIndex = 610;

// Base layers

var tile_layer_osm_swiss = L.tileLayer("https://tile.osm.ch/switzerland/{z}/{x}/{y}.png", {
  "attribution": "<a href=\"https://openstreetmap.org\">OpenStreetMap</a> contributors, Swiss OpenStreetMap Association",
  "detectRetina": true, 
  "maxNativeZoom": 18, 
  "maxZoom": 18, 
  "minZoom": 0, 
  "noWrap": false, 
  "opacity": 1, 
  "tms": false,
  "pane": 'bg',
}).addTo(map);

var tile_layer_osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  "attribution": "<a href=\"https://openstreetmap.org\">OpenStreetMap</a> contributors", 
  "detectRetina": true, 
  "maxNativeZoom": 18, 
  "maxZoom": 18, 
  "minZoom": 0, 
  "noWrap": false, 
  "opacity": 1, 
  "tms": false,
  "pane": 'bg',
}).addTo(map);

var tile_layer_basemap_gelaende = L.tileLayer("https://mapsneu.wien.gv.at/basemap/bmapgelaende/grau/google3857/{z}/{y}/{x}.jpeg", {
  "attribution": "basemap.at", 
  "detectRetina": true, 
  "maxNativeZoom": 18, 
  "maxZoom": 18, 
  "minZoom": 0, 
  "noWrap": false, 
  "opacity": 1, 
  "subdomains": "abc", 
  "tms": false,
  "pane": 'bg',
}).addTo(map);

var tile_layer_basemap = L.tileLayer("https://mapsneu.wien.gv.at/basemap/geolandbasemap/normal/google3857/{z}/{y}/{x}.png", {
  "attribution": "basemap.at", 
  "detectRetina": true, 
  "maxNativeZoom": 18, 
  "maxZoom": 18, 
  "minZoom": 0, 
  "noWrap": false, 
  "opacity": 1, 
  "tms": false,
  "pane": 'bg',
}).addTo(map);

var tile_layer_basemap_overlay = L.tileLayer("https://mapsneu.wien.gv.at/basemap/bmapoverlay/normal/google3857/{z}/{y}/{x}.png", {
  "attribution": "basemap.at", 
  "detectRetina": true, 
  "maxNativeZoom": 18, 
  "maxZoom": 18, 
  "minZoom": 0, 
  "noWrap": false, 
  "opacity": 1, 
  "tms": false,
  "pane": 'vect_high',
}).addTo(map);

var tile_layer_basemap_ortho = L.tileLayer("https://mapsneu.wien.gv.at/basemap/bmaporthofoto30cm/normal/google3857/{z}/{y}/{x}.jpeg",  {
  "attribution": "basemap.at", 
  "detectRetina": true, 
  "maxNativeZoom": 18, 
  "maxZoom": 18, 
  "minZoom": 0, 
  "noWrap": false, 
  "opacity": 1, 
  "tms": false,
  "pane": 'bg',
}).addTo(map);

// Custom layers geoJSON

// geoJSON - Counties

function geo_counties_styler(feature) {
  switch(feature.id) {
  default:
    return { "color": "#888", "weight": 1.25, };
  }
}

var counties = L.geoJson(null, {
  style: geo_counties_styler,
}).addTo(map);

function geo_json_counties_add (data) {
  counties.addData(data);
}

geo_json_counties_add([counties_data]);

// geoJSON - Highlight Carinthia

function geo_carinthia_styler(feature) {
  switch(feature.id) {
  default:
    return { "color": "#888", "fillColor": "#000", "fillOpacity": 0.1, "opacity": 0.75, "weight": 0, };
  }
}

var carinthia = L.geoJson(null, {
  style: geo_carinthia_styler,
  pane: 'vect',
  attribution: "EuroGeographics", 
}).addTo(map);

function geo_json_carinthia_add (data) {
  carinthia.addData(data);
}

geo_json_carinthia_add([carinthia_data]);

// geoJSON - Urban areas

function geo_urban_styler(feature) {
  switch(feature.id) {
  default:
    return {"fillColor": "#888", "fillOpacity": 0.33, "weight": 0,};
  }
}

var urban = L.geoJson(null, {
  style: geo_urban_styler,
  pane: 'vect',
  attribution: "Umweltbundesamt GmbH", 
}).addTo(map);

function geo_json_urban_add (data) {
  urban.addData(data);
}

geo_json_urban_add([urban_data]);

// geoJSON - Streams

function geo_streams_styler(feature) {
  switch(feature.id) {
  default:
    return {"color": "#778ca1", "fillColor": "#000", "fillOpacity": 0.1, "opacity": 1, "weight": feature.properties.linewidth,};
  }
}

var streams = L.geoJson(null, {
  style: geo_streams_styler,
  pane: 'vect',
  attribution: "Umweltbundesamt GmbH", 
}).addTo(map);

function geo_json_streams_add (data) {
  streams.addData(data);
}

geo_json_streams_add([streams_data]);

// geoJSON - Lakes

function geo_lakes_styler(feature) {
  switch(feature.id) {
  default:
    return {"color": "#778ca1", "fillColor": "#778ca1", "fillOpacity": 1, "opacity": 1, "weight": 1,};
  }
}

var lakes = L.geoJson(null, {
  style: geo_lakes_styler,
  pane: 'vect',
  attribution: "Umweltbundesamt GmbH", 
}).addTo(map);

function geo_json_lakes_add (data) {
  lakes.addData(data);
}

geo_json_lakes_add([lakes_data]);

// Custom layers Geoserver

var streams_geoserver = L.tileLayer.wms('<?php echo $geoserver_wms_url; ?>', {
  layers: 'hydrodash:streams',
  opacity: 1,
  transparent: true,
  format: 'image/png',
  attribution: "Umweltbundesamt GmbH", 
  pane: 'vect',
  minZoom: 9.5,
}).addTo(map);

var lakes_geoserver = L.tileLayer.wms('<?php echo $geoserver_wms_url; ?>', {
  layers: 'hydrodash:lakes',
  opacity: 1,
  transparent: true,
  format: 'image/png',
  attribution: "Umweltbundesamt GmbH", 
  pane: 'vect',
  minZoom: 9.5,
}).addTo(map);

var carinthia_geoserver = L.tileLayer.wms('<?php echo $geoserver_wms_url; ?>', {
  layers: 'hydrodash:carinthia',
  opacity: 1,
  transparent: true,
  format: 'image/png',
  attribution: "BEV Datenthema Verwaltungseinheiten", 
  pane: 'vect',
  minZoom: 10.5,
}).addTo(map);

// Basin Overlay (total value)

var overview_basin_div = L.divIcon({
  "className": "leaflet-basin-overview", 
  "html": "<i style=\"font-size: 14px;\">Gesamt:</i><br /><b><?php echo append_sign($basins['res_this_year'], 0, '%'); ?></b>", 
  "iconSize": [120, 60],
});

var overview_basin = L.marker([46.7535, 13.8612], {icon: overview_basin_div, pane: 'vect_very_high_2', }).addTo(map);

// Basin Overlays (basins)

var basin_last_day = L.tileLayer.wms('<?php echo $geoserver_wms_url; ?>&env=analysis:res_last_day;analysis_str:res_last_day_string', {
  layers: 'hydrodash:mv_groundwater_basins',
  opacity: 1,
  transparent: true,
  format: 'image/png',
  attribution: "", 
  pane: 'vect_very_high',
}).addTo(map);

var basin_last_30days = L.tileLayer.wms('<?php echo $geoserver_wms_url; ?>&env=analysis:res_last_30days;analysis_str:res_last_30days_string', {
  layers: 'hydrodash:mv_groundwater_basins',
  opacity: 1,
  transparent: true,
  format: 'image/png',
  attribution: "", 
  pane: 'vect_very_high',
}).addTo(map);

var basin_last_lastmonth = L.tileLayer.wms('<?php echo $geoserver_wms_url; ?>&env=analysis:res_last_lastmonth;analysis_str:res_last_lastmonth_string', {
  layers: 'hydrodash:mv_groundwater_basins',
  opacity: 1,
  transparent: true,
  format: 'image/png',
  attribution: "", 
  pane: 'vect_very_high',
}).addTo(map);

var basin_last_month = L.tileLayer.wms('<?php echo $geoserver_wms_url; ?>&env=analysis:res_last_month;analysis_str:res_last_month_string', {
  layers: 'hydrodash:mv_groundwater_basins',
  opacity: 1,
  transparent: true,
  format: 'image/png',
  attribution: "", 
  pane: 'vect_very_high',
}).addTo(map);

var basin_this_year = L.tileLayer.wms('<?php echo $geoserver_wms_url; ?>&env=analysis:res_this_year;analysis_str:res_this_year_string', {
  layers: 'hydrodash:mv_groundwater_basins',
  opacity: 1,
  transparent: true,
  format: 'image/png',
  attribution: "", 
  pane: 'vect_very_high',
}).addTo(map);

var basin_last_year = L.tileLayer.wms('<?php echo $geoserver_wms_url; ?>&env=analysis:res_last_year;analysis_str:res_last_year_string', {
  layers: 'hydrodash:mv_groundwater_basins',
  opacity: 1,
  transparent: true,
  format: 'image/png',
  attribution: "", 
  pane: 'vect_very_high',
}).addTo(map);

// HydroDash Result Layers (WFS Ajax)

var fg_res_y = L.featureGroup({}).addTo(map);
var fg_res_l30d = L.featureGroup({}).addTo(map);
var fg_res_lm = L.featureGroup({}).addTo(map);
var fg_res_lm2 = L.featureGroup({}).addTo(map);
var fg_res_ty = L.featureGroup({}).addTo(map);
var fg_res_ly = L.featureGroup({}).addTo(map);

$.ajax('<?php echo $geoserver_wfs_url; ?>',{
  type: 'GET',
  data: {
    service: 'WFS',
    version: '1.1.0',
    request: 'GetFeature',
    typename: 'hydrodash:mv_groundwater',
    srsname: 'EPSG:4326',
    outputFormat: 'text/javascript',
  },
  dataType: 'jsonp',
  jsonpCallback:'callback:handleJsonHydroDash',
  jsonp:'format_options'
});

var radio_cat = L.control({});

function handleJsonHydroDash(data) {

  // Add Radio-Buttons and Title

  if (data.features.length > 0) {
    d_a1_1 = new Date(data.features[0].properties.res_last_day_from);
    d_a1_2 = new Date(data.features[0].properties.res_last_day_to);

    d_a2_1 = new Date(data.features[0].properties.res_last_30days_from);
    d_a2_2 = new Date(data.features[0].properties.res_last_30days_to);

    d_a3_1 = new Date(data.features[0].properties.res_last_lastmonth_from);
    d_a3_2 = new Date(data.features[0].properties.res_last_lastmonth_to);

    d_a4_1 = new Date(data.features[0].properties.res_last_month_from);
    d_a4_2 = new Date(data.features[0].properties.res_last_month_to);

    d_a5_1 = new Date(data.features[0].properties.res_this_year_from);
    d_a5_2 = new Date(data.features[0].properties.res_this_year_to);

    d_a6_1 = new Date(data.features[0].properties.res_last_year_from);
    d_a6_2 = new Date(data.features[0].properties.res_last_year_to);

    // Radio Buttons HydroDash Analysis

    var radio_cat_pos = 'bottomright';

    if (!mobileCheck()) {
      var radioHtml =  
        '<div class="btn_map" id="btn_map">' +
        '<input type="checkbox" class="btn-check" name="basin" id="basin_overlay" autocomplete="off" onclick="setBasins(this.checked);">' + 
        '<label class="btn btn-outline-success btn-sm" style="margin-left: 5px; margin-top: 5px;" for="basin_overlay"">Gebietswerte</label>' + 
        '<input type="radio" class="btn-check" name="cat" id="cat_1" autocomplete="off" onclick="setAnalysis(this.id);">' + 
        '<label class="btn btn-outline-primary btn-sm" style="margin-left: 12px; margin-top: 5px;" for="cat_1"">Gestern</label>' + 
        '<input type="radio" class="btn-check" name="cat" id="cat_2" autocomplete="off" onclick="setAnalysis(this.id);">' + 
        '<label class="btn btn-outline-primary btn-sm" style="margin-left: 5px; margin-top: 5px;" for="cat_2">Letzte 30 Tage</label>' + 
        '<input type="radio" class="btn-check" name="cat" id="cat_3" autocomplete="off" onclick="setAnalysis(this.id);">' + 
        '<label class="btn btn-outline-primary btn-sm" style="margin-left: 12px; margin-top: 5px;" for="cat_3">' + monthNames[d_a3_1.getMonth()] + ' ' + d_a3_1.getFullYear() + '</label>' +
        '<input type="radio" class="btn-check" name="cat" id="cat_4" autocomplete="off" onclick="setAnalysis(this.id);">' + 
        '<label class="btn btn-outline-primary btn-sm" style="margin-left: 5px; margin-top: 5px;" for="cat_4">' + monthNames[d_a4_1.getMonth()] +' ' + d_a4_1.getFullYear() + '</label>' +
        '<input type="radio" class="btn-check" name="cat" id="cat_5" autocomplete="off" checked onclick="setAnalysis(this.id);">' + 
        '<label class="btn btn-outline-primary btn-sm" style="margin-left: 12px; margin-top: 5px;" for="cat_5">Heuer</label>' + 
        '<input type="radio" class="btn-check" name="cat" id="cat_6" autocomplete="off" onclick="setAnalysis(this.id);">' + 
        '<label class="btn btn-outline-primary btn-sm" style="margin-left: 5px; margin-top: 5px;" for="cat_6">Vorjahr</label>' + 
        '</div>';
    } else {
      radio_cat_pos = 'bottomleft';

      var radioHtml = 
        '<div class="btn_map" id="btn_map">' +
        '<input type="checkbox" class="btn-check" name="basin" id="basin_overlay" autocomplete="off" onclick="setBasins(this.checked);">' + 
        '<label class="btn btn-outline-success btn-sm" style="margin-left: 5px; margin-top: 5px;" for="basin_overlay"">Gebietswerte</label>' + 
        '<input type="radio" class="btn-check" name="cat" id="cat_1" autocomplete="off" onclick="setAnalysis(this.id);">' + 
        '<label class="btn btn-outline-primary btn-sm" style="margin-left: 5px; margin-top: 5px;" for="cat_1"">Gestern</label>' + 
        '<input type="radio" class="btn-check" name="cat" id="cat_2" autocomplete="off" onclick="setAnalysis(this.id);">' + 
        '<label class="btn btn-outline-primary btn-sm" style="margin-left: 5px; margin-top: 5px;" for="cat_2">Letzte 30 Tage</label>' + 
        '<input type="radio" class="btn-check" name="cat" id="cat_3" autocomplete="off" onclick="setAnalysis(this.id);">' + 
        '<label class="btn btn-outline-primary btn-sm" style="margin-left: 5px; margin-top: 5px;" for="cat_3">' + monthNamesShort[d_a3_1.getMonth()] + '. ' + d_a3_1.getFullYear().toString().substr(-2) + '</label>' +
        '<input type="radio" class="btn-check" name="cat" id="cat_4" autocomplete="off" onclick="setAnalysis(this.id);">' + 
        '<label class="btn btn-outline-primary btn-sm" style="margin-left: 5px; margin-top: 5px;" for="cat_4">' + monthNamesShort[d_a4_1.getMonth()] +'. ' + d_a4_1.getFullYear().toString().substr(-2) + '</label>' +
        '<input type="radio" class="btn-check" name="cat" id="cat_5" autocomplete="off" checked onclick="setAnalysis(this.id);">' + 
        '<label class="btn btn-outline-primary btn-sm" style="margin-left: 5px; margin-top: 5px;" for="cat_5">Heuer</label>' + 
        '<input type="radio" class="btn-check" name="cat" id="cat_6" autocomplete="off" onclick="setAnalysis(this.id);">' + 
        '<label class="btn btn-outline-primary btn-sm" style="margin-left: 5px; margin-top: 5px;" for="cat_6">Vorjahr</label>' + 
        '</div>';
    }

    radio_cat.setPosition(radio_cat_pos);

    radio_cat.onAdd = function (map) {
      var div = L.DomUtil.create('div', 'checkbox_cat');
      div.innerHTML = radioHtml;       
      return div;
    };

    radio_cat.addTo(map);

    if (!mobileCheck()) {
      graphicScale.addTo(map); // Add Scale above buttons
    }

    setAnalysis('cat_5');
  }
  
  // Layer Yesterday

  result_points_y = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        style = getPointStyleGw(feature.properties.res_last_day_mean, feature.properties.res_last_day_min_lt, feature.properties.res_last_day_mean_lt, feature.properties.res_last_day_max_lt, 0, -1);

        return new L.circleMarker(
          [feature.geometry.coordinates[1], feature.geometry.coordinates[0]], 
          style);
    },
    onEachFeature: function(feature, layer) {
      layer.bindPopup('<b>Station ' + feature.properties.name + '</b> <small class="text-secondary">(' + feature.properties.hzbnr + ')</small>' +
        '<div id="chart_ty_p_' + feature.properties.id + '" style="width:700px; height:350px;"></div><br /><div id="chart_results_ty_p_' + feature.properties.id + '" class="h-100">', 
        { autoPan:false, maxWidth: 900, offset: getOffset(feature.geometry.coordinates[0], feature.geometry.coordinates[1]), className: 'my-leaflet-main-popup-content' });

      layer.on('popupopen', function (e) { createChart(feature.properties.id, '_ty_p_' + feature.properties.id); });
      layer.on('mouseover', function (e) { if (!mobileCheck()) { this.openPopup(); } });
      layer.on('mouseout', function (e) { this.closePopup(); });
      layer.on('click', function (e) { window.open("<?php echo base_url();?><?php echo $sub; ?>/" + feature.properties.id, '_blank'); });	
    }
  }).addTo(fg_res_y);

  result_text_y = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        return new L.marker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], {
          icon: new L.DivIcon({
            "className": "empty", 
            "html": "<div style=\"font-family: var(--bs-font-sans-serif); font-size: 10pt; color: #222; clear:both; text-align: center;\">" + getTextGw(feature.properties.res_last_day_mean, feature.properties.res_last_day_min_lt, feature.properties.res_last_day_mean_lt, feature.properties.res_last_day_max_lt, 0, -1) + "</div>", 
            "iconAnchor": [25 + feature.properties.x_offset, 26 + feature.properties.y_offset], 
            "iconSize": [50, 8],
          })
        });
    },
    onEachFeature: function(feature, layer) {
      layer.bindPopup('<b>Station ' + feature.properties.name + '</b> <small class="text-secondary">(' + feature.properties.hzbnr + ')</small>' +
        '<div id="chart_ty_t_' + feature.properties.id + '" style="width:700px; height:350px;"></div><br /><div id="chart_results_ty_t_' + feature.properties.id + '" class="h-100">', 
        { autoPan:false, maxWidth: 900, offset: getOffset(feature.geometry.coordinates[0], feature.geometry.coordinates[1]), className: 'my-leaflet-main-popup-content' });

      layer.on('popupopen', function (e) { createChart(feature.properties.id, '_ty_t_' + feature.properties.id); });
      layer.on('mouseover', function (e) { if (!mobileCheck()) { this.openPopup(); } });
      layer.on('mouseout', function (e) { this.closePopup(); });
      layer.on('click', function (e) { window.open("<?php echo base_url();?><?php echo $sub; ?>/" + feature.properties.id, '_blank'); });	
    }
  }).addTo(fg_res_y);

  // Layer Last 30d

  result_points_y = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        style = getPointStyleGw(feature.properties.res_last_30days_mean, feature.properties.res_last_30days_min_lt, feature.properties.res_last_30days_mean_lt, feature.properties.res_last_30days_max_lt, 0, -1);

        return new L.circleMarker(
          [feature.geometry.coordinates[1], feature.geometry.coordinates[0]], 
          style);
    },
    onEachFeature: function(feature, layer) {
      layer.bindPopup('<b>Station ' + feature.properties.name + '</b> <small class="text-secondary">(' + feature.properties.hzbnr + ')</small>' +
        '<div id="chart_ty_p_' + feature.properties.id + '" style="width:700px; height:350px;"></div><br /><div id="chart_results_ty_p_' + feature.properties.id + '" class="h-100">', 
        { autoPan:false, maxWidth: 900, offset: getOffset(feature.geometry.coordinates[0], feature.geometry.coordinates[1]), className: 'my-leaflet-main-popup-content' });

      layer.on('popupopen', function (e) { createChart(feature.properties.id, '_ty_p_' + feature.properties.id); });
      layer.on('mouseover', function (e) { if (!mobileCheck()) { this.openPopup(); } });
      layer.on('mouseout', function (e) { this.closePopup(); });
      layer.on('click', function (e) { window.open("<?php echo base_url();?><?php echo $sub; ?>/" + feature.properties.id, '_blank'); });	
    }
  }).addTo(fg_res_l30d);

  result_text_y = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        return new L.marker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], {
          icon: new L.DivIcon({
            "className": "empty", 
            "html": "<div style=\"font-family: var(--bs-font-sans-serif); font-size: 10pt; color: #222; clear:both; text-align: center;\">" + getTextGw(feature.properties.res_last_30days_mean, feature.properties.res_last_30days_min_lt, feature.properties.res_last_30days_mean_lt, feature.properties.res_last_30days_max_lt, 0, -1) + "</div>", 
            "iconAnchor": [25 + feature.properties.x_offset, 26 + feature.properties.y_offset], 
            "iconSize": [50, 8],
          })
        });
    },
    onEachFeature: function(feature, layer) {
      layer.bindPopup('<b>Station ' + feature.properties.name + '</b> <small class="text-secondary">(' + feature.properties.hzbnr + ')</small>' +
        '<div id="chart_ty_t_' + feature.properties.id + '" style="width:700px; height:350px;"></div><br /><div id="chart_results_ty_t_' + feature.properties.id + '" class="h-100">', 
        { autoPan:false, maxWidth: 900, offset: getOffset(feature.geometry.coordinates[0], feature.geometry.coordinates[1]), className: 'my-leaflet-main-popup-content' });

      layer.on('popupopen', function (e) { createChart(feature.properties.id, '_ty_t_' + feature.properties.id); });
      layer.on('mouseover', function (e) { if (!mobileCheck()) { this.openPopup(); } });
      layer.on('mouseout', function (e) { this.closePopup(); });
      layer.on('click', function (e) { window.open("<?php echo base_url();?><?php echo $sub; ?>/" + feature.properties.id, '_blank'); });	
    }
  }).addTo(fg_res_l30d);

  // Layer Last month

  result_points_lm = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        style = getPointStyleGw(feature.properties.res_last_month_mean, feature.properties.res_last_month_min_lt, feature.properties.res_last_month_mean_lt, feature.properties.res_last_month_max_lt, 0, -1);

        return new L.circleMarker(
          [feature.geometry.coordinates[1], feature.geometry.coordinates[0]], 
          style);
    },
    onEachFeature: function(feature, layer) {
      layer.bindPopup('<b>Station ' + feature.properties.name + '</b> <small class="text-secondary">(' + feature.properties.hzbnr + ')</small>' +
        '<div id="chart_ty_p_' + feature.properties.id + '" style="width:700px; height:350px;"></div><br /><div id="chart_results_ty_p_' + feature.properties.id + '" class="h-100">', 
        { autoPan:false, maxWidth: 900, offset: getOffset(feature.geometry.coordinates[0], feature.geometry.coordinates[1]), className: 'my-leaflet-main-popup-content' });

      layer.on('popupopen', function (e) { createChart(feature.properties.id, '_ty_p_' + feature.properties.id); });
      layer.on('mouseover', function (e) { if (!mobileCheck()) { this.openPopup(); } });
      layer.on('mouseout', function (e) { this.closePopup(); });
      layer.on('click', function (e) { window.open("<?php echo base_url();?><?php echo $sub; ?>/" + feature.properties.id, '_blank'); });	
    }
  }).addTo(fg_res_lm);

  result_text_lm = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        return new L.marker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], {
          icon: new L.DivIcon({
            "className": "empty", 
            "html": "<div style=\"font-family: var(--bs-font-sans-serif); font-size: 10pt; color: #222; clear:both; text-align: center;\">" + getTextGw(feature.properties.res_last_month_mean, feature.properties.res_last_month_min_lt, feature.properties.res_last_month_mean_lt, feature.properties.res_last_month_max_lt, 0, -1) + "</div>", 
            "iconAnchor": [25 + feature.properties.x_offset, 26 + feature.properties.y_offset], 
            "iconSize": [50, 8],
          })
        });
    },
    onEachFeature: function(feature, layer) {
      layer.bindPopup('<b>Station ' + feature.properties.name + '</b> <small class="text-secondary">(' + feature.properties.hzbnr + ')</small>' +
        '<div id="chart_ty_t_' + feature.properties.id + '" style="width:700px; height:350px;"></div><br /><div id="chart_results_ty_t_' + feature.properties.id + '" class="h-100">', 
        { autoPan:false, maxWidth: 900, offset: getOffset(feature.geometry.coordinates[0], feature.geometry.coordinates[1]), className: 'my-leaflet-main-popup-content' });

      layer.on('popupopen', function (e) { createChart(feature.properties.id, '_ty_t_' + feature.properties.id); });
      layer.on('mouseover', function (e) { if (!mobileCheck()) { this.openPopup(); } });
      layer.on('mouseout', function (e) { this.closePopup(); });
      layer.on('click', function (e) { window.open("<?php echo base_url();?><?php echo $sub; ?>/" + feature.properties.id, '_blank'); });	
    }
  }).addTo(fg_res_lm);

  // Layer Lastlastmonth

  result_points_lm = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        style = getPointStyleGw(feature.properties.res_last_lastmonth_mean, feature.properties.res_last_lastmonth_min_lt, feature.properties.res_last_lastmonth_mean_lt, feature.properties.res_last_lastmonth_max_lt, 0, -1);

        return new L.circleMarker(
          [feature.geometry.coordinates[1], feature.geometry.coordinates[0]], 
          style);
    },
    onEachFeature: function(feature, layer) {
      layer.bindPopup('<b>Station ' + feature.properties.name + '</b> <small class="text-secondary">(' + feature.properties.hzbnr + ')</small>' +
        '<div id="chart_ty_p_' + feature.properties.id + '" style="width:700px; height:350px;"></div><br /><div id="chart_results_ty_p_' + feature.properties.id + '" class="h-100">', 
        { autoPan:false, maxWidth: 900, offset: getOffset(feature.geometry.coordinates[0], feature.geometry.coordinates[1]), className: 'my-leaflet-main-popup-content' });

      layer.on('popupopen', function (e) { createChart(feature.properties.id, '_ty_p_' + feature.properties.id); });
      layer.on('mouseover', function (e) { if (!mobileCheck()) { this.openPopup(); } });
      layer.on('mouseout', function (e) { this.closePopup(); });
      layer.on('click', function (e) { window.open("<?php echo base_url();?><?php echo $sub; ?>/" + feature.properties.id, '_blank'); });	
    }
  }).addTo(fg_res_lm2);

  result_text_lm = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        return new L.marker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], {
          icon: new L.DivIcon({
            "className": "empty", 
            "html": "<div style=\"font-family: var(--bs-font-sans-serif); font-size: 10pt; color: #222; clear:both; text-align: center;\">" + getTextGw(feature.properties.res_last_lastmonth_mean, feature.properties.res_last_lastmonth_min_lt, feature.properties.res_last_lastmonth_mean_lt, feature.properties.res_last_lastmonth_max_lt, 0, -1) + "</div>", 
            "iconAnchor": [25 + feature.properties.x_offset, 26 + feature.properties.y_offset], 
            "iconSize": [50, 8],
          })
        });
    },
    onEachFeature: function(feature, layer) {
      layer.bindPopup('<b>Station ' + feature.properties.name + '</b> <small class="text-secondary">(' + feature.properties.hzbnr + ')</small>' +
        '<div id="chart_ty_t_' + feature.properties.id + '" style="width:700px; height:350px;"></div><br /><div id="chart_results_ty_t_' + feature.properties.id + '" class="h-100">', 
        { autoPan:false, maxWidth: 900, offset: getOffset(feature.geometry.coordinates[0], feature.geometry.coordinates[1]), className: 'my-leaflet-main-popup-content' });

      layer.on('popupopen', function (e) { createChart(feature.properties.id, '_ty_t_' + feature.properties.id); });
      layer.on('mouseover', function (e) { if (!mobileCheck()) { this.openPopup(); } });
      layer.on('mouseout', function (e) { this.closePopup(); });
      layer.on('click', function (e) { window.open("<?php echo base_url();?><?php echo $sub; ?>/" + feature.properties.id, '_blank'); });	
    }
  }).addTo(fg_res_lm2);

  // Layer this year

  result_points_ty = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        style = getPointStyleGw(feature.properties.res_this_year_mean, feature.properties.res_this_year_min_lt, feature.properties.res_this_year_mean_lt, feature.properties.res_this_year_max_lt, 0, -1);

        return new L.circleMarker(
          [feature.geometry.coordinates[1], feature.geometry.coordinates[0]], 
          style);
    },
    onEachFeature: function(feature, layer) {
      layer.bindPopup('<b>Station ' + feature.properties.name + '</b> <small class="text-secondary">(' + feature.properties.hzbnr + ')</small>' +
        '<div id="chart_ty_p_' + feature.properties.id + '" style="width:700px; height:350px;"></div><br /><div id="chart_results_ty_p_' + feature.properties.id + '" class="h-100">', 
        { autoPan:false, maxWidth: 900, offset: getOffset(feature.geometry.coordinates[0], feature.geometry.coordinates[1]), className: 'my-leaflet-main-popup-content' });

      layer.on('popupopen', function (e) { createChart(feature.properties.id, '_ty_p_' + feature.properties.id); });
      layer.on('mouseover', function (e) { if (!mobileCheck()) { this.openPopup(); } });
      layer.on('mouseout', function (e) { this.closePopup(); });
      layer.on('click', function (e) { window.open("<?php echo base_url();?><?php echo $sub; ?>/" + feature.properties.id, '_blank'); });	
    }
  }).addTo(fg_res_ty);

  result_text_ty = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        return new L.marker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], {
          icon: new L.DivIcon({
            "className": "empty", 
            "html": "<div style=\"font-family: var(--bs-font-sans-serif); font-size: 10pt; color: #222; clear:both; text-align: center;\">" + getTextGw(feature.properties.res_this_year_mean, feature.properties.res_this_year_min_lt, feature.properties.res_this_year_mean_lt, feature.properties.res_this_year_max_lt, 0, -1) + "</div>", 
            "iconAnchor": [25 + feature.properties.x_offset, 26 + feature.properties.y_offset], 
            "iconSize": [50, 8],
          })
        });
    },
    onEachFeature: function(feature, layer) {
      layer.bindPopup('<b>Station ' + feature.properties.name + '</b> <small class="text-secondary">(' + feature.properties.hzbnr + ')</small>' +
        '<div id="chart_ty_t_' + feature.properties.id + '" style="width:700px; height:350px;"></div><br /><div id="chart_results_ty_t_' + feature.properties.id + '" class="h-100">', 
        { autoPan:false, maxWidth: 900, offset: getOffset(feature.geometry.coordinates[0], feature.geometry.coordinates[1]), className: 'my-leaflet-main-popup-content' });

      layer.on('popupopen', function (e) { createChart(feature.properties.id, '_ty_t_' + feature.properties.id); });
      layer.on('mouseover', function (e) { if (!mobileCheck()) { this.openPopup(); } });
      layer.on('mouseout', function (e) { this.closePopup(); });
      layer.on('click', function (e) { window.open("<?php echo base_url();?><?php echo $sub; ?>/" + feature.properties.id, '_blank'); });	
    }
  }).addTo(fg_res_ty);

  // Layer last year
  
  result_points_ly = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        style = getPointStyleGw(feature.properties.res_last_year_mean, feature.properties.res_last_year_min_lt, feature.properties.res_last_year_mean_lt, feature.properties.res_last_year_max_lt, 0, -1);

        return new L.circleMarker(
          [feature.geometry.coordinates[1], feature.geometry.coordinates[0]], 
          style);
    },
    onEachFeature: function(feature, layer) {
      layer.bindPopup('<b>Station ' + feature.properties.name + '</b> <small class="text-secondary">(' + feature.properties.hzbnr + ')</small>' +
        '<div id="chart_ty_p_' + feature.properties.id + '" style="width:700px; height:350px;"></div><br /><div id="chart_results_ty_p_' + feature.properties.id + '" class="h-100">', 
        { autoPan:false, maxWidth: 900, offset: getOffset(feature.geometry.coordinates[0], feature.geometry.coordinates[1]), className: 'my-leaflet-main-popup-content' });

      layer.on('popupopen', function (e) { createChart(feature.properties.id, '_ty_p_' + feature.properties.id); });
      layer.on('mouseover', function (e) { if (!mobileCheck()) { this.openPopup(); } });
      layer.on('mouseout', function (e) { this.closePopup(); });
      layer.on('click', function (e) { window.open("<?php echo base_url();?><?php echo $sub; ?>/" + feature.properties.id, '_blank'); });	
    }
  }).addTo(fg_res_ly);

  result_text_ly = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        return new L.marker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], {
          icon: new L.DivIcon({
            "className": "empty", 
            "html": "<div style=\"font-family: var(--bs-font-sans-serif); font-size: 10pt; color: #222; clear:both; text-align: center;\">" + getTextGw(feature.properties.res_last_year_mean, feature.properties.res_last_year_min_lt, feature.properties.res_last_year_mean_lt, feature.properties.res_last_year_max_lt, 0, -1) + "</div>", 
            "iconAnchor": [25 + feature.properties.x_offset, 26 + feature.properties.y_offset], 
            "iconSize": [50, 8],
          })
        });
    },
    onEachFeature: function(feature, layer) {
      layer.bindPopup('<b>Station ' + feature.properties.name + '</b> <small class="text-secondary">(' + feature.properties.hzbnr + ')</small>' +
        '<div id="chart_ty_t_' + feature.properties.id + '" style="width:700px; height:350px;"></div><br /><div id="chart_results_ty_t_' + feature.properties.id + '" class="h-100">', 
        { autoPan:false, maxWidth: 900, offset: getOffset(feature.geometry.coordinates[0], feature.geometry.coordinates[1]), className: 'my-leaflet-main-popup-content' });

      layer.on('popupopen', function (e) { createChart(feature.properties.id, '_ty_t_' + feature.properties.id); });
      layer.on('mouseover', function (e) { if (!mobileCheck()) { this.openPopup(); } });
      layer.on('mouseout', function (e) { this.closePopup(); });
      layer.on('click', function (e) { window.open("<?php echo base_url();?><?php echo $sub; ?>/" + feature.properties.id, '_blank'); });	
    }
  }).addTo(fg_res_ly);
}

// Brighten

var image_overlay_brighten_10 = L.imageOverlay("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAIAAAACDbGyAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAQSURBVBhXY/iPCijj//8PAK09SrZrfO6mAAAAAElFTkSuQmCC",
  [[90, 180], [-90, -180]],
  {"opacity": 0.10}
).addTo(map);

var image_overlay_brighten_25 = L.imageOverlay("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAIAAAACDbGyAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAQSURBVBhXY/iPCijj//8PAK09SrZrfO6mAAAAAElFTkSuQmCC",
  [[90, 180], [-90, -180]],
  {"opacity": 0.25}
).addTo(map);

var image_overlay_brighten_50 = L.imageOverlay("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAIAAAACDbGyAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAQSURBVBhXY/iPCijj//8PAK09SrZrfO6mAAAAAElFTkSuQmCC",
  [[90, 180], [-90, -180]],
  {"opacity": 0.50}
).addTo(map);

var image_overlay_brighten_75 = L.imageOverlay("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAIAAAACDbGyAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAQSURBVBhXY/iPCijj//8PAK09SrZrfO6mAAAAAElFTkSuQmCC",
  [[90, 180], [-90, -180]],
  {"opacity": 0.8, "pane": "brighten"}
).addTo(map);

//
// Control elements
//

// Layer groups for switch geoJSON- and WMF Layer

streams_grp = L.layerGroup([streams, streams_geoserver]).addTo(map);
lakes_grp = L.layerGroup([lakes, lakes_geoserver]).addTo(map);
counties_grp = L.layerGroup([carinthia, carinthia_geoserver, counties]).addTo(map);

// Layer control

var layer_control = {
  base_layers : {
    "OSM Swiss": tile_layer_osm_swiss,
    "OSM" : tile_layer_osm,
    "Austria Hillshade (basemap.at)" : tile_layer_basemap_gelaende,
    "Austria Basemap (basemap.at)" : tile_layer_basemap,
    "Austria Orthofotos (basemap.at)" : tile_layer_basemap_ortho,
  },
  overlays :  {
    "Ländergrenzen": counties_grp,
    "Gewässernetz": streams_grp,
    "Seen": lakes_grp,
    "Austria Basemap Overlay (basemap.at)" : tile_layer_basemap_overlay,
    "Karte aufhellen 10 %" : image_overlay_brighten_10,
    "Karte aufhellen 25 %" : image_overlay_brighten_25,
    "Karte aufhellen 50 %" : image_overlay_brighten_50,
    "Karte aufhellen 75 %" : image_overlay_brighten_75,
  },
};

L.control.layers(
  layer_control.base_layers,
  layer_control.overlays,
  {"autoZIndex": true, "collapsed": true, "position": "topright" }
).addTo(map);

fg_res_y.remove();
fg_res_l30d.remove();
fg_res_lm.remove();
fg_res_lm2.remove();
fg_res_ly.remove();

lakes_geoserver.remove();
streams_geoserver.remove();
carinthia_geoserver.remove();

image_overlay_brighten_10.remove();
image_overlay_brighten_25.remove();
image_overlay_brighten_50.remove();
tile_layer_osm_swiss.remove();
tile_layer_basemap.remove();
tile_layer_basemap_ortho.remove();
tile_layer_basemap_overlay.remove();
tile_layer_osm.remove();

basin_last_day.remove();
basin_last_30days.remove();
basin_last_lastmonth.remove();
basin_last_month.remove();
basin_this_year.remove();
basin_last_year.remove();

overview_basin.remove();

// Legend

var legend = L.control({ position: "bottomleft" })
  legend.onAdd = function(map) {
  var div = L.DomUtil.create("div", "legend");
  div.id = "map_legend";
  div.innerHTML += '<b>Abweichung <small>[%]</small></b><br />';
  div.innerHTML += '<i style="background: rgba(69,117,180,1)"></i><span>< -150</span><br>';
  div.innerHTML += '<i style="background: rgba(116,173,209,1)"></i><span>-150 - -100</span><br>';
  div.innerHTML += '<i style="background: rgba(171,217,233,1)"></i><span>-100 - -50</span><br>';
  div.innerHTML += '<i style="background: rgba(224,243,248,1)"></i><span>-50 - 0</span><br>';
  div.innerHTML += '<i style="background: rgba(255,255,255,1)"></i><span>0</span><br>';
  div.innerHTML += '<i style="background: rgba(254,224,144,1)"></i><span>0 - +50</span><br>';
  div.innerHTML += '<i style="background: rgba(253,174,97,1)"></i><span>+50 - +100</span><br>';
  div.innerHTML += '<i style="background: rgba(244,109,67,1)"></i><span>+100 - +150</span><br>';
  div.innerHTML += '<i style="background: rgba(215,48,39,1)"></i><span>>= +150</span><br>';
return div; };

legend.addTo(map);

// Button title

showTitle = false;

const buttonTitle = L.control({ position: 'topleft' });
buttonTitle.onAdd = () => {
    const buttonDiv = L.DomUtil.create('div', 'leaflet-bar leaflet-control');

    buttonDiv.innerHTML = '<div id="btn_title" style="cursor: pointer; background-color: white; color: #b0b0b0ff; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-data" viewBox="0 0 16 16"><title>Kartentitel anzeigen</title><path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/></svg></div>';
    buttonDiv.addEventListener('click', function() {
      if(showTitle === true) {
        $('#map_title').hide(); 
        $('#map_title_mobile').hide();
        $('#btn_title').css('color', '#b0b0b0ff');

        showTitle = false; 
      } else {
        if (mobileCheck()) {
          $('#map_title_mobile').show();
        } else {
          $('#map_title').show();
        }
        $('#btn_title').css('color', 'black');

        showTitle = true; 
      }
    })
    return buttonDiv;
};
buttonTitle.addTo(map);

$('#map_title').hide();
$('#map_title_mobile').hide();

// Button legend

const buttonLegend = L.control({ position: 'topleft' });
buttonLegend.onAdd = () => {
    const buttonDiv = L.DomUtil.create('div', 'leaflet-bar leaflet-control');

    buttonDiv.innerHTML = '<div id="btn_legend" style="cursor: pointer; background-color: white; color: black; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-data" viewBox="0 0 16 16"><title>Legende anzeigen</title><path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/><path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/></svg></div>';
    buttonDiv.addEventListener('click', function() {
      if(showLegend === true) {
        $('.legend').hide(); 
        $('#btn_legend').css('color', '#b0b0b0ff');
        showLegend = false; 
      } else {
        $('.legend').show();
        $('#btn_legend').css('color', 'black');
        showLegend = true; 
      }
    })
    return buttonDiv;
};
buttonLegend.addTo(map);

// Buttons print

const buttonPrintSvg = L.control({ position: 'topleft' });
buttonPrintSvg.onAdd = () => {
    const buttonDiv = L.DomUtil.create('div', 'leaflet-bar leaflet-control');

    buttonDiv.innerHTML = '<div id="btn_print" style="cursor: pointer; background-color: white; color: black; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-data" viewBox="0 0 16 16"><title>Karte als SVG exportieren</title><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/></svg></div>';
    buttonDiv.addEventListener('click', function() {
      saveAsImage('svg');
    })   
    return buttonDiv;
};
buttonPrintSvg.addTo(map);

const buttonPrintPdf = L.control({ position: 'topleft' });
buttonPrintPdf.onAdd = () => {
    const buttonDiv = L.DomUtil.create('div', 'leaflet-bar leaflet-control');

    buttonDiv.innerHTML = '<div id="btn_print" style="cursor: pointer; background-color: white; color: black; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-data" viewBox="0 0 16 16"><title>Karte als PDF exportieren</title><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/><path d="M4.603 14.087a.8.8 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.7 7.7 0 0 1 1.482-.645 20 20 0 0 0 1.062-2.227 7.3 7.3 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a11 11 0 0 0 .98 1.686 5.8 5.8 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.86.86 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.7 5.7 0 0 1-.911-.95 11.7 11.7 0 0 0-1.997.406 11.3 11.3 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.8.8 0 0 1-.58.029m1.379-1.901q-.25.115-.459.238c-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361q.016.032.026.044l.035-.012c.137-.056.355-.235.635-.572a8 8 0 0 0 .45-.606m1.64-1.33a13 13 0 0 1 1.01-.193 12 12 0 0 1-.51-.858 21 21 0 0 1-.5 1.05zm2.446.45q.226.245.435.41c.24.19.407.253.498.256a.1.1 0 0 0 .07-.015.3.3 0 0 0 .094-.125.44.44 0 0 0 .059-.2.1.1 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a4 4 0 0 0-.612-.053zM8.078 7.8a7 7 0 0 0 .2-.828q.046-.282.038-.465a.6.6 0 0 0-.032-.198.5.5 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822q.036.167.09.346z"/></svg></div>';
    buttonDiv.addEventListener('click', function() {
      saveAsImage('pdf');
    })   
    return buttonDiv;
};

const buttonPrintPng = L.control({ position: 'topleft' });
buttonPrintPng.onAdd = () => {
    const buttonDiv = L.DomUtil.create('div', 'leaflet-bar leaflet-control');

    buttonDiv.innerHTML = '<div id="btn_print" style="cursor: pointer; background-color: white; color: black; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-data" viewBox="0 0 16 16"><title>Karte als PNG exportieren</title><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-3.76 8.132q.114.23.14.492h-.776a.8.8 0 0 0-.097-.249.7.7 0 0 0-.17-.19.7.7 0 0 0-.237-.126 1 1 0 0 0-.299-.044q-.427 0-.665.302-.234.301-.234.85v.498q0 .351.097.615a.9.9 0 0 0 .304.413.87.87 0 0 0 .519.146 1 1 0 0 0 .457-.096.67.67 0 0 0 .272-.264q.09-.164.091-.363v-.255H8.82v-.59h1.576v.798q0 .29-.097.55a1.3 1.3 0 0 1-.293.458 1.4 1.4 0 0 1-.495.313q-.296.111-.697.111a2 2 0 0 1-.753-.132 1.45 1.45 0 0 1-.533-.377 1.6 1.6 0 0 1-.32-.58 2.5 2.5 0 0 1-.105-.745v-.506q0-.543.2-.95.201-.406.582-.633.384-.228.926-.228.357 0 .636.1.281.1.48.275.2.176.314.407Zm-8.64-.706H0v4h.791v-1.343h.803q.43 0 .732-.172.305-.177.463-.475a1.4 1.4 0 0 0 .161-.677q0-.374-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.381.57.57 0 0 1-.238.24.8.8 0 0 1-.375.082H.788v-1.406h.66q.327 0 .512.182.185.181.185.521m1.964 2.666V13.25h.032l1.761 2.675h.656v-3.999h-.75v2.66h-.032l-1.752-2.66h-.662v4z"/></svg></div>';
    buttonDiv.addEventListener('click', function() {
      saveAsImage('png');
    })   
    return buttonDiv;
};

async function saveAsImage(format) {
  
  // Prepare map for print

  title_left = $('.map_title').css('left');
  border_top = $('#map').css('border-bottom-width');
  border_bottom = $('#map').css('border-top-width');

  $('.map_title').css('left', '12px');
  $('#map').css('border-bottom-width', '0px');
  $('#map').css('border-top-width', '0px');

  dt_now = new Date();
  dt_now_string = String(dt_now.getDate()).padStart(2, '0') + '.' +
    String(dt_now.getMonth() + 1).padStart(2, '0') + '.' +
    String(dt_now.getFullYear()) + ' ' +
    String(dt_now.getHours()).padStart(2, '0') + ':' +
    String(dt_now.getMinutes()).padStart(2, '0');

  dt_now_string_fn = dt_now.getFullYear() + '' +
    String(dt_now.getMonth() + 1).padStart(2, '0') + '' +
    String(dt_now.getDate()).padStart(2, '0') + '' +
    '_' +
    String(dt_now.getHours()).padStart(2, '0') + 
    String(dt_now.getMinutes()).padStart(2, '0') + 
    String(dt_now.getSeconds()).padStart(2, '0');

  attr_string = 'Karte erstellt am ' + dt_now_string;
  attr.addAttribution(attr_string);

  map.removeControl(radio_cat);
  attr.setPosition("bottomright");
  graphicScale.addTo(map);
  
  // Print DOM element with Snapdom

  const mapElement = document.querySelector('#map');

  // Override grey overlay from gestureHandling

  const styleOverride = document.createElement('style');
  styleOverride.innerHTML = '.leaflet-container:after { display: none !important; animation: none !important; opacity: 0 !important; }';
  document.head.appendChild(styleOverride);
  
  const result = await snapdom(mapElement, { 
    scale: 3, 
    dpr: 1, 
    compress: false,
    filterMode: 'remove', 
    filter: (node) => {
      if (node.id === 'map_title' || node.id === 'map_legend') {
        return true; 
      }

      if (node.classList && (node.classList.contains('leaflet-control-attribution') ||
        node.classList.contains('leaflet-control-graphicscale'))) {
        return true;
      }

      if (node.classList && (
        node.classList.contains('leaflet-control-container') ||
        node.classList.contains('leaflet-top') ||
        node.classList.contains('leaflet-bottom') ||
        node.classList.contains('leaflet-left') ||
        node.classList.contains('leaflet-right')
      )) {
        return true;
      }

      if (node.classList && node.classList.contains('leaflet-control')) {
        return false;
      }

      return true; 
    },
    plugins: [pdfImage({ orientation: 'landscape', quality: 1 })]
  });
      
  if (format === 'pdf') {
    await result.toPdfImage({filename: dt_now_string_fn + '_hydrodash_map.pdf' });
  } else {
    await result.download({ format: format, filename: dt_now_string_fn + '_hydrodash_map.png' });
  }

  // Reset map for standard use

  await $('.map_title').css('left', title_left);
  $('#map').css('border-bottom-width', border_bottom);
  $('#map').css('border-top-width', border_top);

  map.removeControl(legend);
  attr.setPosition("bottomleft");
  legend.addTo(map);
  radio_cat.addTo(map);
  attr.removeAttribution(attr_string);
  graphicScale.addTo(map);

  document.head.removeChild(styleOverride);
}

// Hide legend on mobile

if (mobileCheck()){
  $('.legend').hide(); 
  showLegend = false;
} else {
  showLegend = true;
}

// HydroDash Layer Control (Radio-Buttons)

function setAnalysis(id) {
  var chkBasins = document.getElementById('basin_overlay').checked;
  setBasins(chkBasins);

  if (id == 'cat_1') {
    map.addLayer(fg_res_y);
    map.removeLayer(fg_res_l30d);
    map.removeLayer(fg_res_lm);
    map.removeLayer(fg_res_lm2);
    map.removeLayer(fg_res_ty);
    map.removeLayer(fg_res_ly);

    document.getElementById('map_title').innerHTML = "<b>Grundwasserstand - Abweichung Gestern <small>[%]</small></b> <small class=\"text-secondary\" style=\"margin-left: 5px;\">(Tagesmittel vom " + 
      d_a1_1.getDate() + "." + (d_a1_1.getMonth()+1) + '.' + d_a1_1.getFullYear() + " im Vergleich zum  " + 
      d_a1_1.getDate() + "." + (d_a1_1.getMonth()+1) + ". des langjährigen Mittels)</small>";

    document.getElementById('map_title_mobile').innerHTML = "<b>Abweichung Gestern <small>[%]</small></b><br /><small class=\"text-secondary\" style=\"margin-left: 5px;\">(" + 
      d_a1_1.getDate() + "." + (d_a1_1.getMonth()+1) + '.' + d_a1_1.getFullYear().toString().substr(-2) + ")</small>";
  } else if (id == 'cat_2') {
    map.removeLayer(fg_res_y);
    map.addLayer(fg_res_l30d);
    map.removeLayer(fg_res_lm);
    map.removeLayer(fg_res_lm2);
    map.removeLayer(fg_res_ty);
    map.removeLayer(fg_res_ly);

    document.getElementById('map_title').innerHTML = "<b>Grundwasserstand - Abweichung 30-Tage <small>[%]</small></b> <small class=\"text-secondary\" style=\"margin-left: 5px;\">(Mittel vom " + 
      d_a2_1.getDate() + "." + (d_a2_1.getMonth()+1) + ". bis " + 
      d_a2_2.getDate() + "." + (d_a2_2.getMonth()+1) + '.' + d_a2_2.getFullYear() + " im Vergleich zum Zeitabschnitt  " + 
      d_a2_1.getDate() + "." + (d_a2_1.getMonth()+1) + ".  bis " + 
      d_a2_2.getDate() + "." + (d_a2_2.getMonth()+1) + ". des langjährigen Mittels)</small>";

    document.getElementById('map_title_mobile').innerHTML = "<b>Abweichung 30-Tage <small>[%]</small></b><br /><small class=\"text-secondary\" style=\"margin-left: 5px;\">(ab " + 
      d_a2_1.getDate() + "." + (d_a2_1.getMonth()+1) + '.' + d_a2_1.getFullYear().toString().substr(-2) + ")</small>";
  } else if (id == 'cat_3') {
    map.removeLayer(fg_res_y);
    map.removeLayer(fg_res_l30d);
    map.removeLayer(fg_res_lm);
    map.addLayer(fg_res_lm2);
    map.removeLayer(fg_res_ty);
    map.removeLayer(fg_res_ly);

    document.getElementById('map_title').innerHTML = "<b>Grundwasserstand - Abweichung " + monthNames[d_a3_1.getMonth()] + ' ' + d_a3_1.getFullYear() + " <small>[%]</small></b> <small class=\"text-secondary\" style=\"margin-left: 5px;\">(Mittlerer Grundwasserstand des Monats " + 
      monthNames[d_a3_1.getMonth()] + ' ' + d_a3_1.getFullYear() + " im Vergleich zu " + monthNames[d_a3_1.getMonth()] + " des langjährigen Mittels)</small>"; 

    document.getElementById('map_title_mobile').innerHTML = "<b>Abweichung " + monthNames[d_a3_1.getMonth()] + ' ' + d_a3_1.getFullYear().toString().substr(-2) + " <small>[%]</small></b>"; 
  } else if (id == 'cat_4') {
    map.removeLayer(fg_res_y);
    map.removeLayer(fg_res_l30d);
    map.addLayer(fg_res_lm);
    map.removeLayer(fg_res_lm2);
    map.removeLayer(fg_res_ty);
    map.removeLayer(fg_res_ly);

    document.getElementById('map_title').innerHTML = "<b>Grundwasserstand - Abweichung " + monthNames[d_a4_1.getMonth()] + ' ' + d_a4_1.getFullYear() +  " <small>[%]</small></b> <small class=\"text-secondary\" style=\"margin-left: 5px;\">(Mittlerer Grundwasserstand des Monats " + 
      monthNames[d_a4_1.getMonth()] + ' ' + d_a4_1.getFullYear() + " im Vergleich zu " + monthNames[d_a4_1.getMonth()] + " des langjährigen Mittels)</small>"; 
  
    document.getElementById('map_title_mobile').innerHTML = "<b>Abweichung " + monthNames[d_a4_1.getMonth()] + ' ' + d_a4_1.getFullYear().toString().substr(-2) + " <small>[%]</small></b>"; 
  } else if (id == 'cat_5') {
    map.removeLayer(fg_res_y);
    map.removeLayer(fg_res_l30d);
    map.removeLayer(fg_res_lm);
    map.removeLayer(fg_res_lm2);
    map.addLayer(fg_res_ty);
    map.removeLayer(fg_res_ly);

    document.getElementById('map_title').innerHTML = "<b>Grundwasserstand - Abweichung Heuer <small>[%]</small></b> <small class=\"text-secondary\" style=\"margin-left: 5px;\">(Mittlerer Grundwasserstand von 01.01." + 
      " bis " + d_a5_2.getDate() + "." + (d_a5_2.getMonth()+1) + "." + d_a5_2.getFullYear() + 
      " im Vergleich zum Zeitabschnitt 01.01. bis " + d_a5_2.getDate() + "." + (d_a5_2.getMonth()+1) + ". des langjährigen Mittels)</small>"; 

    document.getElementById('map_title_mobile').innerHTML = "<b>Abweichung Heuer <small>[%]</small></b> <small class=\"text-secondary\" style=\"margin-left: 5px;\"><br />(bis " + 
      d_a5_2.getDate() + "." + (d_a5_2.getMonth()+1) + '.' + d_a5_2.getFullYear().toString().substr(-2) + ")</small>";
  } else if (id == 'cat_6') {
    map.removeLayer(fg_res_y);
    map.removeLayer(fg_res_l30d);
    map.removeLayer(fg_res_lm);
    map.removeLayer(fg_res_lm2);
    map.removeLayer(fg_res_ty);
    map.addLayer(fg_res_ly);

    document.getElementById('map_title').innerHTML = "<b>Grundwasserstand - Abweichung Vorjahr <small>[%]</small></b> <small class=\"text-secondary\" style=\"margin-left: 5px;\">(Mittlerer Grundwasserstand des Jahres " + 
      (d_a6_1.getFullYear()) + " im Vergleich zum langjährigen Mittel)</small>";
      
    document.getElementById('map_title_mobile').innerHTML = "<b>Abweichung Vorjahr <small>[%]</small></b><br /><small class=\"text-secondary\" style=\"margin-left: 5px;\">(" + (d_a6_1.getFullYear()) +")</small>";
  }
}

function setBasins(chk) {
  if (!chk) {
    map.removeLayer(basin_last_day);
    map.removeLayer(basin_last_30days);
    map.removeLayer(basin_last_month);
    map.removeLayer(basin_last_lastmonth);
    map.removeLayer(basin_this_year);
    map.removeLayer(basin_last_year);
    map.removeLayer(overview_basin);

    setCounties();

    return;
  }

  var cat = $("input[name='cat']:checked").attr('id');
  var res_carinthia = "";

  map.removeLayer(basin_last_day);
  map.removeLayer(basin_last_30days);
  map.removeLayer(basin_last_month);
  map.removeLayer(basin_last_lastmonth);
  map.removeLayer(basin_this_year);
  map.removeLayer(basin_last_year);

  if (cat == "cat_1") {
    map.addLayer(basin_last_day);
    map.removeLayer(carinthia);
    res_carinthia = "<?php echo append_sign($basins['res_last_day'], 0, '%'); ?>";
  } else if (cat == "cat_2") {
    map.addLayer(basin_last_30days);
    map.removeLayer(carinthia);
    res_carinthia = "<?php echo append_sign($basins['res_last_30days'], 0, '%'); ?>";
  } else if (cat == "cat_3") {
    map.addLayer(basin_last_lastmonth);
    map.removeLayer(carinthia);
    res_carinthia = "<?php echo append_sign($basins['res_last_lastmonth'], 0, '%'); ?>";
  } else if (cat == "cat_4") {
    map.addLayer(basin_last_month);
    map.removeLayer(carinthia);
    res_carinthia = "<?php echo append_sign($basins['res_last_month'], 0, '%'); ?>";
  } else if (cat == "cat_5") {
    map.addLayer(basin_this_year);
    map.removeLayer(carinthia);
    res_carinthia = "<?php echo append_sign($basins['res_this_year'], 0, '%'); ?>";
  } else if (cat == "cat_6") {
    map.addLayer(basin_last_year);
    map.removeLayer(carinthia);
    res_carinthia = "<?php echo append_sign($basins['res_last_year'], 0, '%'); ?>";
  }

  var my_div = L.divIcon({
    "className": "leaflet-basin-overview", 
    "html": "<i style=\"font-size: 14px;\">Gesamt:</i><br /><b>" + res_carinthia + "</b>", 
    "iconSize": [120, 60],
  });

  map.removeLayer(carinthia);
  map.removeLayer(carinthia_geoserver);

  overview_basin.setIcon(my_div);  
  map.addLayer(overview_basin);
}

// Show Layer based on Zoom

function setCounties() {
  if (!map.hasLayer(counties_grp)) {
      map.removeLayer(carinthia);
      map.removeLayer(carinthia_geoserver);
      map.removeLayer(counties);
  } else if (map.hasLayer(basin_last_day) ||
    map.hasLayer(basin_last_30days) ||
    map.hasLayer(basin_last_month) ||
    map.hasLayer(basin_last_lastmonth) ||
    map.hasLayer(basin_this_year) ||
    map.hasLayer(basin_last_year)) {
      map.removeLayer(carinthia);
      map.addLayer(counties);
      map.removeLayer(carinthia_geoserver);
  } else if (map.getZoom() >= 11.5) {
      map.removeLayer(carinthia);
      map.removeLayer(counties);
      map.addLayer(carinthia_geoserver);
  } else {
      map.addLayer(carinthia);
      map.addLayer(counties);
      map.removeLayer(carinthia_geoserver);
  }
}

function setStreams() {
  if (map.getZoom() < 10.5) {
    map.removeLayer(streams_geoserver);
    map.addLayer(streams);
  } else {
    map.addLayer(streams_geoserver);
    map.removeLayer(streams);
  }
}

function setLakes() {
  if (map.getZoom() < 10.5) {
    map.removeLayer(lakes_geoserver);
    map.addLayer(lakes);
  } else {
    map.addLayer(lakes_geoserver);
    map.removeLayer(lakes);
  }
}

map.on('zoomend', function () {
  setCounties();
  setStreams();
  setLakes();
});

lakes_grp.on('add', function(){
  setLakes();
});

streams_grp.on('add', function(){
  setStreams();
});

counties_grp.on('add', function(){
  setCounties();
});

// Show print to PDF only in fullscreen mode

map.on('fullscreenchange', function () {
    if (map.isFullscreen()) {
        buttonPrintPng.addTo(map);
        buttonPrintPdf.addTo(map);
    } else {
        map.removeControl(buttonPrintPng);
        map.removeControl(buttonPrintPdf);
    }
});

//
// Charts in Leaflet Popup
// 

// Get data via AJAX and create uplot object

function createChart(id, div_postfix){
  var url = '<?php echo base_url();?><?php echo $sub; ?>/chart/' + id;
  let chartdata = []; 
  let a1;

  $.ajax({
      type: 'GET',
      url: url,
      async: true,
      contentType: "application/json",
      dataType: 'json',
      success: function (data) {
        ts = data["ts"];
        a1 = data["analysis_1"];
        a2 = data["analysis_2"];
        a3 = data["analysis_3"];
        a4 = data["analysis_4"];
        a5 = data["analysis_5"];
        a6 = data["analysis_6"];
        lt = data["lt_comment"];
        dt = data["last_modified"];

        chartdata.push(data["ts"]);
        chartdata.push(data["ts_min"]);
        chartdata.push(data["ts_mean"]);
        chartdata.push(data["ts_max"]);
        chartdata.push(data["ts_alt"]);
        chartdata.push(data["ts_ly"]);
        chartdata.push(data["ts_ty"]);
        chartdata.push(data["ts_ty_last"]);

        document.getElementById('chart_results' + div_postfix).innerHTML = 
        '<div class="h-100" style="text-align: center;">\
          <b style="color: red">-</b> GWS Tagesmittel Heuer [m] <span style="color: grey">|</span> <b style="color: #f99090">-</b> GWS Tagesmittel Vorjahr [m] <span style="color: grey">|</span> <span style="color: #00abe3">=</span> Langjährige Periode<br />\
          ' + lt + '\
          </div>\
          <div class="mt-2 small">\
            <div class="row">\
              <div class="col p-1">\
                <div style="border: 1px solid rgb(199, 199, 199); border-radius: 10px; background-color: ' + a1[0] + '; text-align: center; padding: 1em; margin: 0">\
                  <b>Gestern</b><br />\
                  <b style="color: ' + a1[5] + '">' + a1[1] + '</b>\
                </div>\
              </div>\
              <div class="col p-1">\
                <div style="border: 1px solid rgb(199, 199, 199); border-radius: 10px; background-color: ' + a2[0] + '; text-align: center; padding: 1em;">\
                  <b>Letzte 30 Tage</b><br />\
                  <b style="color: ' + a2[5] + '">' + a2[1] + '</b>\
                </div>\
              </div>\
              <div class="col p-1">\
                <div style="border: 1px solid rgb(199, 199, 199); border-radius: 10px; background-color: ' + a3[0] + '; text-align: center; padding: 1em;">\
                  <b>' + monthNames[d_a3_1.getMonth()] + ' ' + d_a3_1.getFullYear().toString().substr(-2) + '</b><br />\
                  <b style="color: ' + a3[5] + '">' + a3[1] + '</b>\
                </div>\
              </div>\
              <div class="col p-1">\
                <div style="border: 1px solid rgb(199, 199, 199); border-radius: 10px; background-color: ' + a4[0] + '; text-align: center; padding: 1em;">\
                  <b>' + monthNames[d_a4_1.getMonth()] + ' ' + d_a4_1.getFullYear().toString().substr(-2) + '</b><br />\
                  <b style="color: ' + a4[5] + '">' + a4[1] + '</b>\
                </div>\
              </div>\
              <div class="col p-1">\
                <div style="border: 1px solid rgb(199, 199, 199); border-radius: 10px; background-color: ' + a5[0] + '; text-align: center; padding: 1em;">\
                  <b>Heuer</b><br />\
                  <b style="color: ' + a5[5] + '">' + a5[1] + '</b>\
                </div>\
              </div>\
              <div class="col p-1">\
                <div style="border: 1px solid rgb(199, 199, 199); border-radius: 10px; background-color: ' + a6[0] + '; text-align: center; padding: 1em;">\
                  <b>Vorjahr</b><br />\
                  <b style="color: ' + a6[5] + '">' + a6[1] + '</b>\
                </div>\
              </div>\
            </div>\
            <div class="h-100 text-secondary" style="text-align: right; font-size: 10px; margin-top: 5px;">\
              Letzte Aktualisierung: ' + dt + '<br />\
            </div>\
          </div>'

        new uPlot(opts, chartdata, document.getElementById("chart" + div_postfix));
      }
  });
} 

// Chart options

const ruNames = {
  MMMM: ["Jänner","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"],
  MMM:  ["Jan","Feb","Mär","Apr","Mai","Jun","Jul","Aug","Sep","Okt","Nov","Dez"],
  WWWW: ["Montag","Dienstag","Mittwoh","Donnerstag","Freitag","Samstag","Sonntag"],
  WWW:  ["Mo","Di","Mi","Do","Fr","Sa","So"],
};

let ts;
let chartdata = [[],[],[],[],[],[]];

const opts = {
  height: 350,
  width: 700,
  tzDate: ts => uPlot.tzDate(new Date(ts * 1e3), 'Etc/UTC'),
  fmtDate: tpl => uPlot.fmtDate(tpl, ruNames),
  legend: { show: false,  },
  axes: [
    {
      space: (self, axisIdx, scaleMin, scaleMax, plotDim) => {
        let rangeSecs = scaleMax - scaleMin;
        let rangeDays = rangeSecs / 86400;
        let pxPerDay = plotDim / rangeDays;
        return pxPerDay * 28;
      },
    },
    {
      label: null,
    },
  ],
  series: [
    {          
      name: "Tag",
      label: "Tag",
      value: "{DD}.{MM}.{YYYY}"
    },
    {
      label: "Minimales Tagesmittel",
      stroke: "#279EE6",
      width: 0.5,
      points: { 
        show: false, 
      } 
    },
    {
      label: "Mittleres Tagesmittel",
      stroke: "#279EE6",
      width: 0.6,
      points: { 
        show: false, 
      } 
    },
    {
      label: "Maximales Tagesmittel",
      stroke: "#279EE6",
      width: 0.4,
      points: { 
        show: false, 
      } 
    },
    {
      label: "Gelaendeoberkante",
      stroke: "#764d30",
      width: 1.2,
      points: { 
        show: false, 
      },
      hideLegend: true,
    },
    {
      label: "Tagesmittel <?php echo $last_year; ?>",
      stroke: "#f99090",
      width: 1,
    },
    {
      label: "Tagesmittel <?php echo $this_year; ?>",
      stroke: "red",
      width: 1.6,
    },
    {
      stroke: "red",
      width: 1.5,
      points: { 
        show: true, 
      },
      hideLegend: true,
    },
  ],
  bands: [
    {
      series: [1,2],
      fill: "#CDEBF7",
      dir: 1
    },
    {
      series: [2,3],
      fill: "#CDEBF7",
      dir: 1
    }
  ],
};

// Offset for leaflet popup

function getOffset(lng, lat) {
  off_x = 0;
  off_y = 0;

  // Horizontal only left or right from point
  var offset_x_right = 400;
  var offset_x_left = -400;

  // Vertical relative between (approximation)
  var offset_y_bottom = 0;
  var offset_y_top = 550;

  var bound = map.getBounds();
  var cent_lng = (bound._northEast["lng"] + bound._southWest["lng"]) / 2;

  if (cent_lng > lng) {
    off_x = offset_x_right;
  } else {
    off_x = offset_x_left;
  }

  off_y = (lat - bound._southWest["lat"]) / (bound._northEast["lat"] - bound._southWest["lat"]) * offset_y_top;

  return [off_x, off_y];
}
</script>
