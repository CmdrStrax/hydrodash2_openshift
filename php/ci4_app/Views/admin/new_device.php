<?php 
  helper('text'); 
?>

<div class="col-sm-10 admin_content">
  <div class="container-fluid">
    <div class="card bg-light justify-content-center" style="margin-bottom: 1em;">
      <div class="card-body">
        <h4 class="card-title m-auto">Neuer Geber</h4>
      </div>
    </div>    
    <div class="card justify-content-center" style="margin-top: 1em; margin-bottom: 1em;">
      <div class="card-header">Geberdefinition</div>
      <div class="card-body">
      <form action="<?php echo base_url();?>admin/device/new" method="post">
      <?= csrf_field() ?>
      <?php
        $validation = \Config\Services::validation();
        session()->getFlashdata('error');
      ?>
      <div class="mb-3">
        <label for="zrid" class="form-label">ZRID - aktuelle Daten<br />
        <small class="text-secondary">Datenquelle für Daten der letzten zwei Jahre<br />
        z.B. Temperatur kontinuierlich O, Niederschlag kontinuierlich O, Abfluss kontinuierlich F</small></label>
        </label>
        <input type="input" name="zrid" class="form-control" value="<?= set_value('zrid') ?>">
        <span class="text-danger"><?= esc($validation->getError('zrid'));?></span>
      </div>
      <div class="mb-3">
        <label for="zrid_lt" class="form-label">ZRID - long-term Daten<br />
        <small class="text-secondary">Datenquelle für die langjährige Periode<br />
        z.B. Temperatur Tagesmittel A, Niederschlag Tagessummen O<br class="mb-2" />
        Wenn ZRID "aktuelle Daten" = ZRID "long-term Daten" muss nur die ZRID für "aktuelle Daten" angegeben werden (z.B. für Abfluss, Wassertemperatur, Quellen).</small></label>
        <input type="input" name="zrid_lt" class="form-control" value="<?= set_value('zrid_lt') ?>">
        <span class="text-danger"><?= esc($validation->getError('zrid_lt'));?></span>
      </div>
      <div class="mb-3">
        <label for="zrid_info" class="form-label">ZRID - Info Daten<br />
        <small class="text-secondary">Derzeit nur für Grundwasser &rarr; GOK erforderlich</small></label>
        <input type="input" name="zrid_info" class="form-control" value="<?= set_value('zrid_info') ?>">
        <span class="text-danger"><?= esc($validation->getError('zrid_info'));?></span>
      </div>
      <hr />
      <div class="mb-3">
        <label for="stat" class="form-label">Zeitliche Aggregation<br />
        <small class="text-secondary">Statistische Zusammenfassung des Betrachtungszeitraums.<br />
        Niederschlag ... "Summe", Sonstige ... "Mittelwert"</small></label>
        <select class="form-select" aria-label="Statistische Auswertung" name="stat">
          <option value="mit"<?php if (set_value('stat') == 'mit') { echo " selected"; } ?>>Mittelwert</option>
          <option value="sum"<?php if (set_value('stat') == 'sum') { echo " selected"; } ?>>Summe</option>
        </select>
        <span class="text-danger"><?= esc($validation->getError('stat'));?></span>
      </div>
      <div class="mb-3">
        <label for="start_hour" class="form-label">Tageswert ab ... Uhr<br />
        <small class="text-secondary">Bildung der Tagesmittel von ... bis ... Uhr.<br />
        Niederschlag ... 07:00 Uhr, Sonstige ... 00:00 Uhr</small></label>
        <select class="form-select" aria-label="Tagesmittel ab" name="start_hour">
          <option value="0"<?php if (set_value('start_hour') == "0") { echo " selected"; } ?>>00:00 Uhr</option>
          <option value="7"<?php if (set_value('start_hour') == "7") { echo " selected"; } ?>>07:00 Uhr</option>
        </select>
        <span class="text-danger"><?= esc($validation->getError('start_hour'));?></span>
      </div>
      <div class="mb-3">
        <label for="lt_from" class="form-label">Long-term von<br />
        <small class="text-secondary">Beginn der langjährigen Periode. Beginnt die Zeitreihe nach dem angegebenen Datum, wird die langjährige Periode im Sync automatisch gekürzt.</small></label>
        <input type="date" class="form-control" name="lt_from" value="<?php if (set_value('lt_from') == "") { echo '1991-01-01'; } else { echo set_value('lt_from'); } ?>" />
        <span class="text-danger"><?= esc($validation->getError('lt_from'));?></span>
      </div>
      <div class="mb-3">
        <label for="lt_to" class="form-label">Long-term bis<br />
        <small class="text-secondary">Ende der langjährigen Periode. Endet die Zeitreihe vor dem angegebenen Datum, wird die langjährige Periode im Sync automatisch gekürzt.</small></label>
        <input type="date" class="form-control" name="lt_to" value="<?php if (set_value('lt_to') == "") { echo '2020-12-31'; } else { echo set_value('lt_to'); } ?>" />
        <span class="text-danger"><?= esc($validation->getError('lt_to'));?></span>
      </div>
      <hr />
      <div class="mb-3">
        <label for="pos" class="form-label">Position in Tabelle<br />
        <small class="text-secondary">Ohne Angabe alphabetisch sortiert</small></label>
        <input type="number" step="1" name="pos" class="form-control" value="<?= set_value('pos') ?>">
        <span class="text-danger"><?= esc($validation->getError('pos'));?></span>
      </div>
      <div class="mb-3">
        <label for="comment" class="form-label">Infotext<br />
        <small class="text-secondary">Text wird im Dashboard angezeigt</small></label>
        </label>
        <input type="input" name="comment" class="form-control" value="<?= set_value('comment') ?>">
        <span class="text-danger"><?= esc($validation->getError('comment'));?></span>
      </div>
      <input type="submit" name="submit" class="btn btn-primary" value="Geber anlegen">
      </form>
      </div>
    </div>
    <div class="d-flex justify-content-between">
      <a class="btn btn-outline-primary ms-1" href="<?php echo base_url();?>admin/" role="button">Zurück</a>
    </div>
  </div>
</div>
</div>
</div>