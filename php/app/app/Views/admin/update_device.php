<?php 
  helper('text'); 
?>

<div class="col-sm-10 admin_content">
  <div class="container-fluid">
    <div class="card bg-light justify-content-center" style="margin-bottom: 1em;">
      <div class="card-body">
          <?php if ($ds['name'] != ''): ?>
          <b class="card-title m-auto" style="font-size: 1.2em">Geber für Station <?php echo $ds["name"]; ?></b><br />
          <span class="text-secondary">Parameter <?php echo $ds['parameter'] ?></span></b>
          <?php else: ?>
          <h4 class="card-title m-auto bg">Geber <?= $ds['zrid'] ?></h4>
          <?php endif ?>
      </div>
    </div>    
    <div class="card justify-content-center" style="margin-top: 1em; margin-bottom: 1em;">
      <div class="card-header">Geberdefinition</div>
      <div class="card-body">
      <?php if ($ds['name'] != ''): ?>
        <fieldset disabled>
        <div class="mb-3">
          <label for="name" class="form-label">Stationsname <small class="text-secondary">(Wert aus HyDaMS synchronisiert)</small></label>
          <input type="input" name="name" class="form-control text-secondary" value="<?= $ds['name'] ?>" readonly>
        </div>
        <div class="mb-3">
          <label for="parameter" class="form-label">Parameter <small class="text-secondary">(Wert aus HyDaMS synchronisiert)</small></label>
          <input type="input" name="parameter" class="form-control text-secondary" value="<?= $ds['parameter'] ?>" readonly>
        </div>
        <div class="mb-3">
          <label for="name" class="form-label">DBMNR <small class="text-secondary">(Wert aus HyDaMS synchronisiert)</small></label>
          <input type="input" name="name" class="form-control text-secondary" value="<?= $ds['dbmnr'] ?>" readonly>
        </div>
        <div class="mb-3">
          <label for="name" class="form-label">HZBNR <small class="text-secondary">(Wert aus HyDaMS synchronisiert)</small></label>
          <input type="input" name="name" class="form-control text-secondary" value="<?= $ds['hzbnr'] ?>" readonly>
        </div>
        <div class="mb-3">
          <label for="name" class="form-label">Gewässer <small class="text-secondary">(Wert aus HyDaMS synchronisiert)</small></label>
          <input type="input" name="name" class="form-control text-secondary" value="<?= $ds['stream'] ?>" readonly>
        </div>
        <div class="mb-3">
          <label for="name" class="form-label">Einzugsgebiet <small class="text-secondary">(Wert aus HyDaMS synchronisiert)</small></label>
          <input type="input" name="name" class="form-control text-secondary" value="<?= $ds['catchment_name'] ?>" readonly>
        </div>
        </fieldset>
        <hr class="mb-4 mt-1" />
      <?php endif ?>
      <form action="<?php echo base_url();?>admin/device/update/<?= esc($ds['id']) ?>" method="post" id="ds_def">
      <?= csrf_field() ?>
      <?php
        $validation = \Config\Services::validation();
        session()->getFlashdata('error');
        if (count($validation->getErrors()) > 0) { 
          echo "<script>document.getElementById('ds_def').scrollIntoView();</script>"; 
        }
      ?>
      <?php if (session('adminmessage') !== null) : ?>
      <p class="text-success"><?= session('adminmessage'); ?></p>
      <?php endif; ?>
      <div class="mb-3">
        <label for="zrid" class="form-label">ZRID - aktuelle Daten<br />
        <small class="text-secondary">Datenquelle für Daten der letzten zwei Jahre</small></label>
        </label>
        <input type="input" name="zrid" class="form-control" value="<?= $ds['zrid'] ?>" title="z.B. Temperatur kont. O, Niederschlag kont. O, Abfluss kont. F">
        <span class="text-danger"><?= esc($validation->getError('zrid'));?></span>
      </div>
      <div class="mb-3">
        <label for="zrid_lt" class="form-label">ZRID - long-term Daten<br />
        <small class="text-secondary">Datenquelle für die langjährige Periode</small></label>
        <input type="input" name="zrid_lt" class="form-control" value="<?= $ds['zrid_lt'] ?>" title="z.B. Temperatur Tagesmittel A, Niederschlag Tagessummen O; Wenn ZRID 'aktuelle Daten' = ZRID 'long-term Daten' muss nur die ZRID für 'aktuelle Daten' angegeben werden (z.B. für Abfluss, Wassertemperatur, Quellen).">
        <span class="text-danger"><?= esc($validation->getError('zrid_lt'));?></span>
      </div>
      <div class="mb-3">
        <label for="zrid_info" class="form-label">ZRID - Info Daten<br />
        <small class="text-secondary">Derzeit nur für Grundwasser &rarr; GOK erforderlich</small></label>
        <input type="input" name="zrid_info" class="form-control" value="<?= $ds['zrid_info'] ?>">
        <span class="text-danger"><?= esc($validation->getError('zrid_info'));?></span>
      </div>
      <hr />
      <div class="mb-3">
        <label for="stat" class="form-label">Zeitliche Aggregation<br />
        <small class="text-secondary">Statistische Zusammenfassung des Betrachtungszeitraums</small></label>
        <select class="form-select" aria-label="Statistische Auswertung" name="stat" title="Niederschlag ... Summe, Sonstige ... Mittelwert">
          <option value="mit"<?php if ($ds['stat'] == 'mit') { echo " selected"; } ?>>Mittelwert</option>
          <option value="sum"<?php if ($ds['stat'] == 'sum') { echo " selected"; } ?>>Summe</option>
        </select>
        <span class="text-danger"><?= esc($validation->getError('stat'));?></span>
      </div>
      <div class="mb-3">
        <label for="start_hour" class="form-label">Tageswert ab ... Uhr<br />
        <small class="text-secondary">Bildung der Tagesmittel von ... bis ... Uhr</small></label>
        <select class="form-select" aria-label="Tagesmittel ab" name="start_hour" title="Niederschlag ... 07:00 Uhr, Sonstige ... 00:00 Uhr">
          <option value="0"<?php if ($ds['start_hour'] == 0) { echo " selected"; } ?>>00:00 Uhr</option>
          <option value="7"<?php if ($ds['start_hour'] == 7) { echo " selected"; } ?>>07:00 Uhr</option>
        </select>
        <span class="text-danger"><?= esc($validation->getError('start_hour'));?></span>
      </div>
      <div class="mb-3">
        <label for="lt_from" class="form-label">Long-term von</label>
        <input type="date" class="form-control" name="lt_from" value="<?= formatDatetime($ds['lt_from'], 'Y-m-d') ?>" title="Beginn der langjährigen Periode. Beginnt die Zeitreihe nach dem angegebenen Datum, wird die langjährige Periode im Sync automatisch gekürzt." />
        <span class="text-danger"><?= esc($validation->getError('lt_from'));?></span>
      </div>
      <div class="mb-3">
        <label for="lt_to" class="form-label">Long-term bis</label>
        <input type="date" class="form-control" name="lt_to" value="<?= formatDatetime($ds['lt_to'], 'Y-m-d') ?>" title="Ende der langjährigen Periode. Endet die Zeitreihe vor dem angegebenen Datum, wird die langjährige Periode im Sync automatisch gekürzt." />
        <span class="text-danger"><?= esc($validation->getError('lt_to'));?></span>
      </div>
      <hr />
      <div class="mb-3">
        <label for="pos" class="form-label">Position in Tabelle<br />
        <small class="text-secondary">Ohne Angabe alphabetisch sortiert</small></label>
        <input type="number" step="1" name="pos" class="form-control" value="<?= $ds['pos'] ?>">
        <span class="text-danger"><?= esc($validation->getError('pos'));?></span>
      </div>
      <div class="mb-3">
        <label for="comment" class="form-label">Infotext<br />
        <small class="text-secondary">Text wird im Dashboard angezeigt</small></label>
        </label>
        <input type="input" name="comment" class="form-control" value="<?= $ds['comment'] ?>">
        <span class="text-danger"><?= esc($validation->getError('comment'));?></span>
      </div>
      <?php if(!is_null($ds_coord)): ?>
      <div class="mb-3">
        <label for="x_offset" class="form-label">X / Y Versatz<br />
        <small class="text-secondary">Versatz auf Karte in Pixel</small></label>
        <div class="input-group">
          <input type="number" step="1" name="x_offset" class="form-control" value="<?= $ds_coord['x_offset'] ?>">
          <input type="number" step="1" name="y_offset" class="form-control" value="<?= $ds_coord['y_offset'] ?>">
        </div>
        <span class="text-danger"><?= esc($validation->getError('pos'));?></span>
      </div>
      <?php endif ?>
      <hr />
      <div class="mb-3">
        <label for="comment_admin" class="form-label">Admin-Kommentar<br />
        <small class="text-secondary">Hinweis zur Geber-Administration. Text wird nicht im Dashboard angezeigt.</small></label>
        <input type="input" name="comment_admin" class="form-control" value="<?= $ds['comment_admin'] ?>">
        <span class="text-danger"><?= esc($validation->getError('comment_admin'));?></span>
      </div>
      <div class="mb-3">
        <div class="form-check form-switch">
          <label for="active" class="form-label">Geber aktiv</label>
          <input class="form-check-input" type="checkbox" role="switch" name="active" title="Anzeige Dashboard" <?php if($ds['active'] == 't') { echo ' checked'; } ?>>
        </div>
      </div>
      <input type="submit" name="submit" class="btn btn-primary" value="Änderungen speichern">
      <p class="text-secondary pt-3"><small>Letzter Änderung: <?= formatDatetime($ds['last_modified_at']) ?> (<?= $ds['last_modified_by'] ?>)</small></p>
      </form>
      </div>
    </div>
    <div class="card justify-content-center" style="margin-top: 1em; margin-bottom: 1em;" id="analysis">
      <div class="card-header">Analyse</div>
      <div class="card-body">
        <table id="stations" class="table table-striped table-hover nowrap" style="width:100%">
        <thead>
          <tr>
            <th data-priority="1" scope="row" class="border-0">Name</th>
            <th data-priority="1" scope="row" class="border-0">Statistik</th>
            <th data-priority="1" scope="row" class="border-0">Zeitraum</th>
            <th data-priority="1" scope="row" class="border-0">Kommentar</th>
            <th data-priority="1" class="border-0" width="250px">Angelegt am</th>
            <th data-priority="1" class="border-0" width="150px">Löschen</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($analysis) == 0): ?>
            <tr>
              <td class="text-secondary"><i>Noch keine Analyse angelegt</i></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($analysis as $a): ?>
            <tr>
                <td><?php echo $a["name"]; ?></td>
                <td><?php echo $a["stat"]; ?></td>
                <td><?php echo $a["period"]; ?></td>
                <td><?php echo $a["comment"]; ?></td>
                <td class="text-secondary"><?= formatDatetime($a['last_modified_at']) ?> (<?= esc($a['last_modified_by']) ?>)</td>
                <td><a class="btn btn-outline-danger btn-sm ms-auto" style="width: 100%" href="<?php echo base_url();?>admin/analysis/delete/<?= esc($a['id']) ?>" role="button">Löschen</a></td>
            </tr>
            <?php endforeach ?>
          <?php endif ?>
        </tbody>
        </table>
        <small class="text-secondary">Jedem Geber können beliebig viele Analysen zugeordnet werden. Die Analyse beinhaltet die statistische Berechnung und wird nach jedem Zeitreihenabgleich ausgeführt.<br />
        I.d.R. ist die Erstellung der Standardsets ausreichend.</small>
        <?php if (session('adminmessage_analysis') !== null) : ?>
        <p class="text-success"><?= session('adminmessage_analysis'); ?></p>
        <?php endif; ?>
        <div class="d-flex justify-content-between mt-3">
          <div>
            <a class="btn btn-success" href="<?php echo base_url();?>admin/analysis/new/<?= esc($ds['id']) ?>" role="button">Neue Analyse</a>
            <a class="btn btn-outline-success ms-1" href="<?php echo base_url();?>admin/analysis/new/<?= esc($ds['id']) ?>/standard" role="button">Standardset erzeugen</a>
            <a class="btn btn-outline-success ms-1" href="<?php echo base_url();?>admin/analysis/new/<?= esc($ds['id']) ?>/niederschlag" role="button">Standardset für Niederschlag erzeugen</a>
          </div>
          <div>
            <a class="btn btn-danger ms-1" href="<?php echo base_url();?>admin/analysis/delete/device/<?= esc($ds['id']) ?>" role="button" onclick="return confirm('Sollen wirklich alle Analyseeinstellungen für den Geber gelöscht werden?\nDer Vorgang kann nicht rückgängig gemacht werden.');">Alle Analysen löschen</a>
          </div>
        </div>
      </div>
    </div>
    <div class="card justify-content-center" style="margin-top: 1em; margin-bottom: 1em;" id="job">
      <div class="card-header">Jobs</div>
      <div class="card-body">
        <p class="text-secondary"><i>Letzter Lauf - Zeitreihe</i></p>
        <table id="stations" class="table table-striped table-hover nowrap" style="width:100%">
        <thead>
          <tr>
            <th data-priority="1" scope="row" class="border-0">Name</th>
            <th data-priority="1" scope="row" class="border-0">Kommentar</th>
            <th data-priority="1" scope="row" class="border-0">Wert</th>
            <th data-priority="1" scope="row" class="border-0">Sichtbarkeit</th>
            <th data-priority="2" scope="row" class="border-0">Durchgeführt um</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($tslog) == 0): ?>
            <tr>
              <td class="text-secondary"><i>Noch kein Job ausgeführt</i></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($tslog as $a): ?>
            <tr>
                <td><?php echo $a["name"]; ?></td>
                <td><?php echo $a["comment"]; ?></td>
                <td><?php echo $a["val"]; ?></td>
                <td><?php echo get_bool_tslog($a["internal"]); ?></td>
                <td class="text-secondary"><?php echo formatDatetime($a["last_modified_at"]); ?></td>
            </tr>
            <?php endforeach ?>
          <?php endif ?>
        </tbody>
        </table>
        <p class="text-secondary"><i>Letzter Lauf - Analyse</i></p>
        <table id="stations" class="table table-striped table-hover nowrap" style="width:100%">
        <thead>
          <tr>
            <th data-priority="1" scope="row" class="border-0">Name</th>
            <th data-priority="1" scope="row" class="border-0">Kommentar</th>
            <th data-priority="1" scope="row" class="border-0">% Live</th>
            <th data-priority="1" scope="row" class="border-0">% Long-term</th>
            <th data-priority="1" scope="row" class="border-0">Zeitraum von</th>
            <th data-priority="1" scope="row" class="border-0">Zeitraum bis</th>
            <th data-priority="1" scope="row" class="border-0">Durchgeführt um</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($analyselog) == 0): ?>
            <tr>
              <td class="text-secondary"><i>Noch kein Job ausgeführt</i></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($analyselog as $a): ?>
            <tr>
                <td><?php echo $a["name"]; ?></td>
                <td><?php echo $a["comment"]; ?></td>
                <td><?php echo get_perc_results($a["num_values_live"], $a["num_values_expected"]); ?></td>
                <td><?php echo get_perc_results($a["num_values_lt"], $a["num_values_expected"]); ?></td>
                <td><?php echo formatDatetime($a["valid_from"], 'Y-m-d'); ?></td>
                <td><?php echo formatDatetime($a["valid_to"], 'Y-m-d'); ?></td>
                <td class="text-secondary"><?php echo formatDatetime($a["last_modified_at"]); ?></td>
            </tr>
            <?php endforeach ?>
          <?php endif ?>
        </tbody>
        </table>
        <hr>
        <?php if (!is_null($jobs)): ?>
        <button type="button" class="btn btn-secondary" disabled>Job beauftragen</button>
        <a class="btn btn-danger ms-1" href="<?php echo base_url();?>admin/device/job/<?= esc($ds['id']) ?>/del" role="button">Job löschen</a>
        <a class="btn btn-outline-success ms-2" href="<?php echo base_url();?>admin/jobs" role="button">Zur Jobübersicht</a>
        <p class="text-primary mt-3">Job in Bearbeitung (Beauftragung vom <?php echo formatDatetime($jobs['initiated_at']) ?>)</p>
        <?php else: ?>
        <a class="btn btn-success mb-3" href="<?php echo base_url();?>admin/device/job/<?= esc($ds['id']) ?>" role="button">Job beauftragen</a>
        <a class="btn btn-outline-success ms-1 mb-3" href="<?php echo base_url();?>admin/jobs" role="button">Zur Jobübersicht</a><br />
        <?php endif ?>
        <?php if (session('adminmessage_jobs') !== null) : ?>
        <p class="text-success"><?= session('adminmessage_jobs'); ?></p>
        <?php endif; ?>
        <small class="text-secondary">Alle 5 Minuten werden per Cronjob bis zu 10 Aufträge abgebarbeitet. Bei mehr als 10 Aufträge erfolgt die Abarbeitung gestaffelt.<br />
        Ein Job beinhaltet den Abgleich der HyDaMS Stammdaten, den Zeitreihenabgleich, die Berechnung der Analysen sowie das Refresh für Materialized Views.<br />
        Für alle Stationen werden Jobs in der Nacht (bzw. für Niederschlag nach 07:00 Uhr) automatisch ausgeführt.</small>
      </div>
    </div>
    <div class="d-flex justify-content-between">
      <a class="btn btn-outline-primary ms-1" href="<?php echo base_url();?>admin/" role="button">Zurück</a><a class="btn btn-danger ms-auto" href="<?php echo base_url();?>admin/device/delete/<?= esc($ds['id']) ?>" role="button" onclick="return confirm('Soll der Geber wirklich gelöscht werden?\nDer Vorgang kann nicht rückgängig gemacht werden.');">Geber löschen</a>
    </div>
  </div>
</div>
</div>
</div>