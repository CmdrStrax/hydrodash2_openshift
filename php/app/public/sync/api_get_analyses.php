<?php
header("Content-Type: application/json");

// Nur GET erlauben
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

    // -------------------------
    // Fall 1: id gesetzt
    // -------------------------
    if (isset($_GET['id']) && $_GET['id'] !== "") {

        $stmt = $pdo->prepare("
            SELECT 
                d.id,
                d.start_hour,
                i.name,
                i.parameter
            FROM ds d
            INNER JOIN ds_info i ON i.ds_id = d.id
            WHERE d.id = :id
        ");

        $stmt->execute([
            ":id" => (int)$_GET['id']
        ]);

    }
    // -------------------------
    // Fall 2: parameter verwenden
    // -------------------------
    else {

        if (!isset($_GET['parameter'])) {
            http_response_code(400);
            echo json_encode(["error" => "Parameter 'parameter' fehlt"]);
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT 
                d.id,
                d.start_hour,
                i.name,
                i.parameter
            FROM ds d
            INNER JOIN ds_info i ON i.ds_id = d.id
            WHERE i.parameter = :parameter
              AND d.active = TRUE
        ");

        $stmt->execute([
            ":parameter" => $_GET['parameter']
        ]);
    }

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
