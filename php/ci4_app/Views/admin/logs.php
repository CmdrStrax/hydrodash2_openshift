<?php 
helper('text'); 

$log_nightly_text = ""; 

try { 
  $log_nightly_text_arr = explode("\n", file_get_contents($log_nightly)); 

  foreach($log_nightly_text_arr as $l) {
    $log_nightly_text .= $l . "\n";
  }
} catch (Exception $e) { 
  $log_nightly_text = $e->getMessage(); 

  if (str_contains($log_nightly_text, "No such file or directory")) {
    $log_nightly_text = 'Logfile nicht gefunden';  
  }
} 

$log_jobs_text = ""; 

try { 
  $log_jobs_text_arr = explode("\n", file_get_contents($log_jobs)); 

  foreach($log_jobs_text_arr as $l) {
    $log_jobs_text .= $l . "\n";
  }
} catch (Exception $e) { 
  $log_jobs_text = $e->getMessage();
  
  if (str_contains($log_jobs_text, "No such file or directory")) {
    $log_jobs_text = 'Logfile nicht gefunden';
  }
} 

?>

<div class="col-sm-10 admin_content">
  <div class="container-fluid">
    <div class="card bg-light align-middle" style="margin-bottom: 1em;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-middle">
          <h4 class="card-title mt-auto mb-auto">Logs</h4>
        </div>
      </div>
    </div>
    <div class="card justify-content-center" style="margin-top: 1em; margin-bottom: 1em;">
      <div class="card-header">Sync Nightly</div>
      <div class="card-body">
        <textarea rows="20" class="form-control" style="font-family: courier; font-size: 14px;"><?php echo $log_nightly_text; ?></textarea>
      </div>
    </div>
    <div class="card justify-content-center" style="margin-top: 1em; margin-bottom: 1em;">
      <div class="card-header">Sync Jobs</div>
      <div class="card-body">
        <textarea rows="20" class="form-control" style="font-family: courier; font-size: 14px;"><?php echo $log_jobs_text; ?></textarea>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
