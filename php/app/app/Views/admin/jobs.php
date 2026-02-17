<?php helper('text'); ?>

<script type="text/javascript" class="init">
  $(document).ready(function () {
    jobs_finished = $('#jobs_finished').DataTable({
      searching: true,
      paging: true,
      pageLength: 25,
      ordering: true,
      lengthMenu: [10, 25, 50, { label: 'Alle', value: -1 }],
      order: [[4, 'desc']],
      language: { sInfo: "_TOTAL_ Geber", sEmptyTable: "Keine Geber vorhanden", sInfoEmpty: "0 Geber", sSearch: "Suchen", sLengthMenu: "_MENU_ Einträge anzeigen", },
      responsive: true,
    });
  });
</script>

<div class="col-sm-10 admin_content">
  <div class="container-fluid">
    <div class="card bg-light align-middle" style="margin-bottom: 1em;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-middle">
          <h4 class="card-title mt-auto mb-auto">Jobs</h4>
        </div>
      </div>
    </div>
    <div class="card justify-content-center" style="margin-top: 1em; margin-bottom: 1em;">
      <div class="card-header">Offene Jobs</div>
      <div class="card-body">
      <div class="table-responsive" style="margin-bottom: 1em">
        <table id="jobs_table" class="table table-striped table-hover nowrap" style="width:100%">
          <thead>
            <tr>
              <th data-priority="1" scope="row" class="border-0">Station</th>
              <th data-priority="1" scope="row" class="border-0">Parameter</th>
              <th data-priority="1" class="border-0">Initiiert durch</th>
              <th data-priority="1" class="border-0">Initiiert um</th>
              <th data-priority="1" class="border-0" width="160">Abbrechen</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($jobs) == 0): ?>
              <td class="text-secondary"><i>Keine Jobs in der Pipeline</i></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            <?php else: ?>
            <?php foreach ($jobs as $j): ?>
            <tr>
                <td class="align-middle"><a href="<?php echo base_url();?>\admin\device\update\<?php echo $j["ds_id"];?>"><?php if ($j['name'] != '') { echo $j['name']; } else { echo $j['zrid']; } ?></a></td>
                <td class="align-middle"><?php if ($j['parameter'] != '') { echo $j['parameter']; } ?></td>
                <td class="align-middle"><?php echo $j['initiated_by']; ?></td>
                <td class="align-middle"><?php echo formatDatetime($j['initiated_at']); ?></td>
                <td class="align-middle"><a class="btn btn-danger ms-1 btn-sm" style="width: 150px" href="<?php echo base_url();?>admin/jobs/<?= esc($j['ds_id']) ?>/del" role="button" onclick="return confirm('Soll der Job wirklich abgebrochen werden?');">Job abbrechen</a></td>
            </tr>
            <?php endforeach ?>
            <?php endif ?>
          </tbody>
        </table>
        <?php if (session('adminmessage_jobs') !== null) : ?>
        <p class="text-success"><?= session('adminmessage_jobs'); ?></p>
        <?php endif; ?>
        <small class="text-secondary">Die Abarbeitung von bis zu 10 offene Jobs erfolgt per Cronjob in den kommenden 5 Minuten. Bei mehr als 10 Jobs erfolgt die Abarbeitung gestaffelt.<br />Neue Jobs können unter Geber erteilt werden.</small>
      </div>
    </div>
    </div>
    <div class="card justify-content-center" style="margin-top: 1em; margin-bottom: 1em;">
      <div class="card-header">Abgeschlossene Jobs</div>
      <div class="card-body">
      <div class="table-responsive" style="margin-bottom: 1em">
        <table id="jobs_finished" class="table table-striped table-hover nowrap" style="width:100%">
          <thead>
            <tr>
              <th data-priority="1" scope="row" class="border-0">Station</th>
              <th data-priority="1" scope="row" class="border-0">Parameter</th>
              <th data-priority="1" class="border-0">Initiiert durch</th>
              <th data-priority="1" class="border-0">Initiiert um</th>
              <th data-priority="1" class="border-0">Fertiggstellt</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($jobs_archive as $j): ?>
            <tr>
              <td><a href="<?php echo base_url();?>\admin\device\update\<?php echo $j["ds_id"];?>"><?php if ($j['name'] != '') { echo $j['name']; } else { echo $j['zrid']; } ?></a></td>
              <td><?php if ($j['parameter'] != '') { echo $j['parameter']; } ?></td>
              <td><?php echo $j['initiated_by']; ?></td>
              <td><?php echo formatDatetime($j['initiated_at']); ?></td>
              <td><?php echo formatDatetime($j['finished_at']); ?></td>
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
        <?php if (session('adminmessage_jobs') !== null) : ?>
        <p class="text-success"><?= session('adminmessage_jobs'); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
