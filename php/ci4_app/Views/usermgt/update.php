<div class="col-sm-10 admin_content">
  <div class="container-fluid">
    <div class="card bg-light justify-content-center" style="margin-bottom: 1em;">
      <div class="card-body"><h4 class="card-title m-auto">Benutzer editieren</h4></div>
    </div>
    <div class="card justify-content-center"  style="margin-bottom: 1em;" id="base">
      <div class="card-header">Benutzer editieren</div>
      <div class="card-body">
        <form action="<?php echo base_url();?>admin/usermgt/update" method="post">
          <?= csrf_field() ?>
          <input type="input" name="id" class="form-control text-secondary" value="<?= esc($id) ?>" readonly hidden>
          <div class="mb-3">
            <label for="user" class="form-label">Benutzername</label>
            <input type="input" name="user" class="form-control" value="<?= esc($user) ?>" readonly disabled>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">E-Mail</label>
            <input type="input" class="form-control" name="email" value="<?= esc($email) ?>">
          </div>
          <div class="mb-3">
            <label for="user_created_at" class="form-label">Angelegt am</label>
            <input type="input" class="form-control text-secondary" name="user_created_at" value="<?= esc($user_created_at) ?>" readonly disabled>
          </div>
          <?= session()->getFlashdata('error') ?>
          <p class="text-primary" style="margin-top: 0.5em;"><?= session('adminmessage'); ?></p>
          <?php echo empty($validation->getErrors()) ? $redirectedErrorsBase : $validation->listErrors() ?>     
          <div class="d-flex justify-content-between">
            <div><input type="submit" name="submit" class="btn btn-primary" value="Änderungen speichern"></div>
          </div>
        </form>
      </div>
    </div>
    <div class="card justify-content-center" style="margin-bottom: 1em;" id="pw">
      <div class="card-header">Passwort zurücksetzen</div>
        <div class="card-body">
          <form action="<?php echo base_url();?>admin/usermgt/password/<?= esc($id) ?>" method="post">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label for="id" class="form-label">Neues Passwort</label>
            <input type="password" name="new_password_1" id="new_password_1" class="form-control" value="" autocomplete="new-password">
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Neues Passwort wiederholen</label>
            <input type="password" name="new_password_2" id="new_password_2" class="form-control" value="" autocomplete="new-password">
          </div>
          <?= session()->getFlashdata('error') ?>
          <?php echo empty($validation->getErrors()) ? $redirectedErrorsPw : $validation->listErrors() ?>
          <input type="submit" name="submit" class="btn btn-primary" value="Passwort ändern">
          <p class="text-primary" style="margin-top: 0.5em;"><?= session('adminmessage_pw'); ?></p>
          </form>
      </div>
    </div>
    <div class="d-flex justify-content-between">
      <div><a class="btn btn-outline-primary" href="<?php echo base_url("admin/usermgt");?>#edit" role="button">Zur Benutzerübersicht</a></div>
      <div><a class="btn btn-danger ms-auto" role="button" href="<?php echo base_url();?>admin/usermgt/delete/<?= esc($id) ?>" onclick="return confirm('Soll der Benutzer wirklich gelöscht werden?\nKann nicht rückgängig gemacht werden.');">Benutzer Löschen</a></div>
    </div>    
  </div>
</div>
</div>
</div>
