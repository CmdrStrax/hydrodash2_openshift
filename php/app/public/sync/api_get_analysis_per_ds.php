<?php
header("Content-Type: application/json");

// Nur GET erlauben
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["error" => "Nur GET erlaubt"]);
    exit;
}

if (!isset($_GET['ds_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Parameter 'ds_id' fehlt"]);
    exit;
}

$ds_id = (int)$_GET['ds_id'];

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

    $stmt = $pdo->prepare("
        SELECT 
            id,
            name,
            period,
            stat
        FROM ds_analysis
        WHERE ds_id = :ds_id
        ORDER BY name
    ");

    $stmt->execute([
        ":ds_id" => $ds_id
    ]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "count" => count($rows),
        "data" => $rows
    ]);

} catch (Exception $e) {

    http_response_code(500);
    echo json_encode([
        "error" => "Serverfehler",
        "message" => $e->getMessage()
    ]);
}