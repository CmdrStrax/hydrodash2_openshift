<?php 
helper('text'); 
?>

<div class="col-sm-10 admin_content">
  <div class="container-fluid">
    <div class="card bg-light justify-content-center" style="margin-bottom: 1em;">
      <div class="card-body">
        <h4 class="card-title m-auto">Hallo <?= esc($user); ?>!</h4>
      </div>
    </div>
    <div class="card justify-content-center" style="margin-bottom: 1em;" id="base">
      <div class="card-header">Mein Benutzer</div>
      <div class="card-body">
        <form action="<?php echo base_url();?>admin/usermgt/email" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label for="user" class="form-label">Benutzername</label>
          <input class="form-control" type="text" name="user" id="user" value="<?= esc($user) ?>" readonly disabled>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">E-Mail</label>
          <input type="text" name="email" id="email" class="form-control" value="<?= esc($email) ?>">
        </div>
        <div class="mb-3">
          <label for="mail" class="form-label">Zugeordneten Gruppen</label>
          <input type="text" name="mail" id="mail" class="form-control" value="<?php $f = true; foreach ($groups as $g) { if (!$f) { echo ", "; }; echo $g; $f = false; } ?>" readonly disabled>
        </div>
        <div class="mb-3">
          <label for="mail" class="form-label">Angelegt am <small class="text-secondary"> (UTC)</small></label>
          <input type="text" name="mail" id="mail" class="form-control" value="<?php echo $user_created_at; ?>" readonly disabled>
        </div>
        <?php echo empty($validation->getErrors()) ? $redirectedErrorsMail : $validation->listErrors() ?>
        <input type="submit" name="submit" class="btn btn-primary" value="E-Mail ändern">
        <p class="text-primary" style="margin-top: 0.5em;"><?= session('adminmessage_email'); ?></p>
        </form>
      </div>
    </div>
    <div class="card justify-content-center" style="margin-bottom: 1em;" id="pw">
      <div class="card-header">Mein Passwort ändern</div>
        <div class="card-body">
          <form action="<?php echo base_url();?>admin/usermgt/password" method="post">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label for="id" class="form-label">Aktuelles Passwort</label>
            <input type="password" name="old_password" id="old_password" class="form-control" value="" autocomplete="new-password">
          </div>
          <div class="mb-3">
            <label for="id" class="form-label">Neues Passwort</label>
            <input type="password" name="new_password_1" id="new_password_1" class="form-control" value="" autocomplete="new-password">
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Neues Passwort wiederholen</label>
            <input type="password" name="new_password_2" id="new_password_2" class="form-control" value="" autocomplete="new-password">
          </div>
          <?php echo empty($validation->getErrors()) ? $redirectedErrorsPw : $validation->listErrors() ?>
          <input type="submit" name="submit" class="btn btn-primary" value="Passwort ändern">
          <p class="text-primary" style="margin-top: 0.5em;"><?= session('adminmessage_pw'); ?></p>
          </form>
      </div>
    </div>
    <div class="card justify-content-center" style="margin-bottom: 1em;" id="new">
      <div class="card-header">Neuen Benutzer anlegen</div>
      <div class="card-body">
          <form action="<?php echo base_url();?>admin/usermgt/new" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
              <label for="username" class="form-label">Benutzername</label>
              <input type="input" name="username" id="username" class="form-control" value="">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">E-Mail</label>
              <input type="input" name="email" id="email" class="form-control" value="">
            </div>
            <div class="mb-3">
              <label for="pw_1" class="form-label">Passwort</label>
              <input type="password" name="pw_1" id="pw_1" class="form-control" value="" autocomplete="new-password">
            </div>
            <div class="mb-3">
              <label for="pw_2" class="form-label">Passwort wiederholen</label>
              <input type="password" name="pw_2" id="pw_2" class="form-control" value="" autocomplete="new-password">
            </div>
            <?php echo empty($validation->getErrors()) ? $redirectedErrorsNew : $validation->listErrors() ?>
            <input type="submit" name="submit" class="btn btn-primary" value="Benutzer anlegen">
            <p class="text-primary" style="margin-top: 0.5em;"><?= session('adminmessage_newuser'); ?></p>
          </form>
          </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="card justify-content-center" style="margin-bottom: 1em;" id="edit">
      <div class="card-header">Benutzer editieren</div>
      <div class="card-body">
        <table id="users" class="table table-striped table-hover nowrap" style="width:100%">
        <thead>
          <tr>
            <th data-priority="1" scope="row">Benutzer</th>
            <th data-priority="1" scope="row">E-Mail</th>
            <th data-priority="1" scope="row" width="200px">Letzte Anmeldung <small class="text-secondary">(UTC)</small></th>
            <th data-priority="1" scope="row" width="200px">Angelegt am <small class="text-secondary">(UTC)</small></th>
            <th data-priority="3" scope="row" width="175px">Löschen</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($all_users as $u): ?>
          <tr>
            <td><a href="<?php echo base_url();?>admin/usermgt/update/<?= esc($u[0]) ?>"><?= esc($u[1]) ?></a></td>
            <td><?= esc($u[2]) ?></td>
            <td><?= esc($u[3]) ?></td>
            <td><?= esc($u[4]) ?></td>
            <td><a class="btn btn-danger ms-auto btn-sm" style="width: 100%" href="<?php echo base_url();?>admin/usermgt/delete/<?= esc($u[0]) ?>" role="button" onclick="return confirm('Soll der Benutzer wirklich gelöscht werden?\nDer n nicVorgang kann nicht rückgängig gemacht werden.');">Benutzer löschen</a></td>
          </tr>
        <?php endforeach ?>
        </tbody>
        </table>
        <p class="text-primary" style="margin-top: 0.5em;"><?= session('adminmessage_updateuser'); ?></p>
      </div>
    </div>
  </div>
</div>
</div>
</div>
