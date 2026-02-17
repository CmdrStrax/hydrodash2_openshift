<?php helper('text'); ?>

<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="checked" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="unchecked" viewBox="0 0 16 16">
    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
  </symbol>
</svg>

<div class="col-sm-10 admin_content">
  <div class="container-fluid">
    <div class="card bg-light align-middle" style="margin-bottom: 1em;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-middle">
          <h4 class="card-title mt-auto mb-auto">Geber</h4>
          <a class="btn btn-success" href="<?php echo base_url();?>admin/device/new" role="button">Neuer Geber</a>
        </div>
      </div>
    </div>
    <?php if ($webjob): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Hinweis:</strong> Einige aktive Stationen sind im Webjob deaktiviert. <a href="javascript:orderDt();">Nach oben sortieren</a>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    <?php if (session('adminmessage') !== null) : ?>
    <p class="text-success"><?= session('adminmessage'); ?></p>
    <?php endif; ?>
    <div class="d-flex justify-content-end mb-2">
      <a href="javascript:standardSort();" class="me-1 ms-1">Standardsortierung</a> | 
      <a href="javascript:lastModified();" id="lastModified" class="ms-1">Last modified einblenden</a>
    </div>
    <div class="table-responsive" style="margin-bottom: 1em">
      <table id="stations" class="table table-striped table-hover nowrap" style="width:100%">
        <thead>
          <tr>
            <th data-priority="10" style="display:none;">id</th>
            <th data-priority="1" scope="row" class="border-0">Name</th>
            <th data-priority="1" class="border-0">Parameter</th>
            <th data-priority="4" class="border-0">Einzugsgebiet</th>
            <th data-priority="3" class="border-0">Long-term<br /><span class="text-secondary" style="font-weight: normal !important;">von</span></th>
            <th data-priority="3" class="border-0">Long-term<br /><span class="text-secondary" style="font-weight: normal !important;">bis</span></th>
            <th data-priority="2" class="border-0">Letzter Lauf<br /><span class="text-secondary" style="font-weight: normal !important;">Zeitreihe</span></th>
            <th data-priority="2" class="border-0">Letzter Lauf<br /><span class="text-secondary" style="font-weight: normal !important;">Analyse</span></th>
            <th data-priority="1" class="border-0">Aktiv<br /><span class="text-secondary" style="font-weight: normal !important;">Dashboard</span></th>
            <th data-priority="1" class="border-0">Aktiv<br /><span class="text-secondary" style="font-weight: normal !important;">Webjob</span></th>
            <th data-priority="1" class="border-0">Letzte Änderung<br /><span class="text-secondary" style="font-weight: normal !important;">UTC</span></th>
          </tr>
        </thead>
        <tbody>
          <?php $ids = array(); ?>
          <?php foreach ($ds as $d): ?>
          <?php if (!in_array($d['id'], $ids)): ?>
          <tr id="dev_<?= esc($d['id']) ?>">
              <td><?= esc($d['id']) ?></td>
              <td>
              <?php if ($d['name'] != ''): ?>
                <a href="<?php echo base_url();?>admin/device/update/<?= esc($d['id']) ?>"><?= esc($d['name']) ?></a> <small class="text-secondary">(<?= esc($d['dbmnr']) ?><?php if ($d['hzbnr'] != '') { echo ' / ' . $d["hzbnr"]; } ?>)</small></td>
              <?php else: ?>
                <a href="<?php echo base_url();?>admin/device/update/<?= esc($d['id']) ?>"><?= esc($d['zrid']) ?></a>
              <?php endif; ?>
              <td><?php if ($d['parameter'] == "") { echo "-"; } else { echo $d['parameter']; } ?></td>
              <td><?php if ($d['catchment_name'] == "") { echo "-"; } else { echo $d['catchment_name']; } ?></td>
              <td><?= formatDatetime($d['lt_from'], 'Y-m-d') ?></td>
              <td><?= formatDatetime($d['lt_to'], 'Y-m-d') ?></td>
              <td class="text-secondary"><?= formatDatetimeAdmin($d['last_ts'], 'Y-m-d h:i') ?></td>
              <td class="text-secondary"><?= formatDatetimeAdmin($d['last_analyse'], 'Y-m-d h:i') ?></td>
              <td class="dash_active"><?= $d['active'] ?></td>
              <td class="webjob_active"><?= $d['webjob'] ?></td>
              <td class="last_modified_tab text-secondary"><?= formatDatetime($d['last_modified_at'], 'Y-m-d h:i') ?> (<?= $d['last_modified_by'] ?>)</td>
          </tr>
          <?php array_push($ids, $d['id']); ?>
          <?php endif; ?>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-between">
      <div><a class="btn btn-success" href="<?php echo base_url();?>admin/device/new" role="button">Neuer Geber</a></div>
    </div>
    </form>
  </div>
</div>
<div aria-live="polite" aria-atomic="true" >
  <div id="my_toasts" class="toast-container position-fixed bottom-0 end-0 p-3">
  </div>
</div>
</div>
</div>

<script type="text/javascript" class="init">
  DataTable.type('num', 'className', 'dt-body-right');
  DataTable.type('num-fmt', 'className', 'dt-body-right');
  DataTable.type('date', 'className', 'dt-body-right');
 
  dt_stations = $('#stations').DataTable({
    searching: true,
    paging: true,
    pageLength: -1,
    ordering: true,
    lengthMenu: [10, 25, 50, { label: 'Alle', value: -1 }],
    order: [[2, 'asc'], [3, 'asc'], [1, 'asc']],
    orderMulti: true,
    language: { sInfo: "_TOTAL_ Geber", sEmptyTable: "Keine Geber vorhanden", sInfoEmpty: "0 Geber", sSearch: "Suchen", sLengthMenu: "_MENU_ Einträge anzeigen", },
    responsive: true,
    columns: [ { visible: false }, {}, {}, {}, {}, {}, {}, {}, {}, {}, { visible: false } ],
    drawType: 'none',
    rowCallback: function(row, data, dataIndex) {
        var dash = data[8];
        var webjob = data[9];

        $('td:eq(3)', row).css('text-align', 'left');
        $('td:eq(4)', row).css('text-align', 'left');

        if (dash == 't') {
            $('td:eq(7)', row).css('text-align', 'center');
            $('td:eq(7)', row).html('<a href="javascript:activeDevice(' + data[0] + ');" title="Geber im Dashboard deaktivieren"><svg class="bi me-2" width="16" height="16" fill="#39a905ff"><use xlink:href="#checked"/></svg></a>');
        } else {
            $('td:eq(7)', row).css('text-align', 'center');
            $('td:eq(7)', row).html('<a href="javascript:activeDevice(' + data[0] + ');" title="Geber im Dashboard aktivieren"><svg class="bi me-2" width="16" height="16" fill="#EE4B2B"><use xlink:href="#unchecked"/></svg></a>');
        }

        if (webjob == 't') {
            $('td:eq(8)', row).css('text-align', 'center');
            $('td:eq(8)', row).html('<svg class="bi me-2" width="16" height="16" fill="darkgrey"><title>Station in Webjob aktiv</title><use xlink:href="#checked"/></svg>');
        } else {
            $('td:eq(8)', row).css('text-align', 'center');
            $('td:eq(8)', row).html('<svg class="bi me-2" width="16" height="16" fill="darkgrey"><title>Station in Webjob deaktiv</title><use xlink:href="#unchecked"/></svg>');
        }

        if (dash == 't' && webjob == 'f') {
            $('td:eq(7)', row).css('background-color', '#feffebff');
            $('td:eq(8)', row).css('background-color', '#feffebff');
        } 
      },
  });

  var lastModifiedVisible = false;

  function orderDt() {
    dt_stations.order([8, 'desc'],[9, 'asc'],[2, 'asc'],[1, 'asc']).draw();
    $(".alert").alert('close');
  }

  function lastModified() {
    if (lastModifiedVisible) {
      dt_stations.column(10).visible(false).draw();
      $("#lastModified").html('Last modified einblenden');
    } else {
      dt_stations.column(10).visible(true).draw();
      $("#lastModified").html('Last modified ausblenden');
    }

    lastModifiedVisible = !lastModifiedVisible;    
  }

  function standardSort() {
    dt_stations.order([2, 'asc'], [3, 'asc'], [1, 'asc']).draw();
  }

  var toast_id = 0;

  async function activeDevice(id) {
    await fetch('<?php echo base_url();?>admin/device/active/' + id, { 
      method: 'GET'
    })
    .then(function(response) { 
      return response.json();
    })
    .then(function(json) {
      if (json.active){
        $("#dev_" + id + ' td.dash_active').html('<a href="javascript:activeDevice(' + id + ');" title="Geber im Dashboard deaktivieren"><svg class="bi me-2" width="16" height="16" fill="#39a905ff"><use xlink:href="#checked"/></svg></a>');
        alertType = 'text-bg-success';
        alertHeader = 'Geber aktiviert';

        if ($("#dev_" + id + ' td.webjob_active').html().includes('#unchecked')) {
          $("#dev_" + id + ' td.webjob_active').css("background-color", "rgb(254, 255, 235)");
          $("#dev_" + id + ' td.dash_active').css("background-color", "rgb(254, 255, 235)");
        }
      } else {
        $("#dev_" + id + ' td.dash_active').html('<a href="javascript:activeDevice(' + id + ');" title="Geber im Dashboard aktivieren"><svg class="bi me-2" width="16" height="16" fill="#EE4B2B"><use xlink:href="#unchecked"/></svg></a>');
        alertType = 'text-bg-danger';
        alertHeader = 'Geber deaktiviert';

        $("#dev_" + id + ' td.webjob_active').css("background-color", "#fff");
        $("#dev_" + id + ' td.dash_active').css("background-color", "#fff");
      }

      var now = new Date();
      $("#dev_" + id + ' td.last_modified_tab').html(now.getUTCFullYear() + '-' + ("0" + (now.getUTCMonth() + 1)).slice(-2) + '-' + ("0" + (now.getUTCDate())).slice(-2) +
        " " + ("0" + (now.getUTCHours())).slice(-2) + ':' + ("0" + (now.getUTCMinutes())).slice(-2) + ' (<?php echo auth()->user()->username; ?>)');

      var d = new Date(json.dt);
      const myToasts = document.getElementById('my_toasts');

      const wrapper = document.createElement('div');
      wrapper.innerHTML = 
      '<div id="my_toast_' + toast_id + '" class="toast mb-2" role="alert" aria-live="assertive" aria-atomic="true">\
        <div class="toast-header ' + alertType + '">\
          <strong class="me-auto">' + alertHeader + '</strong>\
          <small>' + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2) + '</small>\
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>\
        </div>\
        <div class="toast-body">\
          ' + json.text + '.\
        </div>\
      </div>';
      
      myToasts.append(wrapper);
      const toast = document.getElementById('my_toast_' + toast_id);
      const t = new bootstrap.Toast(toast);
      t.show();
      toast_id++;
    });
  }

</script>