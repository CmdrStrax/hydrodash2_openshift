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
    // ts_categories abfragen
    // -------------------------
    $stmt = $pdo->query("SELECT id, name_short FROM ts_categories");
    $rows = $stmt->fetchAll();

    // -------------------------
    // IDs initialisieren
    // -------------------------
    $cat_live   = -1;
    $cat_lt_max = -1;
    $cat_lt_mean= -1;
    $cat_lt_min = -1;

    foreach ($rows as $row) {
        switch ($row['name_short']) {
            case 'live':
                $cat_live = $row['id'];
                break;
            case 'lt_max':
                $cat_lt_max = $row['id'];
                break;
            case 'lt_mean':
                $cat_lt_mean = $row['id'];
                break;
            case 'lt_min':
                $cat_lt_min = $row['id'];
                break;
        }
    }

    // -------------------------
    // Prüfen ob alle Kategorien gefunden wurden
    // -------------------------
    if ($cat_live == -1 || $cat_lt_max == -1 || $cat_lt_mean == -1 || $cat_lt_min == -1) {
        http_response_code(500);
        echo json_encode([
            "error" => "Konnte ts_categories nicht vollständig abrufen."
        ]);
        exit;
    }

    // -------------------------
    // JSON-Antwort zurückgeben
    // -------------------------
    echo json_encode([
        "success"   => true,
        "cat_live"  => $cat_live,
        "cat_lt_max"=> $cat_lt_max,
        "cat_lt_mean"=> $cat_lt_mean,
        "cat_lt_min"=> $cat_lt_min
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Serverfehler"
    ]);
}