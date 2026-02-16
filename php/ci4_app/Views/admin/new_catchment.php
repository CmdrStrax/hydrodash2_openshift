<?php 
  helper('text'); 
?>

<div class="col-sm-10 admin_content">
  <div class="container-fluid">
    <div class="card bg-light justify-content-center" style="margin-bottom: 1em;">
      <div class="card-body">
        <h4 class="card-title m-auto">Neues Einzugsgebiet</h4>
      </div>
    </div>    
    <div class="card justify-content-center" style="margin-top: 1em; margin-bottom: 1em;">
      <div class="card-header">Einzugsgebiet</div>
      <div class="card-body">
      <form action="<?php echo base_url();?>admin/catchment/new" method="post">
      <?= csrf_field() ?>
      <?php
        $validation = \Config\Services::validation();
        session()->getFlashdata('error');
      ?>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="input" name="name" class="form-control" id="name" value="<?= set_value('name') ?>">
        <span class="text-danger"><?= esc($validation->getError('name'));?></span>
      </div>
      <div class="mb-3">
        <label for="name_short" class="form-label">Kurzname</label>
        <input type="input" name="name_short" class="form-control" id="name_short" value="<?= set_value('name_short') ?>">
        <span class="text-danger"><?= esc($validation->getError('name_short'));?></span>
      </div>
      <div class="mb-3">
        <label for="pos" class="form-label">Position<br />
        <small class="text-secondary">Position des Einzugsgebiet in den Übersichtstabellen</small></label>
        <input type="input" name="pos" class="form-control" id="pos" value="<?= set_value('pos') ?>">
        <span class="text-danger"><?= esc($validation->getError('pos'));?></span>
      </div>
      <?php if (session('adminmessage') !== null) : ?>
      <p class="text-success"><?= session('adminmessage'); ?></p>
      <?php endif; ?>
      <input type="submit" name="submit" class="btn btn-primary" value="Einzugsgebiet anlegen">
      </form>
      </div>
    </div>
    <div class="d-flex justify-content-between">
      <a class="btn btn-outline-primary ms-1" href="<?php echo base_url();?>admin/catchment/" role="button">Zurück</a>
    </div>
  </div>
</div>
</div>
</div>
