<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; 
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\API\ResponseTrait;

use App\Models\MenuModel;


class ApiSync extends BaseController
{
    protected $format = 'json';
    use ResponseTrait;

    /* ============================================================
     * GET: Analyses
     * ============================================================ */

    public function api_get_analyses()
    {
        if (!$this->request->is('get')) {
            return $this->fail('Nur GET erlaubt', 405);
        }

        $db = \Config\Database::connect();

        try {
            $id = $this->request->getGet('id');
            $parameter = $this->request->getGet('parameter');

            if ($id !== null && $id !== "") {

                $builder = $db->table('ds d')
                    ->select('d.id, d.start_hour, i.name, i.parameter')
                    ->join('ds_info i', 'i.ds_id = d.id')
                    ->where('d.id', (int)$id);

                $query = $builder->get();

            } else {

                if ($parameter === null || $parameter === "") {
                    return $this->fail('Parameter "parameter" fehlt', 400);
                }

                $builder = $db->table('ds d')
                    ->select('d.id, d.start_hour, i.name, i.parameter')
                    ->join('ds_info i', 'i.ds_id = d.id')
                    ->where('i.parameter', $parameter)
                    ->where('d.active', true);

                $query = $builder->get();
            }

            $rows = $query->getResultArray();

            foreach ($rows as &$row) {
                if (isset($row['id'])) {
                    $row['id'] = (int)$row['id'];
                }
                if (isset($row['start_hour'])) {
                    $row['start_hour'] = (int)$row['start_hour'];
                }
            }
            unset($row);

            return $this->respond([
                'success' => true,
                'count' => count($rows),
                'data' => $rows
            ]);

        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /* ============================================================
     * GET: Analysis per DS
     * ============================================================ */
    public function api_get_analysis_per_ds()
    {
        if (!$this->request->is('get')) {
            return $this->fail('Nur GET erlaubt', 405);
        }

        $ds_id = $this->request->getGet('ds_id');

        if ($ds_id === null || $ds_id === '') {
            return $this->fail('Parameter "ds_id" fehlt', 400);
        }

        $ds_id = (int)$ds_id;
        $db = \Config\Database::connect();

        try {
            $rows = $db->table('ds_analysis')
                ->select('id, name, period, stat')
                ->where('ds_id', $ds_id)
                ->orderBy('name')
                ->get()
                ->getResultArray();

            foreach ($rows as &$row) {
                if (isset($row['id'])) {
                    $row['id'] = (int)$row['id'];
                }
            }
            unset($row);

            return $this->respond([
                'success' => true,
                'count' => count($rows),
                'data' => $rows
            ]);

        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /* ============================================================
     * GET: Categories
     * ============================================================ */
    public function api_get_categories()
    {
        if (!$this->request->is('get')) {
            return $this->fail('Nur GET erlaubt', 405);
        }

        $db = \Config\Database::connect();

        try {
            $rows = $db->table('ts_categories')
                ->select('id, name_short')
                ->get()
                ->getResultArray();

            foreach ($rows as &$row) {
                if (isset($row['id'])) {
                    $row['id'] = (int)$row['id'];
                }
            }
            unset($row);

            $cat_live = -1;
            $cat_lt_max = -1;
            $cat_lt_mean = -1;
            $cat_lt_min = -1;

            foreach ($rows as $row) {
                switch ($row['name_short']) {
                    case 'live': $cat_live = $row['id']; break;
                    case 'lt_max': $cat_lt_max = $row['id']; break;
                    case 'lt_mean': $cat_lt_mean = $row['id']; break;
                    case 'lt_min': $cat_lt_min = $row['id']; break;
                }
            }

            return $this->respond([
                'success' => true,
                'cat_live' => (int)$cat_live,
                'cat_lt_max' => (int)$cat_lt_max,
                'cat_lt_mean' => (int)$cat_lt_mean,
                'cat_lt_min' => (int)$cat_lt_min
            ]);

        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /* ============================================================
     * GET: DS
     * ============================================================ */
    public function api_get_ds()
    {
        if (!$this->request->is('get')) {
            return $this->fail('Nur GET erlaubt', 405);
        }

        $id = $this->request->getGet('id');
        $parameter = $this->request->getGet('parameter');

        if ($id === null && $parameter === null) {
            return $this->fail('Parameter oder ID muss gesetzt sein.', 400);
        }

        $db = \Config\Database::connect();

        try {
            $builder = $db->table('ds d')
                ->select('d.id, d.zrid, d.zrid_lt, d.zrid_info, d.stat, d.lt_from, d.lt_to, d.start_hour, i.name, i.parameter, d.lt_minyear, d.lt_maxyear')
                ->join('ds_info i', 'i.ds_id = d.id')
                ->where('d.active', true);

            if ($id !== null) {
                $builder->where('d.id', (int)$id);
            } else {
                $builder->where('i.parameter', $parameter);
            }

            $rows = $builder->get()->getResultArray();

            foreach ($rows as &$row) {
                if (isset($row['id'])) {
                    $row['id'] = (int)$row['id'];
                }
                if (isset($row['start_hour'])) {
                    $row['start_hour'] = (int)$row['start_hour'];
                }
            }
            unset($row);

            return $this->respond([
                'success' => true,
                'count' => count($rows),
                'data' => $rows
            ]);

        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /* ============================================================
     * GET: Jobs
     * ============================================================ */
    public function api_get_jobs()
    {
        if (!$this->request->is('get')) {
            return $this->fail('Nur GET erlaubt', 405);
        }

        $db = \Config\Database::connect();

        try {
            $rows = $db->table('ds_jobs')
                ->select('ds_id, initiated_by, initiated_at')
                ->orderBy('initiated_at')
                ->limit(10)
                ->get()
                ->getResultArray();

            foreach ($rows as &$row) {
                if (isset($row['ds_id'])) {
                    $row['ds_id'] = (int)$row['ds_id'];
                }
            }
            unset($row);

            return $this->respond([
                'success' => true,
                'count' => count($rows),
                'data' => $rows
            ]);

        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /* ============================================================
     * GET: Stammdat
     * ============================================================ */
    public function api_get_stammdat()
    {
        if (!$this->request->is('get')) {
            return $this->fail('Nur GET erlaubt', 405);
        }

        $db = \Config\Database::connect();

        try {
            $rows = $db->table('ds')
                ->select('id, zrid')
                ->get()
                ->getResultArray();

            foreach ($rows as &$row) {
                if (isset($row['id'])) {
                    $row['id'] = (int)$row['id'];
                }
            }
            unset($row);

            return $this->respond([
                'success' => true,
                'count' => count($rows),
                'data' => $rows
            ]);

        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /* ============================================================
     * GET: TS
     * ============================================================ */
    public function api_get_ts()
    {
        if (!$this->request->is('get')) {
            return $this->fail('Nur GET erlaubt', 405);
        }

        $ds_id = $this->request->getGet('ds_id');

        if ($ds_id === null || $ds_id === '') {
            return $this->fail('Parameter "ds_id" fehlt', 400);
        }

        $ds_id = (int)$ds_id;
        $db = \Config\Database::connect();

        try {
            $rows = $db->table('ts')
                ->select('cat_id, dt, val, numnan')
                ->where('ds_id', $ds_id)
                ->orderBy('cat_id')
                ->orderBy('dt')
                ->get()
                ->getResultArray();

            foreach ($rows as &$row) {
                if (isset($row['ds_id'])) {
                    $row['ds_id'] = (int)$row['ds_id'];
                }
            }
            unset($row);

            return $this->respond([
                'success' => true,
                'count' => count($rows),
                'data' => $rows
            ]);

        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function api_post_archive_ds_jobs()
    {
        // Nur POST erlauben
        if (!$this->request->is('post')) {
            return $this->fail('Nur POST erlaubt', 405);
        }

        $data = $this->request->getJSON(true); // true = als Array

        if (!$data || !isset($data['ds_id'], $data['initiated_by'], $data['initiated_at'])) {
            return $this->fail('Fehlende Felder: ds_id, initiated_by, initiated_at erforderlich', 400);
        }

        $ds_id = (int) $data['ds_id'];
        $initiated_by = $data['initiated_by'];
        $initiated_at = $data['initiated_at'];

        $db = \Config\Database::connect();
        $db->transStart(); // Begin Transaction

        try {
            // DELETE aus ds_jobs
            $db->table('ds_jobs')->where('ds_id', $ds_id)->delete();

            // INSERT in ds_jobs_archive
            $db->table('ds_jobs_archive')->insert([
                'ds_id'        => $ds_id,
                'initiated_by' => $initiated_by,
                'initiated_at' => $initiated_at
            ]);

            $db->transComplete(); // Commit

            if ($db->transStatus() === false) {
                return $this->failServerError('Transaktion konnte nicht abgeschlossen werden.');
            }

            return $this->respond([
                'success' => true,
                'ds_id'   => $ds_id
            ]);

        } catch (\Throwable $e) {
            $db->transRollback();
            return $this->failServerError($e->getMessage());
        }
    }

    public function api_post_comment() 
    {
        // Nur POST erlauben
        if (!$this->request->is('post')) {
            return $this->fail('Nur POST erlaubt', 405);
        }

        $data = $this->request->getJSON(true); // als Array

        if (!$data || !isset($data['ds_id'], $data['comment'])) {
            return $this->fail('ds_id und comment müssen gesetzt sein', 400);
        }

        $ds_id = (int) $data['ds_id'];
        $name = $data['name'] ?? 'lt_numnan';
        $comment = $data['comment'];
        $internal = $data['internal'] ?? true;
        $val = $data['val'] ?? null;

        $db = \Config\Database::connect();

        try {
            // CI4 Query Builder für Upsert (PostgreSQL)
            $builder = $db->table('ds_tslog');

            $sql = "
                INSERT INTO ds_tslog (ds_id, name, comment, internal, val)
                VALUES (:ds_id:, :name:, :comment:, :internal:, :val:)
                ON CONFLICT (ds_id, name) DO UPDATE
                SET comment = EXCLUDED.comment,
                    internal = EXCLUDED.internal,
                    val = EXCLUDED.val
            ";

            $db->query($sql, [
                'ds_id'   => $ds_id,
                'name'    => $name,
                'comment' => $comment,
                'internal'=> $internal,
                'val'     => $val
            ]);

            return $this->respond([
                'success' => true,
                'ds_id'   => $ds_id
            ]);

        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function api_post_results()
    {
        // Nur POST erlauben
        if (!$this->request->is('post')) {
            return $this->fail('Nur POST erlaubt', 405);
        }

        $data = $this->request->getJSON(true); // true = als Array

        if (!$data || !isset($data['analysis_id'])) {
            return $this->fail('analysis_id fehlt', 400);
        }

        $db = \Config\Database::connect();

        try {
            // Upsert mit ON CONFLICT für PostgreSQL
            $sql = "
                INSERT INTO ds_results (
                    analysis_id,
                    val,
                    val_lt,
                    val_min,
                    val_lt_min,
                    val_max,
                    val_lt_max,
                    valid_from,
                    valid_to,
                    stat,
                    comment,
                    num_values_expected,
                    num_values_live,
                    num_values_lt
                )
                VALUES (
                    :analysis_id:,
                    :val:,
                    :val_lt:,
                    :val_min:,
                    :val_lt_min:,
                    :val_max:,
                    :val_lt_max:,
                    :valid_from:,
                    :valid_to:,
                    :stat:,
                    :comment:,
                    :num_values_expected:,
                    :num_values_live:,
                    :num_values_lt:
                )
                ON CONFLICT (analysis_id) DO UPDATE SET
                    val = EXCLUDED.val,
                    val_lt = EXCLUDED.val_lt,
                    val_min = EXCLUDED.val_min,
                    val_lt_min = EXCLUDED.val_lt_min,
                    val_max = EXCLUDED.val_max,
                    val_lt_max = EXCLUDED.val_lt_max,
                    valid_from = EXCLUDED.valid_from,
                    valid_to = EXCLUDED.valid_to,
                    stat = EXCLUDED.stat,
                    comment = EXCLUDED.comment,
                    num_values_expected = EXCLUDED.num_values_expected,
                    num_values_live = EXCLUDED.num_values_live,
                    num_values_lt = EXCLUDED.num_values_lt
            ";

            $db->query($sql, [
                'analysis_id'        => $data['analysis_id'],
                'val'                => $data['val'] ?? null,
                'val_lt'             => $data['val_lt'] ?? null,
                'val_min'            => $data['val_min'] ?? null,
                'val_lt_min'         => $data['val_lt_min'] ?? null,
                'val_max'            => $data['val_max'] ?? null,
                'val_lt_max'         => $data['val_lt_max'] ?? null,
                'valid_from'         => $data['valid_from'] ?? null,
                'valid_to'           => $data['valid_to'] ?? null,
                'stat'               => $data['stat'] ?? null,
                'comment'            => $data['comment'] ?? null,
                'num_values_expected'=> $data['num_values_expected'] ?? null,
                'num_values_live'    => $data['num_values_live'] ?? null,
                'num_values_lt'      => $data['num_values_lt'] ?? null
            ]);

            return $this->respond([
                'success' => true,
                'analysis_id' => $data['analysis_id']
            ]);

        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function api_post_stammdat()
    {
        // Nur POST erlauben
        if (!$this->request->is('post')) {
            return $this->fail('Nur POST erlaubt', 405);
        }

        $data = $this->request->getJSON(true); // true = als Array

        if (!$data || !isset($data['ds_id'])) {
            return $this->fail('Ungültige Daten', 400);
        }

        $db = \Config\Database::connect();
        $catchments = $db->table('ds_catchments')->select('id, name')->get()->getResultArray();
        

        //$db->transStart(); // Begin Transaction

        try {
            $ds_id = (int) $data['ds_id'];

            // -------------------------
            // 1. ds_info UPSERT
            // -------------------------
            $sqlInfo = "INSERT INTO ds_info 
                    (ds_id, name, hzbnr, dbmnr, ae, altitude, stream, operator, parameter, webjob)
                VALUES 
                    (:ds_id:, :name:, :hzbnr:, :dbmnr:, :ae:, :altitude:, :stream:, :operator:, :parameter:, :webjob:)
                ON CONFLICT (ds_id) DO UPDATE SET
                    name = EXCLUDED.name,
                    hzbnr = EXCLUDED.hzbnr,
                    dbmnr = EXCLUDED.dbmnr,
                    ae = EXCLUDED.ae,
                    altitude = EXCLUDED.altitude,
                    stream = EXCLUDED.stream,
                    operator = EXCLUDED.operator,
                    parameter = EXCLUDED.parameter,
                    webjob = EXCLUDED.webjob
            ";

            $db->query($sqlInfo, [
                'ds_id'    => $ds_id,
                'name'     => $data['name'] ?? null,
                'hzbnr'    => $data['hzbnr'] ?? null,
                'dbmnr'    => $data['dbmnr'] ?? null,
                'ae'       => $data['ae'] ?? null,
                'altitude' => $data['altitude'] ?? null,
                'stream'   => $data['stream'] ?? null,
                'operator' => $data['operator'] ?? null,
                'parameter'=> $data['parameter'] ?? null,
                'webjob'   => $data['webjob'] ?? null
            ]);

            // -------------------------
            // 2. ds_geo UPSERT (PostGIS)
            // -------------------------
            $sqlGeo = "
                INSERT INTO ds_geo (ds_id, coord)
                VALUES (:ds_id:, ST_GeomFromText(:point:, 4326))
                ON CONFLICT (ds_id) DO UPDATE
                SET coord = ST_GeomFromText(:point:, 4326)
            ";

            $point = "POINT({$data['lon']} {$data['lat']})";

            $db->query($sqlGeo, [
                'ds_id' => $ds_id,
                'point' => $point
            ]);

            // -------------------------
            // 3. ds_statvalues UPSERT
            // -------------------------
            $sqlStat = "
                INSERT INTO ds_statvalues (ds_id, name, val, comment)
                VALUES (:ds_id:, :name:, :val:, :comment:)
                ON CONFLICT (ds_id, name) DO UPDATE SET
                    val = EXCLUDED.val,
                    comment = EXCLUDED.comment
            ";

            foreach ($data['kennwerte'] ?? [] as $r) {
                $db->query($sqlStat, [
                    'ds_id'   => $ds_id,
                    'name'    => $r['rolle'] ?? null,
                    'val'     => $r['wert'] ?? null,
                    'comment' => $r['langtext'] ?? null
                ]);
            }

            // -------------------------
            // 4. Catchment-ID ermitteln und ds aktualisieren
            // -------------------------
            
            $catchment_id = -1;

            foreach ($catchments as $c) {
                if (isset($data['einzugsgebiet']) && strpos($c['name'], $data['einzugsgebiet']) !== false) {
                    $catchment_id = $c['id'];
                    break; // erstes Match reicht
                }
            }

            if ($catchment_id >= 0) {
                $db->table('ds')->where('id', $ds_id)->update(['catchment_id' => $catchment_id]);
            }

            /*$db->transComplete();

            if ($db->transStatus() === false) {
              $error = $db->error();
                return $this->failServerError('Transaktion konnte nicht abgeschlossen werden.');
            }*/

            return $this->respond(['success' => true]);

        } catch (\Throwable $e) {
          $db->transRollback();
          return $this->failServerError($e->getMessage());
        }
    }



    public function api_post_ts() 
    {
        // Nur POST erlaubt
        if (!$this->request->is('post')) {
            return $this->fail('Nur POST erlaubt', 405);
        }

        $data = $this->request->getJSON(true); // true = als Array

        if (!$data || !isset($data['rows']) || !is_array($data['rows'])) {
            return $this->fail("Ungültige Daten, 'rows' erwartet", 400);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // -------------------------
            // Prepared Statement mit numnan
            // -------------------------
            $sql = "
                INSERT INTO ts (ds_id, cat_id, dt, val, numnan)
                VALUES (:ds_id:, :cat_id:, :dt:, :val:, :numnan:)
                ON CONFLICT (ds_id, cat_id, dt) DO UPDATE
                SET val = EXCLUDED.val,
                    numnan = EXCLUDED.numnan
            ";

            $successCount = 0;

            foreach ($data['rows'] as $row) {
                // Erwartet: [ds_id, cat_id, dt, val, numnan]
                if (!is_array($row) || count($row) !== 5) continue;

                $res = $db->query($sql, [
                    'ds_id'  => $row[0],
                    'cat_id' => $row[1],
                    'dt'     => $row[2],
                    'val'    => $row[3],
                    'numnan' => $row[4]
                ]);

                if ($res) $successCount++;
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->failServerError('Transaktion konnte nicht abgeschlossen werden.');
            }

            return $this->respond([
                'success' => true,
                'count'   => $successCount
            ]);

        } catch (\Throwable $e) {
            $db->transRollback();
            return $this->failServerError($e->getMessage());
        }
    }

    public function refresh_mv(String $mv = null)
    {
        $db = db_connect();
        $adminmsg = "";

        try {
            $db->transException(true)->transStart();
            $db->query('REFRESH MATERIALIZED VIEW "mv_' . $mv . '"');
            $db->transComplete();

            $adminmsg = "Refreshed Materialized View \"mv_" . $mv . "\"";            
        } catch (DatabaseException $e) {
            $msg = $e->getMessage();

            if (str_contains($msg, 'does not exist')) {
                $adminmsg = "Materalized View \"" . $mv . "\" existiert nicht.";
            } else {
                $adminmsg = "Fehler in Transaktion (PG: " . $msg . ")";
            }
        }

        return $this->respond(['msg'   => $adminmsg]);
    }

    public function refresh_mv_all()
    {
        $db = db_connect();

        $msg = "";

        try {
            $db->transException(true)->transStart();
            $db->query('REFRESH MATERIALIZED VIEW "mv_discharge"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_discharge_basins"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_watertemp"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_watertemp_basins"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_airtemp"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_airtemp_basins"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_precip"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_precip_basins"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_groundwater"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_groundwater_basins"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_springs"');
            $db->query('REFRESH MATERIALIZED VIEW "mv_springs_basins"');

            $db->transComplete();
            
            $msg = "Success";
        } catch (DatabaseException $e) {
            $msg = $e->getMessage();
        }

        return $this->respond(['msg'   => $msg]);
    }
}
