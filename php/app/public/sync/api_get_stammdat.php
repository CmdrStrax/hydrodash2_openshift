<?php

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["error" => "Nur GET erlaubt"]);
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

    $stmt = $pdo->query("SELECT id, zrid FROM ds");

    $rows = $stmt->fetchAll();

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
