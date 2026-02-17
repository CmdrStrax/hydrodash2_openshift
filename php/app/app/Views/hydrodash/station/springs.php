<?php 
helper('text'); 
$in_tz = new DateTimeZone('UTC');
$out_tz = new DateTimeZone('Europe/Vienna');

$my_a1 = get_col_station_discharge($a1["val"], $a1["val_lt"], $a1["from"], $a1["to"]); 
$my_a2 = get_col_station_discharge($a2["val"], $a2["val_lt"], $a2["from"], $a2["to"]); 
$my_a3 = get_col_station_discharge($a3["val"], $a3["val_lt"], $a3["from"], $a3["to"]); 
$my_a4 = get_col_station_discharge($a4["val"], $a4["val_lt"], $a4["from"], $a4["to"]); 
$my_a5 = get_col_station_discharge($a5["val"], $a5["val_lt"], $a5["from"], $a5["to"]); 
$my_a6 = get_col_station_discharge($a6["val"], $a6["val_lt"], $a6["from"], $a6["to"]); 
?>

<div class="flex-fill w-100 content">
  <div class="container-fluid mt-3 mb-3">
    <div class="card bg-light justify-content-center mb-4 me-2 ms-2">
      <div class="card-body"><b class="card-title m-auto" style="font-size: 1.2em">Station <?php echo $info["name"]; ?></b><br />
      <span class="text-secondary">Flussgebiet <?= esc($catchment_name) ?></span></b></div>
    </div>

    <div class="d-flex m-1" id="chart_container">
      <div id="chart"></div>
    </div>

    <div class="mt-2 me-2 ms-2 h-100 small" style="text-align: center;" id="analysis">
      <?= esc($lt_comment["comment"]); ?><br />
      <?php if ($ds_comment != "") { echo $ds_comment . '<br />'; }; ?>
    </div>

    <div class="mt-3 me-2 ms-2 small">
      <div class="row">
        <div class="col-md">
          <div class="mb-3" style="border: 1px solid rgb(199, 199, 199); border-radius: 10px; background-color: <?= esc($my_a1[0]) ?>; padding: 15px; text-align: center;">
            <p style="margin-bottom: 5px;"><b>Gestern</b><br />
            <?= esc($my_a1[2]) ?></p>
            <p style="margin-bottom: 5px;"><b style="color: <?= esc($my_a1[5]) ?>"><?php echo $my_a1[1]; ?></b></p>
            <small style="color: <?= esc($my_a1[6]) ?>;">Tagesmittel <?php if ($a1['val'] != '') { echo '&#8709; ' . get_q_round($a1['val']) . ' l/s'; } else { echo '-'; } ?><br />
            Langjährig &#8709; <?= esc(get_q_round($a1['val_lt'])) ?> l/s<br />
            <b>Delta <?= esc($my_a1[4]) ?></b></small>
          </div>
        </div>
        <div class="col-md">
          <div class="mb-3" style="border: 1px solid rgb(199, 199, 199); border-radius: 10px; background-color: <?= esc($my_a2[0]) ?>; padding: 15px; text-align: center;">
            <p style="margin-bottom: 5px;"><b>Letzte 30 Tage</b><br />
            <?= esc($my_a2[2]) ?> - <?= esc($my_a2[3]) ?></p>
            <p style="margin-bottom: 5px;"><b style="color: <?= esc($my_a2[5]) ?>"><?php echo $my_a2[1]; ?></b></p>
            <small style="color: <?= esc($my_a2[6]) ?>;">Aktuell <?php if ($a2['val'] != '') { echo '&#8709; ' . get_q_round($a2['val']) . ' l/s'; } else { echo '-'; } ?><br />
            Langjährig &#8709; <?= esc(get_q_round($a2['val_lt'])) ?> l/s<br />
            <b>Delta <?= esc($my_a2[4]) ?></b></small>
          </div>
        </div>
        <div class="col-md">
          <div class="mb-3" style="border: 1px solid rgb(199, 199, 199); border-radius: 10px; background-color: <?= esc($my_a3[0]) ?>; padding: 15px; text-align: center;">
            <p style="margin-bottom: 5px;"><b><?= esc($last_lastmonth_str); ?></b><br />
            <?= esc($my_a3[2]) ?> - <?= esc($my_a3[3]) ?></p>
            <p style="margin-bottom: 5px;"><b style="color: <?= esc($my_a3[5]) ?>"><?php echo $my_a3[1]; ?></b></p>
            <small style="color: <?= esc($my_a3[6]) ?>;">Aktuell <?php if ($a3['val'] != '') { echo '&#8709; ' . get_q_round($a3['val']) . ' l/s'; } else { echo '-'; } ?><br />
            Langjährig &#8709; <?= esc(get_q_round($a3['val_lt'])) ?> l/s<br />
            <b>Delta <?= esc($my_a3[4]) ?></b></small>
          </div>
        </div>
        <div class="col-md">
          <div class="mb-3" style="border: 1px solid rgb(199, 199, 199); border-radius: 10px; background-color: <?= esc($my_a4[0]) ?>; padding: 15px; text-align: center;">
            <p style="margin-bottom: 5px;"><b><?= esc($last_month_str); ?></b><br />
            <?= esc($my_a4[2]) ?> - <?= esc($my_a4[3]) ?></p>
            <p style="margin-bottom: 5px;"><b style="color: <?= esc($my_a4[5]) ?>"><?php echo $my_a4[1]; ?></b></p>
            <small style="color: <?= esc($my_a4[6]) ?>;">Aktuell <?php if ($a4['val'] != '') { echo '&#8709; ' . get_q_round($a4['val']) . ' l/s'; } else { echo '-'; } ?><br />
            Langjährig &#8709; <?= esc(get_q_round($a4['val_lt'])) ?> l/s<br />
            <b>Delta <?= esc($my_a4[4]) ?></b></small>
          </div>
        </div>
        <div class="col-md">
          <div class="mb-3" style="border: 1px solid rgb(199, 199, 199); border-radius: 10px; background-color: <?= esc($my_a5[0]) ?>; padding: 15px; text-align: center;">
            <p style="margin-bottom: 5px;"><b>Heuer</b><br />
            <?= esc($my_a5[2]) ?> - <?= esc($my_a5[3]) ?></p>
            <p style="margin-bottom: 5px;"><b style="color: <?= esc($my_a5[5]) ?>"><?php echo $my_a5[1]; ?></b></p>
            <small style="color: <?= esc($my_a5[6]) ?>;">Aktuell <?php if ($a5['val'] != '') { echo '&#8709; ' . get_q_round($a5['val']) . ' l/s'; } else { echo '-'; } ?><br />
            Langjährig &#8709; <?= esc(get_q_round($a5['val_lt'])) ?> l/s<br />
            <b>Delta <?= esc($my_a5[4]) ?></b></small>
          </div>
        </div>
        <div class="col-md">
          <div class="mb-3" style="border: 1px solid rgb(199, 199, 199); border-radius: 10px; background-color: <?= esc($my_a6[0]) ?>; padding: 15px; text-align: center;">
            <p style="margin-bottom: 5px;"><b>Vorjahr</b><br />
            <?= esc($my_a6[2]) ?> - <?= esc($my_a6[3]) ?></p>
            <p style="margin-bottom: 5px;"><b style="color: <?= esc($my_a6[5]) ?>"><?php echo $my_a6[1]; ?></b></p>
            <small style="color: <?= esc($my_a6[6]) ?>;">Aktuell <?php if ($a6['val'] != '') { echo '&#8709; ' . get_q_round($a6['val']) . ' l/s'; } else { echo '-'; } ?><br />
            Langjährig &#8709; <?= esc(get_q_round($a6['val_lt'])) ?> l/s<br />
            <b>Delta <?= esc($my_a6[4]) ?></b></small>
          </div>      
        </div>
      </div>
      <div class="h-100 text-secondary" style="text-align: right; font-size: 10px;">
        Letzte Aktualisierung: <?php echo convertTimezone($lt_comment["last_modified_at"], $in_tz, $out_tz, 'd.m.Y H:i:s'); ?><br />
      </div>
    </div>

    <div class="me-2 ms-2">
      <div class="row">
        <div class="col-lg">
          <div class="card mt-4">
            <div class="card-header" id="station">Stammdaten</div>
            <div class="card-body" style="min-height: 450px;">
              <table id="stations" class="table table-condensed table-hover table-responsive mb-4">
                <tr><th scope="row">Name</th><td><?= esc($info['name']) ?></td></tr>
                <tr><th scope="row">Gewässer</th><td><?= esc($info['stream']) ?></td></tr>
                <tr><th scope="row">Flussgebiet</th><td><?= esc($catchment_name) ?></td></tr>
                <?php if (!empty($info['hzbnr'])): ?>
                <tr><th scope="row">Stationsnummer</th><td><?= esc($info['hzbnr']) ?></td></tr>
                <?php endif; ?>
                <tr><th scope="row">Stationsbetreiber</th><td><?= esc($info['operator']) ?></td></tr>
                <?php if (!empty($info['altitude'])): ?>
                <tr><th scope="row">Höhe</th><td><?= esc(number_format($info['altitude'], 0, '.', ' ')) ?> m.ü.A.</td></tr>
                <?php endif; ?>
                <?php if (!empty($info['ae'])): ?>
                <tr><th scope="row">Einzugsgebiet wirksam</th><td><?= esc(number_format($info['ae'], 1, '.', ' ')) ?> km²
                <?php endif; ?>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg">
          <div class="card mt-4 mb-4">
            <div class="card-header">Lage</div>
            <div class="card-body" style="height: 450px;">
              <div id="mapid" style="width: 100%; height: 100%;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<script>
  function getSize() {
    return {
      width: document.getElementById("chart_container").clientWidth,
      height: 600,
    }
  }

  const ruNames = {
    MMMM: ["Jänner","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"],
    MMM:  ["Jan","Feb","Mär","Apr","Mai","Jun","Jul","Aug","Sep","Okt","Nov","Dez"],
    WWWW: ["Montag","Dienstag","Mittwoh","Donnerstag","Freitag","Samstag","Sonntag"],
    WWW:  ["Mo","Di","Mi","Do","Fr","Sa","So"],
  };

  let ts;
  let chartdata = Array();
  var url = '<?php echo base_url();?>springs/chart/<?= esc($ds_id) ?>';

  $.ajax({
    type: 'GET',
    url: url,
    async: false,
    contentType: "application/json",
    dataType: 'json',
    success: function (data) {
      ts = data["ts"];
      chartdata.push(data["ts"]);
      chartdata.push(data["ts_min"]);
      chartdata.push(data["ts_mean"]);
      chartdata.push(data["ts_max"]);
      chartdata.push(data["ts_ly"]);
      chartdata.push(data["ts_ty"]);      
      chartdata.push(data["ts_ty_last"]);      
    }
  });

  const opts = {
    ...getSize(),
    tzDate: ts => uPlot.tzDate(new Date(ts * 1e3), 'Etc/UTC'),
    fmtDate: tpl => uPlot.fmtDate(tpl, ruNames),
    legend: { show: true,  },
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
        label: "Schüttung [l/s]",
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
        label: "Tagesmittel <?php echo $last_year; ?>",
        stroke: "#f76f6f",    
        width: 1.2,
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
    hooks: {
      init: [
        u => {
          [...u.root.querySelectorAll('.u-legend .u-series')].forEach((el, i) => {
            if (u.series[i].hideLegend) {
              el.style.display = 'none';
            }
          });
        }
      ]
    },
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

  let u = new uPlot(opts, chartdata, document.getElementById("chart"));

  window.addEventListener("resize", e => {
    u.setSize(getSize());
  });
</script>
