<?php
header("Content-Type: application/json");

// Nur POST erlauben
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Nur POST erlaubt"]);
    exit;
}

// JSON Input
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['ds_id']) || !isset($data['initiated_by']) || !isset($data['initiated_at'])) {
    http_response_code(400);
    echo json_encode(["error" => "Fehlende Felder: ds_id, initiated_by, initiated_at erforderlich"]);
    exit;
}

$ds_id = (int)$data['ds_id'];
$initiated_by = $data['initiated_by'];
$initiated_at = $data['initiated_at'];

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

    // Begin Transaction
    $pdo->beginTransaction();

    // DELETE aus ds_jobs
    $stmt1 = $pdo->prepare("DELETE FROM ds_jobs WHERE ds_id = :ds_id");
    $stmt1->execute([":ds_id" => $ds_id]);

    // INSERT in ds_jobs_archive
    $stmt2 = $pdo->prepare("
        INSERT INTO ds_jobs_archive (ds_id, initiated_by, initiated_at)
        VALUES (:ds_id, :initiated_by, :initiated_at)
    ");
    $stmt2->execute([
        ":ds_id" => $ds_id,
        ":initiated_by" => $initiated_by,
        ":initiated_at" => $initiated_at
    ]);

    // Commit
    $pdo->commit();

    echo json_encode([
        "success" => true,
        "ds_id" => $ds_id
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode([
        "error" => "Serverfehler",
        "message" => $e->getMessage()
    ]);
}
