<script>
var map = L.map('mapid', { center: [<?= esc($coord['lat']) ?>, <?= esc($coord['lon']) ?>], zoom: 14, gestureHandling: true });
map.dragging.disable();

var tile_layer_osm_swiss = L.tileLayer("https://tile.osm.ch/switzerland/{z}/{x}/{y}.png",
{
  "attribution": "OpenStreetMap contributors, Swiss OpenStreetMap Association, CC BY-SA",
  "detectRetina": true, 
  "maxNativeZoom": 18, 
  "maxZoom": 18, 
  "minZoom": 0, 
  "noWrap": false, 
  "opacity": 1, 
  "subdomains": "abc", 
  "tms": false
}).addTo(map);

var tile_layer_osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
{
  "attribution": "Data by <a href=\"http://openstreetmap.org\">OpenStreetMap</a>, (c) by OpenStreetMap contributors", 
  "detectRetina": true, 
  "maxNativeZoom": 18, 
  "maxZoom": 18, 
  "minZoom": 0, 
  "noWrap": false, 
  "opacity": 1, 
  "subdomains": "abc", 
  "tms": false
}).addTo(map);

var tile_layer_basemap_grey = L.tileLayer("https://mapsneu.wien.gv.at/basemap/bmapgrau/normal/google3857/{z}/{y}/{x}.png",
{
  "attribution": "basemap.at", 
  "detectRetina": true, 
  "maxNativeZoom": 18, 
  "maxZoom": 18, 
  "minZoom": 0, 
  "noWrap": false, 
  "opacity": 1, 
  "subdomains": "abc", 
  "tms": false
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
  "tms": false
}).addTo(map);

var tile_layer_basemap = L.tileLayer("https://mapsneu.wien.gv.at/basemap/geolandbasemap/normal/google3857/{z}/{y}/{x}.png", {
  "attribution": "basemap.at", 
  "detectRetina": true, 
  "maxNativeZoom": 18, 
  "maxZoom": 18, 
  "minZoom": 0, 
  "noWrap": false, 
  "opacity": 1, 
  "tms": false
}).addTo(map);

var tile_layer_basemap_overlay = L.tileLayer("https://mapsneu.wien.gv.at/basemap/bmapoverlay/normal/google3857/{z}/{y}/{x}.png", {
  "attribution": "basemap.at", 
  "detectRetina": true, 
  "maxNativeZoom": 18, 
  "maxZoom": 18, 
  "minZoom": 0, 
  "noWrap": false, 
  "opacity": 1, 
  "tms": false
}).addTo(map);

var tile_layer_basemap_ortho = L.tileLayer("https://mapsneu.wien.gv.at/basemap/bmaporthofoto30cm/normal/google3857/{z}/{y}/{x}.jpeg",  {
  "attribution": "basemap.at", 
  "detectRetina": true, 
  "maxNativeZoom": 18, 
  "maxZoom": 18, 
  "minZoom": 0, 
  "noWrap": false, 
  "opacity": 1, 
  "tms": false
}).addTo(map);

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
  {"opacity": 0.75}
).addTo(map);

var myPopup = "<div style='text-align: center'><b><?= esc($info['name']) ?><?php if (!is_null($info['stream'])) { echo " / " . $info['stream']; }; echo "</b>"; if (!is_null($info['hzbnr'])) { echo "<br />(" . $info['hzbnr'] . ")"; };  ?></b></div>";
var myOptions = { className: 'leaflet-station-popup-content' }

L.marker([<?= esc($coord['lat']) ?>, <?= esc($coord['lon']) ?>]).addTo(map).bindPopup(myPopup, myOptions);

var layer_control = {
  base_layers : {
    "OSM" : tile_layer_osm_swiss,
    "Austria Hillshade (basemap.at)": tile_layer_basemap_gelaende,
    "Austria Basemap (basemap.at)" : tile_layer_basemap,
    "Austria Grey (basemap.at)" : tile_layer_basemap_grey,
    "Austria Orthofotos (basemap.at)" : tile_layer_basemap_ortho,
  },
  overlays :  {
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

image_overlay_brighten_25.remove();
image_overlay_brighten_50.remove();
image_overlay_brighten_75.remove();
tile_layer_basemap.remove();
tile_layer_basemap_ortho.remove();
tile_layer_basemap_overlay.remove();
tile_layer_osm_swiss.remove();
tile_layer_basemap_gelaende.remove();
</script>
