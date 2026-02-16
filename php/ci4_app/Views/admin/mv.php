<div class="col-sm-10 admin_content">
  <div class="container-fluid">
    <div class="card bg-light align-middle" style="margin-bottom: 1em;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-middle">
          <h4 class="card-title mt-auto mb-auto">Materialized Views</h4>
        </div>
      </div>
    </div>
    <div class="card justify-content-center" style="margin-top: 1em; margin-bottom: 1em;">
      <div class="card-header">Manual Refresh</div>
      <div class="card-body">
        <table style="width: 100%;">
          <tr>
            <td class="p-1" style="width: 50%"><a class="btn btn-outline-primary ms-1" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refresh/discharge" role="button">Abfluss <small class="text-secondary">(mv_discharge)</small></a></td>
            <td class="p-1" style="width: 50%"><a class="btn btn-outline-primary ms-1" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refresh/discharge_basins" role="button">Abfluss Gebiete <small class="text-secondary">(mv_discharge_basins)</small></a></td>
          </tr>
          <tr>
            <td class="p-1"><a class="btn btn-outline-primary ms-1" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refresh/watertemp" role="button">Wassertemperatur <small class="text-secondary">(mv_watertemp)</small></a></td>
            <td class="p-1"><a class="btn btn-outline-primary ms-1" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refresh/watertemp_basins" role="button">Wassertemperatur Gebiete <small class="text-secondary">(mv_discharge_basins)</small></a></td>
          </tr>
          <tr>
            <td class="p-1"><a class="btn btn-outline-primary ms-1" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refresh/precip" role="button">Niederschlag <small class="text-secondary">(mv_precip)</small></a></td>
            <td class="p-1"><a class="btn btn-outline-primary ms-1" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refresh/precip_basins" role="button">Niederschlag Gebiete <small class="text-secondary">(mv_precip_basins)</small></a></td>
          </tr>
          <tr>
            <td class="p-1"><a class="btn btn-outline-primary ms-1" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refresh/airtemp" role="button">Lufttemperatur <small class="text-secondary">(mv_airtemp)</small></a></td>
            <td class="p-1"><a class="btn btn-outline-primary ms-1" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refresh/airtemp_basins" role="button">Lufttemperatur Gebiete <small class="text-secondary">(mv_airtemp_basins)</small></a></td>
          </tr>
          <tr>
            <td class="p-1"><a class="btn btn-outline-primary ms-1" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refresh/groundwater" role="button">Grundwasser <small class="text-secondary">(mv_groundwater)</small></a></td>
            <td class="p-1"><a class="btn btn-outline-primary ms-1" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refresh/groundwater_basins" role="button">Grundwasser Gebiete <small class="text-secondary">(mv_groundwater_basins)</small></a></td>
          </tr>
          <tr>
            <td class="p-1"><a class="btn btn-outline-primary ms-1" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refresh/springs" role="button">Quellen <small class="text-secondary">(mv_springs)</small></a></td>
            <td class="p-1"><a class="btn btn-outline-primary ms-1" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refresh/springs_basins" role="button">Quellen Gebiete <small class="text-secondary">(mv_springs_basins)</small></a></td>
          </tr>
          <tr>
            <td class="p-1"><a class="btn btn-primary ms-1 mb-3" style="width: 100%; text-align: left;" href="<?php echo base_url();?>admin/mv/refreshall" role="button">Refresh all</a></td>
            <td></td>
          </tr>
        </table>
        <?php if (session('adminmessage_mv') !== null) : ?>
        <p class="text-success mt-3"><?= session('adminmessage_mv'); ?></p>
        <?php endif; ?>
        <small class="text-secondary">Ergebnisse werden an die Webapplikation per Materialized Views überreicht. Nach Änderungen in den Stammdaten oder Jobausführungen werden Materialized Views automatisch refreshed.<br />
        Bei Darstellungsfehlern können Views über diese Maske manuell aktualisiert werden.</small>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
