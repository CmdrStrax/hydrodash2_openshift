<?php

function get_q_round($q) {
    if (!is_numeric($q) || is_null($q)) {
        return $q;
    }

    $negative = false;

    if ($q < 0) {
        $q = $q * -1;
        $negative = true;
    }

    if ($q < 1) {
        $q = round($q, 2);
    } elseif ($q < 10) {
        $q = round($q, 1);
    } else { 
        $q = round($q, 0);
    }

    if ($negative) {
        $q = $q * -1;
    }
    
    return $q;
}

function get_bool($b) {
    if ($b == "t") { 
        return "<div class='text-success'><b>aktiv</b></div>"; 
    } else { 
        return "<div class='text-danger'>inaktiv</div>"; 
    } 
}; 

function get_bool_tslog($b) {
    if ($b == "t") { 
        return "<div class='text-danger'>Interne Meldung</div>"; 
    } else { 
        return "<div class='text-success'><b>Öffentlich</b></div>"; 
    } 
}; 


function convertTimezone($date, $in_tz, $out_tz, $f = 'd.m.Y H:i:s') {
    if ($date == "") {
        return "";
    }

    $d = new DateTime($date, $in_tz);
    $d->setTimezone($out_tz);

    return $d->format($f);
}; 

function formatDatetime($date, $f = 'Y-m-d H:i:s') {
    if ($date == "") {
        return "";
    }

    $d = new DateTime($date);
    return $d->format($f);
}; 

function formatDatetimeAdmin($date, $f = 'Y-m-d H:i:s') {
    if ($date == "") {
        return "";
    }

    $d = new DateTime($date);
    $d_str = $d->format($f);

    $now = new DateTime();
    $now->modify("-1 day");

    if($now < $d) {
        $d_str = '<span class="text-success">' . $d_str . '</span>';
    }

    return $d_str;
}; 

function get_col($val, $val_lt, $dt=false) {
    $col = "#bbb"; 

    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return [$col, 3, 0];
    }

    if ($val_lt == 0) {
        return ['#d73027', 6, 0];
    } 

    $v = round(((floatval($val)-floatval($val_lt)) / floatval($val_lt)) * 100);

    $dt = new DateTime($dt);
    $dt_now = new DateTime();
    
    if (!$dt && $dt < $dt_now->modify('-3 day')) {
        return [$col, 3, 0]; 
    }

    if ($v < -150) { 
        $col = "rgba(69,117,180,1)"; 
    } elseif ($v < -100) { 
        $col = "rgba(116,173,209,1)"; 
    } elseif ($v < -50) { 
        $col = "rgba(171,217,233,1)"; 
    } elseif ($v < 0) { 
        $col = "rgba(224,243,248,1)"; 
    } elseif ($v < 50) { 
        $col = "rgba(254,224,144,1)"; 
    } elseif ($v < 100) {
        $col = "rgba(253,174,97,1)"; 
    } elseif ($v < 150) { 
        $col = "rgba(244,109,67,1)"; 
    } else {
        $col = 'rgba(215,48,39,1)';
    }

    if ($v > 0) {
        $v_str = '+' . $v;
    } elseif ($v == 0) {
        $v_str = '0';
    } else {
        $v_str = $v;
    }

    return [$col, 6, $v_str]; 
}; 

function get_col_table_discharge($val, $val_lt) {

    //
    // Check: Value available
    // 

    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return ["#fff", '', '', ''];
    }

    //
    // Check: Is base 0?
    //

    if ($val_lt == 0 && $val > 0) {
        // If Base 0 and val > 0 + infinity
        return ["rgba(215,48,39,0.5)", '+ &#8734; %', '+ &#8734; %', '+ &#8734; %'];
    } else if ($val_lt == 0 && $val < 0) {
        // If Base 0 and val < 0 - infinity
        return ["rgba(69,117,180,0.5)", '- &#8734; %', '- &#8734; %', '- &#8734; %'];
    } else if ($val_lt == 0 && $val == 0) {
        // If both 0 calculation nonsense
        return ["#fff", '', '', ''];
    }

    //
    // Calculation
    //
    // d ... Delta
    // v ... Percent
    //

    $d = $val - $val_lt;
    $v = round(((floatval($val)-floatval($val_lt)) / abs(floatval($val_lt))) * 100);

    //
    // Define color and svg name
    //

    $col = "#fff"; 
    $svg = "";

    if ($v < -150) { 
        $col = "rgba(69,117,180,0.66)"; 
        $svg = 'down';
    } elseif ($v < -100) { 
        $col = "rgba(116,173,209,0.66)"; 
        $svg = 'down';
    } elseif ($v < -50) { 
        $col = "rgba(171,217,233,0.66)"; 
        $svg = 'down-right';
    } elseif ($v < 0) { 
        $col = "rgba(224,243,248,0.66)"; 
        $svg = 'down-right';
    } elseif ($v == 0) { 
        $col = "rgba(255,255,255,1)"; 
        $svg = 'right';
    } elseif ($v < 50) { 
        $col = "rgba(254,224,144,0.66)"; 
        $svg = 'up-right';
    } elseif ($v < 100) {
        $col = "rgba(253,174,97,0.66)"; 
        $svg = 'up-right';
    } elseif ($v < 150) { 
        $col = "rgba(244,109,67,0.66)"; 
        $svg = 'up';
    } else {
        $col = 'rgba(215,48,39,0.66)';
        $svg = 'up';
    }

    if ($v >= -2 && $v <= 2){
        // Range for straight line
        $svg = 'right';
    } 

    //
    // Prepare strings
    //

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' %';
    } elseif ($v == 0) {
        $v_str = '+/- 0 %';
    } else {
        $v_str = '- ' . $v*-1 .  ' %';
    }

    if ($d > 0) {
        $d_str = '+ ' . get_q_round($d) . ' m³/s';
    } elseif ($d == 0) {
        $d_str = '+/- 0 m³/s';
    } else {
        $d_str = '- ' . get_q_round($d*-1) . ' m³/s';
    }

    return [$col, $v_str, $d_str, $svg]; 
}; 

function get_col_station_discharge($val, $val_lt, $dt_from, $dt_to) {

    // 
    // Prepare dates
    //

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');
    $my_dt_to = (new DateTime($dt_to))->format('d.m.Y');

    //
    // Check: Value available
    // 
    
    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return ["#f8f8f8ff", '<i style="font-weight: normal !important;">Kein Messwert</i>', $my_dt_from, $my_dt_to, '-', '#5e5e5e', '#5e5e5e'];
    }

    //
    // Calculate delta and prepare base values
    //

    $d = floatval($val) - floatval($val_lt);

    $my_text_col = '#fff';
    $my_text_col_light = '#5e5e5e';

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');
    $my_dt_to = (new DateTime($dt_to))->format('d.m.Y');
    
    if ($d > 0) {
        $my_val = '+ ' . get_q_round($d) . " m³/s";
        $my_text_col = '#fa6a05';
    } elseif ($d == 0) {
        $my_val = "+/- 0 m³/s";
        $my_text_col = '#000';
    } else {
        $my_val = '- ' . get_q_round($d*-1) . " m³/s";
        $my_text_col = '#003d80';
    }

    //
    // Check: Is base 0?
    //

    if ($val_lt == 0 && $val > 0) {
        // If Base 0 and val > 0 + infinity
        return ["rgba(215,48,39,0.5)", '+ &#8734; %', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light];
    } else if ($val_lt == 0 && $val < 0) {
        // If Base 0 and val < 0 - infinity
        return ["rgba(69,117,180,0.5)", '- &#8734; %', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light];
    } else if ($val_lt == 0 && $val == 0) {
        // If both 0 calculation nonsense
        return ["#fff", '', '', ''];
    }

    // Calc main values

    $v = round(((floatval($val)-floatval($val_lt)) / abs(floatval($val_lt))) * 100);

    if ($v < -150) { 
        $col = "rgba(69,117,180,0.7)"; 
        $my_text_col = '#0b0b64';
        $my_text_col_light = '#212529';
    } elseif ($v < -100) { 
        $col = "rgba(116,173,209,0.8)"; 
    } elseif ($v < -50) { 
        $col = "rgba(171,217,233,0.8)"; 
    } elseif ($v < 0) { 
        $col = "rgba(224,243,248,0.8)"; 
    } elseif ($v == 0) { 
        $col = "rgba(255, 255, 255, 0.8)"; 
    } elseif ($v < 50) { 
        $col = "rgba(254,224,144,0.8)"; 
    } elseif ($v < 100) {
        $col = "rgba(253,174,97,0.8)"; 
        $my_text_col = '#8b0000';
    } elseif ($v < 150) { 
        $col = "rgba(244,109,67,0.8)"; 
        $my_text_col = '#8b0000';
    } else {
        $col = 'rgba(215,48,39,0.7)';
        $my_text_col = '#8b0000';
        $my_text_col_light = '#212529';
    }

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' %';
    } elseif ($v == 0) {
        $v_str = '+/- 0 %';
        $my_text_col = '#5d5d5dff';
    } else {
        $v_str = '- ' . $v*-1 . ' %';
    } 

    return [$col, $v_str, $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light]; 
}; 

function get_col_table_watertemp($val, $val_lt) {

    //
    // Check: Value available
    // 

    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return ["#fff", '', '', ''];
    }

    //
    // Check: Is base 0?
    //

    if ($val_lt == 0 && $val > 0) {
        // If Base 0 and val > 0 + infinity
        return ["rgba(215,48,39,0.5)", '+ &#8734; %', '+ &#8734; %', '+ &#8734; %'];
    } else if ($val_lt == 0 && $val < 0) {
        // If Base 0 and val < 0 - infinity
        return ["rgba(69,117,180,0.5)", '- &#8734; %', '- &#8734; %', '- &#8734; %'];
    } else if ($val_lt == 0 && $val == 0) {
        // If both 0 calculation nonsense
        return ["#fff", '', '', ''];
    }

    //
    // Calculation
    //
    // d ... Delta
    // v ... Percent
    //

    // Celsius to Kelvin

    $val = $val + 273.15;
    $val_lt = $val_lt + 273.15;

    $d = $val - $val_lt;
    $v = round(((floatval($val)-floatval($val_lt)) / abs(floatval($val_lt))) * 100, 2);

    //
    // Define color and svg name
    //

    $col = "#fff"; 
    $svg = "";

    if ($d < -4.5) { 
        $col = "rgba(69,117,180,0.66)"; 
        $svg = 'down';
    } elseif ($d < -3) { 
        $col = "rgba(116,173,209,0.66)"; 
        $svg = 'down';
    } elseif ($d < -1.5) { 
        $col = "rgba(171,217,233,0.66)"; 
        $svg = 'down-right';
    } elseif ($d < 0) { 
        $col = "rgba(224,243,248,0.66)"; 
        $svg = 'down-right';
    } elseif ($d == 0) { 
        $col = "rgba(255,255,255,1)"; 
        $svg = 'right';
    } elseif ($d < 1.5) { 
        $col = "rgba(254,224,144,0.66)"; 
        $svg = 'up-right';
    } elseif ($d < 3) {
        $col = "rgba(253,174,97,0.66)"; 
        $svg = 'up-right';
    } elseif ($d < 4.5) { 
        $col = "rgba(244,109,67,0.66)"; 
        $svg = 'up';
    } else {
        $col = 'rgba(215,48,39,0.66)';
        $svg = 'up';
    }

    if ($d >= -0.2 && $d <= 0.2){
        // Range for straight line
        $svg = 'right';
    } 

    //
    // Prepare strings
    //

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' % in K';
    } elseif ($v == 0) {
        $v_str = '+/- 0 % in K';
    } else {
        $v_str = '- ' . $v*-1 .  ' % in K';
    }

    if ($d > 0) {
        $d_str = '+ ' . round($d,1) . ' °C';
    } elseif ($d == 0) {
        $d_str = '+/- 0 °C';
    } else {
        $d_str = '- ' . round($d*-1,1) . ' °C';
    }

    return [$col, $v_str, $d_str, $svg]; 
}; 

function get_col_station_watertemp($val, $val_lt, $dt_from, $dt_to) {

    // 
    // Prepare dates
    //

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');
    $my_dt_to = (new DateTime($dt_to))->format('d.m.Y');

    //
    // Check: Value available
    // 
    
    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return ["#f8f8f8ff", '-', $my_dt_from, $my_dt_to, '<i style="font-weight: normal !important;">Kein Messwert</i>', '#5e5e5e', '#5e5e5e'];
    }

    //
    // Calculate delta and prepare base values
    //

    $val = $val + 273.15;
    $val_lt = $val_lt + 273.15;

    $d = floatval($val) - floatval($val_lt);

    $my_text_col = '#fff';
    $my_text_col_light = '#5e5e5e';

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');
    $my_dt_to = (new DateTime($dt_to))->format('d.m.Y');
    
    if ($d > 0.1) {
        $my_val = '+ ' . round($d, 1) . " °C";
        $my_text_col = '#fa6a05';
    } elseif ($d >= -0.1) {
        $my_val = "+/- 0 °C";
        $my_text_col = '#000';
    } else {
        $my_val = '- ' . round($d*-1, 1) . " °C";
        $my_text_col = '#003d80';
    }

    //
    // Check: Is base 0?
    //

    if ($val_lt == 0 && $val > 0) {
        // If Base 0 and val > 0 + infinity
        return ["rgba(215,48,39,0.5)", '+ &#8734; %', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light];
    } else if ($val_lt == 0 && $val < 0) {
        // If Base 0 and val < 0 - infinity
        return ["rgba(69,117,180,0.5)", '- &#8734; %', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light];
    } else if ($val_lt == 0 && $val == 0) {
        // If both 0 calculation nonsense
        return ["#fff", '', '', ''];
    }

    // Calc main values

    $v = round(((floatval($val)-floatval($val_lt)) / abs(floatval($val_lt))) * 100, 2);

    if ($d < -4.5) { 
        $col = "rgba(69,117,180,0.7)"; 
        $my_text_col = '#0b0b64';
        $my_text_col_light = '#212529';
    } elseif ($d < -3) { 
        $col = "rgba(116,173,209,0.8)"; 
    } elseif ($d < -1.5) { 
        $col = "rgba(171,217,233,0.8)"; 
    } elseif ($d < 0) { 
        $col = "rgba(224,243,248,0.8)"; 
    } elseif ($d == 0) { 
        $col = "rgba(255, 255, 255, 0.8)"; 
    } elseif ($d < 1.5) { 
        $col = "rgba(254,224,144,0.8)"; 
    } elseif ($d < 3) {
        $col = "rgba(253,174,97,0.8)"; 
        $my_text_col = '#8b0000';
    } elseif ($d < 4.5) { 
        $col = "rgba(244,109,67,0.8)"; 
        $my_text_col = '#8b0000';
    } else {
        $col = 'rgba(215,48,39,0.7)';
        $my_text_col = '#8b0000';
        $my_text_col_light = '#212529';
    }

    // Overwrite white at range -0.1 - 0.1
    if ($d <= 0.1 && $d >= -0.1) {
        $col = "rgba(255, 255, 255, 0.8)"; 
    }

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' %';
    } elseif ($v == 0) {
        $v_str = '+/- 0 %';
        $my_text_col = '#5d5d5dff';
    } else {
        $v_str = '- ' . $v*-1 . ' %';
    } 

    return [$col, $v_str, $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light]; 
}; 

function get_col_table_precip($val, $val_lt) {

    //
    // Check: Value available
    // 

    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return ["#fff", '', '', ''];
    }

    //
    // Check: Is base 0?
    //

    if ($val_lt == 0 && $val > 0) {
        // If Base 0 and val > 0 + infinity
        return ["rgba(215,48,39,0.5)", '+ &#8734; %', '+ &#8734; %', '+ &#8734; %'];
    } else if ($val_lt == 0 && $val < 0) {
        // If Base 0 and val < 0 - infinity
        return ["rgba(69,117,180,0.5)", '- &#8734; %', '- &#8734; %', '- &#8734; %'];
    } else if ($val_lt == 0 && $val == 0) {
        // If both 0 calculation nonsense
        return ["#fff", '', '', ''];
    }

    //
    // Calculation
    //
    // d ... Delta
    // v ... Percent
    //

    $d = $val - $val_lt;
    $v = round(((floatval($val)-floatval($val_lt)) / abs(floatval($val_lt))) * 100);

    //
    // Define color and svg name
    //

    $col = "#fff"; 
    $svg = "";

    if ($v < -150) { 
        $col = "rgba(69,117,180,0.66)"; 
        $svg = 'down';
    } elseif ($v < -100) { 
        $col = "rgba(116,173,209,0.66)"; 
        $svg = 'down';
    } elseif ($v < -50) { 
        $col = "rgba(171,217,233,0.66)"; 
        $svg = 'down-right';
    } elseif ($v < 0) { 
        $col = "rgba(224,243,248,0.66)"; 
        $svg = 'down-right';
    } elseif ($v == 0) { 
        $col = "rgba(255,255,255,1)"; 
        $svg = 'right';
    } elseif ($v < 50) { 
        $col = "rgba(254,224,144,0.66)"; 
        $svg = 'up-right';
    } elseif ($v < 100) {
        $col = "rgba(253,174,97,0.66)"; 
        $svg = 'up-right';
    } elseif ($v < 150) { 
        $col = "rgba(244,109,67,0.66)"; 
        $svg = 'up';
    } else {
        $col = 'rgba(215,48,39,0.66)';
        $svg = 'up';
    }

    if ($v >= -2 && $v <= 2){
        // Range for straight line
        $svg = 'right';
    } 

    //
    // Prepare strings
    //

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' %';
    } elseif ($v == 0) {
        $v_str = '+/- 0 %';
    } else {
        $v_str = '- ' . $v*-1 .  ' %';
    }

    if ($d > 0) {
        $d_str = '+ ' . get_q_round($d) . ' mm';
    } elseif ($d == 0) {
        $d_str = '+/- 0 mm';
    } else {
        $d_str = '- ' . get_q_round($d*-1) . ' mm';
    }

    return [$col, $v_str, $d_str, $svg]; 
}; 

function get_col_station_precip($val, $val_lt, $dt_from, $dt_to) {

    // 
    // Prepare dates
    //

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');
    $my_dt_to = (new DateTime($dt_to))->format('d.m.Y');

    //
    // Check: Value available
    // 
    
    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return ["#f8f8f8ff", '<i style="font-weight: normal !important;">Kein Messwert</i>', $my_dt_from, $my_dt_to, '-', '#5e5e5e', '#5e5e5e'];
    }

    //
    // Calculate delta and prepare base values
    //

    $d = floatval($val) - floatval($val_lt);

    $my_text_col = '#fff';
    $my_text_col_light = '#5e5e5e';

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');
    $my_dt_to = (new DateTime($dt_to))->format('d.m.Y');
    
    if ($d > 0) {
        $my_val = '+ ' . get_q_round($d) . " mm";
        $my_text_col = '#fa6a05';
    } elseif ($d == 0) {
        $my_val = "+/- 0 mm";
        $my_text_col = '#000';
    } else {
        $my_val = '- ' . get_q_round($d*-1) . " mm";
        $my_text_col = '#003d80';
    }

    //
    // Check: Is base 0?
    //

    if ($val_lt == 0 && $val > 0) {
        // If Base 0 and val > 0 + infinity
        return ["rgba(215,48,39,0.5)", '+ &#8734; %', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light];
    } else if ($val_lt == 0 && $val < 0) {
        // If Base 0 and val < 0 - infinity
        return ["rgba(69,117,180,0.5)", '- &#8734; %', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light];
    } else if ($val_lt == 0 && $val == 0) {
        // If both 0 calculation nonsense
        return ["#fff", '', '', ''];
    }

    // Calc main values

    $v = round(((floatval($val)-floatval($val_lt)) / abs(floatval($val_lt))) * 100);

    if ($v < -150) { 
        $col = "rgba(69,117,180,0.7)"; 
        $my_text_col = '#0b0b64';
        $my_text_col_light = '#212529';
    } elseif ($v < -100) { 
        $col = "rgba(116,173,209,0.8)"; 
    } elseif ($v < -50) { 
        $col = "rgba(171,217,233,0.8)"; 
    } elseif ($v < 0) { 
        $col = "rgba(224,243,248,0.8)"; 
    } elseif ($v == 0) { 
        $col = "rgba(255, 255, 255, 0.8)"; 
    } elseif ($v < 50) { 
        $col = "rgba(254,224,144,0.8)"; 
    } elseif ($v < 100) {
        $col = "rgba(253,174,97,0.8)"; 
        $my_text_col = '#8b0000';
    } elseif ($v < 150) { 
        $col = "rgba(244,109,67,0.8)"; 
        $my_text_col = '#8b0000';
    } else {
        $col = 'rgba(215,48,39,0.7)';
        $my_text_col = '#8b0000';
        $my_text_col_light = '#212529';
    }

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' %';
    } elseif ($v == 0) {
        $v_str = '+/- 0 %';
        $my_text_col = '#5d5d5dff';
    } else {
        $v_str = '- ' . $v*-1 . ' %';
    } 

    return [$col, $v_str, $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light]; 
}; 

function get_col_table_airtemp($val, $val_lt) {

    //
    // Check: Value available
    // 

    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return ["#fff", '', '', ''];
    }

    //
    // Check: Is base 0?
    //

    if ($val_lt == 0 && $val > 0) {
        // If Base 0 and val > 0 + infinity
        return ["rgba(215,48,39,0.5)", '+ &#8734; %', '+ &#8734; %', '+ &#8734; %'];
    } else if ($val_lt == 0 && $val < 0) {
        // If Base 0 and val < 0 - infinity
        return ["rgba(69,117,180,0.5)", '- &#8734; %', '- &#8734; %', '- &#8734; %'];
    } else if ($val_lt == 0 && $val == 0) {
        // If both 0 calculation nonsense
        return ["#fff", '', '', ''];
    }

    //
    // Calculation
    //
    // d ... Delta
    // v ... Percent
    //

    // Celsius to Kelvin

    $val = $val + 273.15;
    $val_lt = $val_lt + 273.15;

    $d = $val - $val_lt;
    $v = round(((floatval($val)-floatval($val_lt)) / abs(floatval($val_lt))) * 100, 2);

    //
    // Define color and svg name
    //

    $col = "#fff"; 
    $svg = "";

    if ($d < -6) { 
        $col = "rgba(69,117,180,0.66)"; 
        $svg = 'down';
    } elseif ($d < -4) { 
        $col = "rgba(116,173,209,0.66)"; 
        $svg = 'down';
    } elseif ($d < -2) { 
        $col = "rgba(171,217,233,0.66)"; 
        $svg = 'down-right';
    } elseif ($d < 0) { 
        $col = "rgba(224,243,248,0.66)"; 
        $svg = 'down-right';
    } elseif ($d == 0) { 
        $col = "rgba(255,255,255,1)"; 
        $svg = 'right';
    } elseif ($d < 2) { 
        $col = "rgba(254,224,144,0.66)"; 
        $svg = 'up-right';
    } elseif ($d < 4) {
        $col = "rgba(253,174,97,0.66)"; 
        $svg = 'up-right';
    } elseif ($d < 6) { 
        $col = "rgba(244,109,67,0.66)"; 
        $svg = 'up';
    } else {
        $col = 'rgba(215,48,39,0.66)';
        $svg = 'up';
    }

    if ($d >= -0.2 && $d <= 0.2){
        // Range for straight line
        $svg = 'right';
    } 

    //
    // Prepare strings
    //

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' % in K';
    } elseif ($v == 0) {
        $v_str = '+/- 0 % in K';
    } else {
        $v_str = '- ' . $v*-1 .  ' % in K';
    }

    if ($d > 0) {
        $d_str = '+ ' . round($d,1) . ' °C';
    } elseif ($d == 0) {
        $d_str = '+/- 0 °C';
    } else {
        $d_str = '- ' . round($d*-1,1) . ' °C';
    }

    return [$col, $v_str, $d_str, $svg]; 
}; 

function get_col_station_airtemp($val, $val_lt, $dt_from, $dt_to) {

    // 
    // Prepare dates
    //

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');
    $my_dt_to = (new DateTime($dt_to))->format('d.m.Y');

    //
    // Check: Value available
    // 
    
    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return ["#f8f8f8ff", '-', $my_dt_from, $my_dt_to, '<i style="font-weight: normal !important;">Kein Messwert</i>', '#5e5e5e', '#5e5e5e'];
    }

    //
    // Calculate delta and prepare base values
    //

    $val = $val + 273.15;
    $val_lt = $val_lt + 273.15;

    $d = floatval($val) - floatval($val_lt);

    $my_text_col = '#fff';
    $my_text_col_light = '#5e5e5e';

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');
    $my_dt_to = (new DateTime($dt_to))->format('d.m.Y');
    
    if ($d > 0.1) {
        $my_val = '+ ' . round($d, 1) . " °C";
        $my_text_col = '#fa6a05';
    } elseif ($d >= -0.1) {
        $my_val = "+/- 0 °C";
        $my_text_col = '#000';
    } else {
        $my_val = '- ' . round($d*-1, 1) . " °C";
        $my_text_col = '#003d80';
    }

    //
    // Check: Is base 0?
    //

    if ($val_lt == 0 && $val > 0) {
        // If Base 0 and val > 0 + infinity
        return ["rgba(215,48,39,0.5)", '+ &#8734; %', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light];
    } else if ($val_lt == 0 && $val < 0) {
        // If Base 0 and val < 0 - infinity
        return ["rgba(69,117,180,0.5)", '- &#8734; %', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light];
    } else if ($val_lt == 0 && $val == 0) {
        // If both 0 calculation nonsense
        return ["#fff", '', '', ''];
    }

    // Calc main values

    $v = round(((floatval($val)-floatval($val_lt)) / abs(floatval($val_lt))) * 100, 2);

    if ($d < -4.5) { 
        $col = "rgba(69,117,180,0.7)"; 
        $my_text_col = '#0b0b64';
        $my_text_col_light = '#212529';
    } elseif ($d < -3) { 
        $col = "rgba(116,173,209,0.8)"; 
    } elseif ($d < -1.5) { 
        $col = "rgba(171,217,233,0.8)"; 
    } elseif ($d < 0) { 
        $col = "rgba(224,243,248,0.8)"; 
    } elseif ($d == 0) { 
        $col = "rgba(255, 255, 255, 0.8)"; 
    } elseif ($d < 1.5) { 
        $col = "rgba(254,224,144,0.8)"; 
    } elseif ($d < 3) {
        $col = "rgba(253,174,97,0.8)"; 
        $my_text_col = '#8b0000';
    } elseif ($d < 4.5) { 
        $col = "rgba(244,109,67,0.8)"; 
        $my_text_col = '#8b0000';
    } else {
        $col = 'rgba(215,48,39,0.7)';
        $my_text_col = '#8b0000';
        $my_text_col_light = '#212529';
    }

    // Overwrite white at range -0.1 - 0.1
    if ($d <= 0.1 && $d >= -0.1) {
        $col = "rgba(255, 255, 255, 0.8)"; 
    }

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' %';
    } elseif ($v == 0) {
        $v_str = '+/- 0 %';
        $my_text_col = '#5d5d5dff';
    } else {
        $v_str = '- ' . $v*-1 . ' %';
    } 

    return [$col, $v_str, $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light]; 
}; 

function get_col_table_groundwater($val, $val_lt_min, $val_lt_mean, $val_lt_max) {

    //
    // Check: Value available
    // 

    if (!is_numeric($val) || !is_numeric($val_lt_mean) || !is_numeric($val_lt_min) || !is_numeric($val_lt_max)) {
        return ["#fff", '', '', ''];
    }

    //
    // Prepare calculation
    //

    if (floatval($val) < floatval($val_lt_mean)) {
        $a = (floatval($val_lt_mean) - floatval($val_lt_min)); // = 1%
        $b = floatval($val_lt_mean) - floatval($val); // Distance to mean (positive)
    } else if (floatval($val) > floatval($val_lt_mean)) {
        $a = (floatval($val_lt_max) - floatval($val_lt_mean)); // = 1%
        $b = floatval($val_lt_mean) - floatval($val); // Distance to mean (negative)
    } else {
        return ["rgba(255,255,255,1)", '+/- 0 %', '+/- 0 m', 'right'];
    }

    //
    // Check: Is base 0?
    //

    if ($a == 0 && $b < 0) {
        // If Base 0 and val > 0 + infinity
        return ["rgba(215,48,39,0.5)", '+ &#8734; %', '+ &#8734; %', '+ &#8734; %'];
    } else if ($a == 0 && $b > 0) {
        // If Base 0 and val < 0 - infinity
        return ["rgba(69,117,180,0.5)", '- &#8734; %', '- &#8734; %', '- &#8734; %'];
    } else if ($a == 0 && $b == 0) {
        // If both 0 calculation nonsense
        return ["#fff", '', '', ''];
    }

    //
    // Calculation
    //
    // d ... Delta
    // v ... Percent
    //
    // (reverse values ... relative to ground)
    //

    $d = floatval($val_lt_mean) - floatval($val);
    $v = round($b / $a * 100);

    //
    // Define color and svg name
    //

    $col = "#fff"; 
    $svg = "";

    if ($v < -150) { 
        $col = "rgba(69,117,180,0.66)"; 
        $svg = 'down';
    } elseif ($v < -100) { 
        $col = "rgba(116,173,209,0.66)"; 
        $svg = 'down';
    } elseif ($v < -50) { 
        $col = "rgba(171,217,233,0.66)"; 
        $svg = 'down-right';
    } elseif ($v < 0) { 
        $col = "rgba(224,243,248,0.66)"; 
        $svg = 'down-right';
    } elseif ($v == 0) { 
        $col = "rgba(255,255,255,1)"; 
        $svg = 'right';
    } elseif ($v < 50) { 
        $col = "rgba(254,224,144,0.66)"; 
        $svg = 'up-right';
    } elseif ($v < 100) {
        $col = "rgba(253,174,97,0.66)"; 
        $svg = 'up-right';
    } elseif ($v < 150) { 
        $col = "rgba(244,109,67,0.66)"; 
        $svg = 'up';
    } else {
        $col = 'rgba(215,48,39,0.66)';
        $svg = 'up';
    }

    if ($v >= -2 && $v <= 2){
        // Range for straight line
        $svg = 'right';
    } 

    //
    // Prepare strings
    //

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' %';
    } elseif ($v == 0) {
        $v_str = '+/- 0 %';
    } else {
        $v_str = '- ' . $v*-1 .  ' %';
    }

    if ($d > 0) {
        $d_str = '+ ' . round($d, 2) . ' m';
    } elseif ($d == 0) {
        $d_str = '+/- 0 m';
    } else {
        $d_str = '- ' . round($d*-1, 2) . ' m';
    }

    return [$col, $v_str, $d_str, $svg]; 
}; 

function get_col_station_groundwater($val, $val_lt_min, $val_lt_mean, $val_lt_max, $dt_from, $dt_to) {

    // 
    // Prepare dates
    //

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');
    $my_dt_to = (new DateTime($dt_to))->format('d.m.Y');

    //
    // Check: Value available
    // 
    
    if (!is_numeric($val) || !is_numeric($val_lt_mean) || !is_numeric($val_lt_min) || !is_numeric($val_lt_max)) {
        return ["#f8f8f8ff", '<i style="font-weight: normal !important;">Kein Messwert</i>', $my_dt_from, $my_dt_to, '-', '#5e5e5e', '#5e5e5e'];
    }

    //
    // Calculate delta and prepare base values (reverse values ... relative to ground)
    //

    $d = floatval($val_lt_mean) - floatval($val);

    $my_text_col = '#fff';
    $my_text_col_light = '#5e5e5e';

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');
    $my_dt_to = (new DateTime($dt_to))->format('d.m.Y');
    
    if ($d > 0) {
        $my_val = '+ ' . round($d, 2) . " m";
        $my_text_col = '#fa6a05';
    } elseif ($d == 0) {
        $my_val = "+/- 0 m";
        $my_text_col = '#000';
    } else {
        $my_val = '- ' . round($d*-1, 2) . " m";
        $my_text_col = '#003d80';
    }

    //
    // Prepare calculation
    //

    if (floatval($val) < floatval($val_lt_mean)) {
        $a = (floatval($val_lt_mean) - floatval($val_lt_min)); // = 1%
        $b = floatval($val_lt_mean) - floatval($val); // Distance to mean (positive)
    } else if (floatval($val) > floatval($val_lt_mean)) {
        $a = (floatval($val_lt_max) - floatval($val_lt_mean)); // = 1%
        $b = floatval($val_lt_mean) - floatval($val); // Distance to mean (negative)
    } else {
        return ["rgba(255,255,255,1)", '+/- 0 %', '+/- 0 m', 'right'];
    }

    //
    // Check: Is base 0?
    //

    if ($a == 0 && $b < 0) {
        // If Base 0 and val > 0 + infinity
        return ["rgba(215,48,39,0.5)", '+ &#8734; %', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light];
    } else if ($a == 0 && $b > 0) {
        // If Base 0 and val < 0 - infinity
        return ["rgba(69,117,180,0.5)", '- &#8734; %', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light];
    } else if ($a == 0 && $b == 0) {
        // If both 0 calculation nonsense
        return ["#fff", '', '', '', '', '', ''];
    }

    //
    // Calculation
    //

    $v = round($b / $a * 100);

    if ($v < -150) { 
        $col = "rgba(69,117,180,0.7)"; 
        $my_text_col = '#0b0b64';
        $my_text_col_light = '#212529';
    } elseif ($v < -100) { 
        $col = "rgba(116,173,209,0.8)"; 
    } elseif ($v < -50) { 
        $col = "rgba(171,217,233,0.8)"; 
    } elseif ($v < 0) { 
        $col = "rgba(224,243,248,0.8)"; 
    } elseif ($v == 0) { 
        $col = "rgba(255, 255, 255, 0.8)"; 
    } elseif ($v < 50) { 
        $col = "rgba(254,224,144,0.8)"; 
    } elseif ($v < 100) {
        $col = "rgba(253,174,97,0.8)"; 
        $my_text_col = '#8b0000';
    } elseif ($v < 150) { 
        $col = "rgba(244,109,67,0.8)"; 
        $my_text_col = '#8b0000';
    } else {
        $col = 'rgba(215,48,39,0.7)';
        $my_text_col = '#8b0000';
        $my_text_col_light = '#212529';
    }

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' %';
    } elseif ($v == 0) {
        $v_str = '+/- 0 %';
        $my_text_col = '#5d5d5dff';
    } else {
        $v_str = '- ' . $v*-1 . ' %';
    } 

    return [$col, $v_str, $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light]; 
}; 


function get_col_table_springs($val, $val_lt) {

    //
    // Check: Value available
    // 

    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return ["#fff", '', '', ''];
    }

    //
    // Check: Is base 0?
    //

    if ($val_lt == 0 && $val > 0) {
        // If Base 0 and val > 0 + infinity
        return ["rgba(215,48,39,0.5)", '+ &#8734; %', '+ &#8734; %', '+ &#8734; %'];
    } else if ($val_lt == 0 && $val < 0) {
        // If Base 0 and val < 0 - infinity
        return ["rgba(69,117,180,0.5)", '- &#8734; %', '- &#8734; %', '- &#8734; %'];
    } else if ($val_lt == 0 && $val == 0) {
        // If both 0 calculation nonsense
        return ["#fff", '', '', ''];
    }

    //
    // Calculation
    //
    // d ... Delta
    // v ... Percent
    //

    $d = $val - $val_lt;
    $v = round(((floatval($val)-floatval($val_lt)) / abs(floatval($val_lt))) * 100);

    //
    // Define color and svg name
    //

    $col = "#fff"; 
    $svg = "";

    if ($v < -150) { 
        $col = "rgba(69,117,180,0.66)"; 
        $svg = 'down';
    } elseif ($v < -100) { 
        $col = "rgba(116,173,209,0.66)"; 
        $svg = 'down';
    } elseif ($v < -50) { 
        $col = "rgba(171,217,233,0.66)"; 
        $svg = 'down-right';
    } elseif ($v < 0) { 
        $col = "rgba(224,243,248,0.66)"; 
        $svg = 'down-right';
    } elseif ($v == 0) { 
        $col = "rgba(255,255,255,1)"; 
        $svg = 'right';
    } elseif ($v < 50) { 
        $col = "rgba(254,224,144,0.66)"; 
        $svg = 'up-right';
    } elseif ($v < 100) {
        $col = "rgba(253,174,97,0.66)"; 
        $svg = 'up-right';
    } elseif ($v < 150) { 
        $col = "rgba(244,109,67,0.66)"; 
        $svg = 'up';
    } else {
        $col = 'rgba(215,48,39,0.66)';
        $svg = 'up';
    }

    if ($v >= -2 && $v <= 2){
        // Range for straight line
        $svg = 'right';
    } 

    //
    // Prepare strings
    //

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' %';
    } elseif ($v == 0) {
        $v_str = '+/- 0 %';
    } else {
        $v_str = '- ' . $v*-1 .  ' %';
    }

    if ($d > 0) {
        $d_str = '+ ' . get_q_round($d) . ' l/s';
    } elseif ($d == 0) {
        $d_str = '+/- 0 l/s';
    } else {
        $d_str = '- ' . get_q_round($d*-1) . ' l/s';
    }

    return [$col, $v_str, $d_str, $svg]; 
}; 

function get_col_station_springs($val, $val_lt, $dt_from, $dt_to) {

    // 
    // Prepare dates
    //

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');
    $my_dt_to = (new DateTime($dt_to))->format('d.m.Y');

    //
    // Check: Value available
    // 
    
    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return ["#f8f8f8ff", '<i style="font-weight: normal !important;">Kein Messwert</i>', $my_dt_from, $my_dt_to, '-', '#5e5e5e', '#5e5e5e'];
    }

    //
    // Calculate delta and prepare base values
    //

    $d = floatval($val) - floatval($val_lt);

    $my_text_col = '#fff';
    $my_text_col_light = '#5e5e5e';

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');
    $my_dt_to = (new DateTime($dt_to))->format('d.m.Y');
    
    if ($d > 0) {
        $my_val = '+ ' . get_q_round($d) . " l/s";
        $my_text_col = '#fa6a05';
    } elseif ($d == 0) {
        $my_val = "+/- 0 l/s";
        $my_text_col = '#000';
    } else {
        $my_val = '- ' . get_q_round($d*-1) . " l/s";
        $my_text_col = '#003d80';
    }

    //
    // Check: Is base 0?
    //

    if ($val_lt == 0 && $val > 0) {
        // If Base 0 and val > 0 + infinity
        return ["rgba(215,48,39,0.5)", '+ &#8734; %', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light];
    } else if ($val_lt == 0 && $val < 0) {
        // If Base 0 and val < 0 - infinity
        return ["rgba(69,117,180,0.5)", '- &#8734; %', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light];
    } else if ($val_lt == 0 && $val == 0) {
        // If both 0 calculation nonsense
        return ["#fff", '', '', ''];
    }

    // Calc main values

    $v = round(((floatval($val)-floatval($val_lt)) / abs(floatval($val_lt))) * 100);

    if ($v < -150) { 
        $col = "rgba(69,117,180,0.7)"; 
        $my_text_col = '#0b0b64';
        $my_text_col_light = '#212529';
    } elseif ($v < -100) { 
        $col = "rgba(116,173,209,0.8)"; 
    } elseif ($v < -50) { 
        $col = "rgba(171,217,233,0.8)"; 
    } elseif ($v < 0) { 
        $col = "rgba(224,243,248,0.8)"; 
    } elseif ($v == 0) { 
        $col = "rgba(255, 255, 255, 0.8)"; 
    } elseif ($v < 50) { 
        $col = "rgba(254,224,144,0.8)"; 
    } elseif ($v < 100) {
        $col = "rgba(253,174,97,0.8)"; 
        $my_text_col = '#8b0000';
    } elseif ($v < 150) { 
        $col = "rgba(244,109,67,0.8)"; 
        $my_text_col = '#8b0000';
    } else {
        $col = 'rgba(215,48,39,0.7)';
        $my_text_col = '#8b0000';
        $my_text_col_light = '#212529';
    }

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' %';
    } elseif ($v == 0) {
        $v_str = '+/- 0 %';
        $my_text_col = '#5d5d5dff';
    } else {
        $v_str = '- ' . $v*-1 . ' %';
    } 

    return [$col, $v_str, $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light]; 
}; 

function get_col_table_temperature($val, $val_lt, $dt=false) {
    $col = "#fff"; 

    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return [$col, '', '', ''];
    }

    if ($val_lt == 0) {
        return ["rgba(215,48,39,0.5)", '', '', ''];
    } 

    $d = $val - $val_lt;
    $v = round(((floatval($val)-floatval($val_lt)) / floatval($val_lt)) * 100);

    $dt = new DateTime($dt);
    $dt_now = new DateTime();
    
    if (!$dt && $dt < $dt_now->modify('-3 day')) {
        return [$col, '', '', '']; 
    }

    $svg = "";

    if ($v < -150) { 
        $col = "rgba(69,117,180,0.66)"; 
        $svg = 'down';
    } elseif ($v < -100) { 
        $col = "rgba(116,173,209,0.66)"; 
        $svg = 'down';
    } elseif ($v < -50) { 
        $col = "rgba(171,217,233,0.66)"; 
        $svg = 'down-right';
    } elseif ($v < 0) { 
        $col = "rgba(224,243,248,0.66)"; 
        $svg = 'down-right';
    } elseif ($v < 50) { 
        $col = "rgba(254,224,144,0.66)"; 
        $svg = 'up-right';
    } elseif ($v < 100) {
        $col = "rgba(253,174,97,0.66)"; 
        $svg = 'up-right';
    } elseif ($v < 150) { 
        $col = "rgba(244,109,67,0.66)"; 
        $svg = 'up';
    } else {
        $col = 'rgba(215,48,39,0.66)';
        $svg = 'up';
    }

    if ($v > -4 && $v < 4){
        $svg = 'right';
    } 

    if ($v > 0) {
        $v_str = '+ ' . $v .  ' %';
    } elseif ($v == 0) {
        $v_str = '+/- 0 %';
    } else {
        $v_str = '- ' . $v*-1 .  ' %';
    }

    if ($d > 0) {
        $d_str = '+ ' . round($d, 1) . ' °C';
    } elseif ($d == 0) {
        $d_str = '+/- 0 °C';
    } else {
        $d_str = '- ' . round($d*-1, 1) . ' °C';
    }

    return [$col, $v_str, $d_str, $svg]; 
}; 

function get_col_station($val, $val_lt, $dt_from, $dt_to) {
    $col = "#fff"; 

    if (!is_numeric($val) || !is_numeric($val_lt)) {
        return [$col, '', $my_dt_from, $my_dt_to, 0, '', '#fff', '#fff'];
    }

    // Delta Value - Long-term

    $my_val = $val - $val_lt;

    // From - To

    $my_dt_from = (new DateTime($dt_from))->format('d.m.Y');;
    $my_dt_to = date('d.m.Y', strtotime('-1 hour', strtotime($dt_to)));
    
    // Base Colors

    $my_text_col = '#fff';
    $my_text_col_light = '#5e5e5e';
    
    if ($my_val > 0) {
        $my_val = "+" . get_q_round($my_val);
        $my_text_col = '#fa6a05';
    } elseif ($my_val == 0) {
        $my_val = "+/- 0";
        $my_text_col = '#fff';
    } else {
        $my_val = "-" . get_q_round($my_val*-1);
        $my_text_col = '#003d80';
    }

    // Return white if last value older 3 days

    $dt = new DateTime($dt_to);
    $dt_now = new DateTime();
    
    if (!$dt && $dt < $dt_now->modify('-3 day')) {
        return [$col, '-', $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light]; 
    }
    
    // Return red if lt = 0

    if ($val_lt == 0) {
        return ['rgba(215,48,39,0.8)', '-', $my_dt_from, $my_dt_to, $my_val, $my_text_col, '#212529'];
    } 

    // Calc main values

    $v = round(((floatval($val)-floatval($val_lt)) / floatval($val_lt)) * 100);

    if ($val < 0 && $val_lt < 0) {
        $v = $v*-1;
    }

    if ($v < -150) { 
        $col = "rgba(69,117,180,0.7)"; 
        $my_text_col = '#0b0b64';
        $my_text_col_light = '#212529';
    } elseif ($v < -100) { 
        $col = "rgba(116,173,209,0.8)"; 
    } elseif ($v < -50) { 
        $col = "rgba(171,217,233,0.8)"; 
    } elseif ($v < 0) { 
        $col = "rgba(224,243,248,0.8)"; 
    } elseif ($v < 50) { 
        $col = "rgba(254,224,144,0.8)"; 
    } elseif ($v < 100) {
        $col = "rgba(253,174,97,0.8)"; 
        $my_text_col = '#8b0000';
    } elseif ($v < 150) { 
        $col = "rgba(244,109,67,0.8)"; 
        $my_text_col = '#8b0000';
    } else {
        $col = 'rgba(215,48,39,0.7)';
        $my_text_col = '#8b0000';
        $my_text_col_light = '#212529';
    }

    if ($v > 0) {
        $v_str = '+ ' . round($v, 1) .  ' %';
    } elseif ($v == 0) {
        $v_str = '+/- 0 %';
    } else {
        $v_str = '- ' . round($v, 1)*-1 .  ' %';
    } 

    return [$col, $v_str, $my_dt_from, $my_dt_to, $my_val, $my_text_col, $my_text_col_light]; 
}; 

function get_perc_results($num, $num_expected) {
    if ($num == 0) {
        return '<span style="color: red">0 %</span>';
    } else {
        $perc = $num / $num_expected * 100;

        if ($perc > 95) {
            return '<span style="color: darkgreen">' .  round($perc) . ' %</span>'; 
        } elseif ($perc > 50) {
            return '<span style="color: #ff4d00">' .  round($perc) . ' %</span>'; 
        } else {
            return '<span style="color: red">' .  round($perc) . ' %</span>'; 
        }
    } 
}

function get_versatz($inp) {
    if (is_null($inp)) {
        return "0";
    } else {
        return $inp;
    }
}

function append_sign($v, $r, $sym) {
    if (is_null($v) || $v == -9999) {
        return "-";
    }

    $v = round($v, $r);

    if ($v > 0) {
        return '+ ' . $v . ' ' . $sym;
    } elseif ($v == 0) {
        return '+/- 0 ' . $sym;
    } else {
        return '- ' . $v*-1 . ' ' . $sym;
    } 
}
