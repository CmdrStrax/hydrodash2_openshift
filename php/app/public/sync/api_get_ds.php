<?php
header("Content-Type: application/json");

// Nur GET erlauben
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["error" => "Nur GET erlaubt"]);
    exit;
}

// Query-Parameter aus URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
$parameter = isset($_GET['parameter']) ? $_GET['parameter'] : null;

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

    // -------------------------
    // SQL vorbereiten
    // -------------------------
    if ($id !== null) {
        $stmt = $pdo->prepare("
            SELECT d.id, d.zrid, d.zrid_lt, d.zrid_info, d.stat, d.lt_from, d.lt_to, d.start_hour,
                   i.name, i.parameter, d.lt_minyear, d.lt_maxyear
            FROM ds d
            INNER JOIN ds_info i ON i.ds_id = d.id
            WHERE d.active AND d.id = :id
        ");
        $stmt->execute([":id" => $id]);

    } else {
        if ($parameter === null) {
            http_response_code(400);
            echo json_encode(["error" => "Parameter oder ID muss gesetzt sein."]);
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT d.id, d.zrid, d.zrid_lt, d.zrid_info, d.stat, d.lt_from, d.lt_to, d.start_hour,
                   i.name, i.parameter, d.lt_minyear, d.lt_maxyear
            FROM ds d
            INNER JOIN ds_info i ON i.ds_id = d.id
            WHERE d.active AND i.parameter = :param
        ");

        $stmt->execute([":param" => "$parameter"]);
    }

    // -------------------------
    // Daten abrufen
    // -------------------------
    $rows = $stmt->fetchAll();

    // -------------------------
    // JSON zurückgeben
    // -------------------------
    echo json_encode([
        "success" => true,
        "count"   => count($rows),
        "data"    => $rows
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Serverfehler",
        "message" => $e->getMessage()
    ]);
}