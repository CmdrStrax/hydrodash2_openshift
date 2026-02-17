<?php 
  helper('text'); 
?>

<div class="col-sm-10 admin_content">
  <div class="container-fluid">
    <div class="card bg-light justify-content-center" style="margin-bottom: 1em;">
      <div class="card-body">
          <h4 class="card-title m-auto">Einzugsgebiet <?= $catchment['name'] ?></h4>
      </div>
    </div>    
    <div class="card justify-content-center" style="margin-top: 1em; margin-bottom: 1em;">
      <div class="card-header">Einzugsgebiet</div>
      <div class="card-body">
      <form action="<?php echo base_url();?>admin/catchment/update/<?= esc($catchment['id']) ?>" method="post">
      <?= csrf_field() ?>
      <?php
        $validation = \Config\Services::validation();
        session()->getFlashdata('error');
      ?>
      <div class="mb-3">
        <label for="name" class="form-label">Name
        <?php if ($catchment["count"] > 0) { echo "<br /><small class=\"text-secondary\">Keine Namensänderung möglich (dem Einzugsgebiet sind bereits Geber zugeordnet)</small>"; } ?>
        </label>
        <input type="input" name="name" class="form-control<?php if ($catchment["count"] > 0) { echo " text-secondary"; } ?>" value="<?= $catchment['name'] ?>" <?php if ($catchment["count"] > 0) { echo " readonly"; } ?>>
        <span class="text-danger"><?= esc($validation->getError('name'));?></span>
      </div>
      <div class="mb-3">
        <label for="name_short" class="form-label">Kurzname</label>
        <input type="input" name="name_short" class="form-control" value="<?= $catchment['name_short'] ?>">
        <span class="text-danger"><?= esc($validation->getError('name_short'));?></span>
      </div>
      <div class="mb-3">
        <label for="pos" class="form-label">Position<br />
        <small class="text-secondary">Position des Einzugsgebiet in den Übersichtstabellen</small></label>
        <input type="number" name="pos" class="form-control" value="<?= $catchment['pos'] ?>">
        <span class="text-danger"><?= esc($validation->getError('pos'));?></span>
      </div>
      <?php if (session('adminmessage') !== null) : ?>
      <p class="text-success"><?= session('adminmessage'); ?></p>
      <?php endif; ?>
      <p>Anzahl Geber: <?php if ($catchment["count"] > 0) { echo $catchment["count"] . " <small class=\"text-secondary\">(keine Namensänderung / Löschung möglich)</small>"; } else { echo "0"; } ?></p>
      <input type="submit" name="submit" class="btn btn-primary" value="Änderungen speichern">
      </form>
      </div>
    </div>
    <div class="d-flex justify-content-between">
      <a class="btn btn-outline-primary ms-1" href="<?php echo base_url();?>admin/catchment/" role="button">Zurück</a>
      <a class="btn btn-danger ms-auto<?php if($catchment["count"] > 0) { echo " disabled"; } ?>" href="<?php echo base_url();?>admin/catchment/delete/<?= esc($catchment['id']) ?>" role="button" onclick="return confirm('Soll das Einzugsgebiet wirklich gelöscht werden?\nDer Vorgang kann nicht rückgängig gemacht werden.');">Einzugsgebiet löschen</a>
    </div>
  </div>
</div>
</div>
</div>