<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Nur POST erlaubt"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['rows']) || !is_array($data['rows'])) {
    http_response_code(400);
    echo json_encode(["error" => "Ungültige Daten, 'rows' erwartet"]);
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

    $pdo->beginTransaction();

    // -------------------------
    // Prepared Statement mit numnan
    // -------------------------
    $stmt = $pdo->prepare("
        INSERT INTO ts (ds_id, cat_id, dt, val, numnan)
        VALUES (:ds_id, :cat_id, :dt, :val, :numnan)
        ON CONFLICT (ds_id, cat_id, dt) DO UPDATE
        SET val = EXCLUDED.val,
            numnan = EXCLUDED.numnan
    ");

    $successCount = 0;

    foreach ($data['rows'] as $row) {
        // Erwartet: [ds_id, cat_id, dt, val, numnan]
        if (count($row) != 5) continue; // skip invalid rows

        $success = $stmt->execute([
            ":ds_id"   => $row[0],
            ":cat_id"  => $row[1],
            ":dt"      => $row[2],
            ":val"     => $row[3],
            ":numnan"  => $row[4]
        ]);

        if ($success) $successCount++;
    }

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "count" => $successCount
    ]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    http_response_code(500);
    echo json_encode([
        "error" => "Serverfehler",
        "message" => $e->getMessage()
    ]);
}
