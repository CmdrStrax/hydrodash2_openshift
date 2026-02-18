<?php

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Nur POST erlaubt"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['ds_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Ungültige Daten"]);
    exit;
}

try {

    $db_host = getenv('POSTGRES_HOST');
    $db_user = getenv('POSTGRES_USER');
    $db_password = getenv('POSTGRES_PASSWORD');
    $db_database = getenv('POSTGRES_DB');
    $db_port = getenv('POSTGRES_PORT');

    $pdo = new PDO(
        "pgsql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_database,
        $db_user,
        $db_password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $pdo_main->beginTransaction();

    /*
     * 1️ ds_info UPSERT
     */

    $stmt = $pdo_main->prepare("
        INSERT INTO ds_info 
            (ds_id, name, hzbnr, dbmnr, ae, altitude, stream, operator, parameter, webjob)
        VALUES 
            (:ds_id, :name, :hzbnr, :dbmnr, :ae, :altitude, :stream, :operator, :parameter, :webjob)
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
    ");

    $stmt->execute([
        ":ds_id" => $data['ds_id'],
        ":name" => $data['name'],
        ":hzbnr" => $data['hzbnr'],
        ":dbmnr" => $data['dbmnr'],
        ":ae" => $data['ae'],
        ":altitude" => $data['altitude'],
        ":stream" => $data['stream'],
        ":operator" => $data['operator'],
        ":parameter" => $data['parameter'],
        ":webjob" => $data['webjob']
    ]);


    /*
     * 2️ ds_geo UPSERT (PostGIS)
     */

    $stmt = $pdo_main->prepare("
        INSERT INTO ds_geo (ds_id, coord)
        VALUES (:ds_id, ST_GeomFromText(:point, 4326))
        ON CONFLICT (ds_id) DO UPDATE
        SET coord = ST_GeomFromText(:point, 4326)
    ");

    $point = "POINT(" . $data['lon'] . " " . $data['lat'] . ")";

    $stmt->execute([
        ":ds_id" => $data['ds_id'],
        ":point" => $point
    ]);

    /*
     * 3 ds_statvalues UPSERT
     */

    $stmtStat = $pdo_main->prepare("
        INSERT INTO ds_statvalues (ds_id, name, val, comment)
        VALUES (:ds_id, :name, :val, :comment)
        ON CONFLICT (ds_id, name) DO UPDATE SET
            val = EXCLUDED.val,
            comment = EXCLUDED.comment
    ");

    foreach ($data['kennwerte'] as $r) {
        $stmtStat->execute([
            ":ds_id" => $data['ds_id'],
            ":name" => $r['rolle'],
            ":val" => $r['wert'],
            ":comment" => $r['langtext']
        ]);
    }

    $stmtCatchments = $pdo_main->query("
        SELECT id, name
        FROM ds_catchments
    ");

    $catchments = $stmtCatchments->fetchAll(PDO::FETCH_ASSOC);
    $catchment_id = -1;

    foreach ($catchments as $c) {
        if (strpos($c['name'], $data['einzugsgebiet']) !== false) {
            $catchment_id = $c['id'];
            break; // erstes Match reicht
        }
      }

    if ($catchment_id >= 0) {

      $stmtUpdate = $pdo_main->prepare("
	UPDATE ds
	SET catchment_id = :cid
	WHERE id = :ds_id
      ");

      $stmtUpdate->execute([
	":cid"   => $catchment_id,
	":ds_id" => $data['ds_id']   // oder row[0] falls aus Schleife
      ]);
    }

    $pdo_main->commit();

    echo json_encode(["success" => true]);

} catch (Exception $e) {

    if ($pdo_main->inTransaction()) {
        $pdo_main->rollBack();
    }

    http_response_code(500);
    echo json_encode(["error" => "Serverfehler" . $e->getMessage() ]);
}
