<?php 
  helper('text'); 
?>

<div class="col-sm-10 admin_content">
  <div class="container-fluid">
    <div class="card bg-light justify-content-center" style="margin-bottom: 1em;">
      <div class="card-body">
        <h4 class="card-title m-auto">Neue Analyse</h4>
      </div>
    </div>    
    <div class="card justify-content-center" style="margin-top: 1em; margin-bottom: 1em;">
      <div class="card-header">Analyse</div>
      <div class="card-body">
      <form action="<?php echo base_url();?>admin/analysis/new/<?= esc($id) ?>" method="post">
      <?= csrf_field() ?>
      <?php
        $validation = \Config\Services::validation();
        session()->getFlashdata('error');
      ?>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <select class="form-select" aria-label="Analysename" name="name" onclick="fill_form(this.value);">
          <?php if (!in_array('last_day_mean', $analyses)): ?>
          <option value="last_day_mean">last_day_mean</option>
          <?php endif ?>
          <?php if (!in_array('last_30days_mean', $analyses)): ?>
          <option value="last_30days_mean">last_30days_mean</option>
          <?php endif ?>
          <?php if (!in_array('last_lastmonth_mean', $analyses)): ?>
          <option value="last_lastmonth_mean">last_lastmonth_mean</option>
          <?php endif ?>
          <?php if (!in_array('last_month_mean', $analyses)): ?>
          <option value="last_month_mean">last_month_mean</option>
          <?php endif ?>
          <?php if (!in_array('this_year_mean', $analyses)): ?>
          <option value="this_year_mean">this_year_mean</option>
          <?php endif ?>
          <?php if (!in_array('last_year_mean', $analyses)): ?>
          <option value="last_year_mean">last_year_mean</option>
          <?php endif ?>
          <?php if (!in_array('last_30days_sum', $analyses)): ?>
          <option value="last_30days_sum">last_30days_sum</option>
          <?php endif ?>
          <?php if (!in_array('last_lastmonth_sum', $analyses)): ?>
          <option value="last_lastmonth_sum">last_lastmonth_sum</option>
          <?php endif ?>
          <?php if (!in_array('last_month_sum', $analyses)): ?>
          <option value="last_month_sum">last_month_sum</option>
          <?php endif ?>
          <?php if (!in_array('this_year_sum', $analyses)): ?>
          <option value="this_year_sum">this_year_sum</option>
          <?php endif ?>
          <?php if (!in_array('last_year_sum', $analyses)): ?>
          <option value="last_year_sum">last_year_sum</option>
          <?php endif ?>
        </select>
        <span class="text-danger"><?= esc($validation->getError('name'));?></span>
      </div>
      <div class="mb-3">
        <label for="name_short" class="form-label">Kurzname</label>
        <input type="input" name="name_short" class="form-control" id="name_short" value="<?= set_value('name_short') ?>">
        <span class="text-danger"><?= esc($validation->getError('name_short'));?></span>
      </div>
      <div class="mb-3">
        <label for="stat" class="form-label">Statistische Auswertung</label>
        <input type="input" name="stat" class="form-control" id="stat" value="<?= set_value('stat') ?>">
        <span class="text-danger"><?= esc($validation->getError('stat'));?></span>
      </div>
      <div class="mb-3">
        <label for="period" class="form-label">Zeitraum</label>
        <input type="period" class="form-control" name="period" id="period" value="<?= set_value('period') ?>">
        <span class="text-danger"><?= esc($validation->getError('period'));?></span>
      </div>
      <div class="mb-3">
        <label for="comment" class="form-label">Kommentar</label>
        <input type="comment" class="form-control" name="comment" id="comment" value="<?= set_value('comment') ?>">
        <span class="text-danger"><?= esc($validation->getError('comment'));?></span>
      </div>
      <?php if (session('adminmessage') !== null) : ?>
      <p class="text-success"><?= session('adminmessage'); ?></p>
      <?php endif; ?>
      <input type="submit" name="submit" class="btn btn-primary" value="Analyse anlegen">
      </form>
      </div>
    </div>
    <div class="d-flex justify-content-between">
      <a class="btn btn-outline-primary ms-1" href="<?php echo base_url();?>admin/device/update/<?= esc($id) ?>" role="button">Zurück</a>
    </div>
  </div>
</div>
</div>
</div>

<script>
  function fill_form(val) {
    if (val == 'last_day_mean') {
      document.getElementById("name_short").value = 'ldm';
      document.getElementById("stat").value = 'mean';
      document.getElementById("period").value = '1d';
    } else if (val == 'last_30days_mean') {
      document.getElementById("name_short").value = 'l30dm';
      document.getElementById("stat").value = 'mean';
      document.getElementById("period").value = '30d';
    } else if (val == 'last_lastmonth_mean') {
      document.getElementById("name_short").value = 'llmm';
      document.getElementById("stat").value = 'mean';
      document.getElementById("period").value = '1m';
    } else if (val == 'last_month_mean') {
      document.getElementById("name_short").value = 'lmm';
      document.getElementById("stat").value = 'mean';
      document.getElementById("period").value = '1m';
    } else if (val == 'this_year_mean') {
      document.getElementById("name_short").value = 'tym';
      document.getElementById("stat").value = 'mean';
      document.getElementById("period").value = '';
    } else if (val == 'last_year_mean') {
      document.getElementById("name_short").value = 'lym';
      document.getElementById("stat").value = 'mean';
      document.getElementById("period").value = '1y';
    } else if (val == 'last_30days_sum') {
      document.getElementById("name_short").value = 'l30ds';
      document.getElementById("stat").value = 'sum';
      document.getElementById("period").value = '30d';
    } else if (val == 'last_lastmonth_sum') {
      document.getElementById("name_short").value = 'llms';
      document.getElementById("stat").value = 'sum';
      document.getElementById("period").value = '1m';
    } else if (val == 'last_month_sum') {
      document.getElementById("name_short").value = 'lms';
      document.getElementById("stat").value = 'sum';
      document.getElementById("period").value = '1m';
    } else if (val == 'this_year_sum') {
      document.getElementById("name_short").value = 'tys';
      document.getElementById("stat").value = 'sum';
      document.getElementById("period").value = '';
    } else if (val == 'last_year_sum') {
      document.getElementById("name_short").value = 'lys';
      document.getElementById("stat").value = 'sum';
      document.getElementById("period").value = '1y';
    }
  }

  fill_form("last_day_mean");
</script>