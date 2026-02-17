<?php helper('text'); ?>

<script type="text/javascript" class="init">
  $(document).ready(function () {
    dt_stations = $('#stations').DataTable({
      searching: true,
      paging: true,
      pageLength: -1,
      ordering: true,
      lengthMenu: [10, 25, 50, { label: 'Alle', value: -1 }],
      order: [[1, 'asc']],
      language: { sInfo: "_TOTAL_ Einzugsgebiete", sEmptyTable: "Kein Einzugsgebiet vorhanden", sInfoEmpty: "0 Einzugsgebiete", sSearch: "Suchen", sLengthMenu: "_MENU_ Einzugsgebiete anzeigen", },
      responsive: true,
    });
  });
</script>

<div class="col-sm-10 admin_content">
  <div class="container-fluid">
    <div class="card bg-light align-middle mb-3">
      <div class="card-body">
        <h4 class="card-title m-auto">Einzugsgebiete</h4>
      </div>
    </div>
    <?php if (session('adminmessage') !== null) : ?>
    <p class="text-success"><?= session('adminmessage'); ?></p>
    <?php endif; ?>
    <div class="table-responsive" style="margin-bottom: 1em">
      <table id="stations" class="table table-striped table-hover nowrap" style="width:100%">
        <thead>
          <tr>
            <th data-priority="1" scope="row" class="border-0">Name</th>
            <th data-priority="1" width="200" class="border-0">Position</th>
            <th data-priority="1" width="300" class="border-0">Anzahl Geber</th>
            <th data-priority="2" width="250" class="border-0">Letzte Änderung</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($catchments as $c): ?>
          <tr>
              <td><a href="<?php echo base_url();?>admin/catchment/update/<?= esc($c['id']) ?>"><?= esc($c['name']) ?></a></td>
              <td><?= esc($c['pos']) ?></td>
              <td><?= esc($c['count']) ?></td>
              <td class="text-secondary"><?= formatDatetime($c['last_modified_at']) ?> (<?= esc($c['last_modified_by']) ?>)</td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
    <p class="text-secondary"><i>Hinweis:</i><br class="mb-1" />Geber werden den HydroDash-Einzugsgebieten automatisch aus HyDaMS Teilflussgebiete zugeordnet (20tfg.dbf). Einzugsgebietenamen müssen hierzu ohne Ordnungsprefix übereinstimmen.<br />Bsp.: "1 Obere Drau" aus 20tfg.dbf wird dem Eintrag "Obere Drau" aus der Hydrodash2-DB zugeordnet.<br class="mb-1" />Die Sortierung in den Übersichtstabellen kann mit "Position" gesteuert werden.</p>
    <div class="d-flex justify-content-between">
      <div><a class="btn btn-success" href="<?php echo base_url();?>admin/catchment/new" role="button">Neues Einzugsgebiet</a></div>
    </div>
    </form>
  </div>
</div>
</div>
</div>
