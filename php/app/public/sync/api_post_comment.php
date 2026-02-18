<?php
header("Content-Type: application/json");

// Nur POST erlauben
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Nur POST erlaubt"]);
    exit;
}

// JSON Body einlesen
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['ds_id']) || !isset($data['comment'])) {
    http_response_code(400);
    echo json_encode(["error" => "ds_id und comment müssen gesetzt sein"]);
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
    // UPSERT in ds_tslog
    // -------------------------
    $stmt = $pdo->prepare("
        INSERT INTO ds_tslog (ds_id, name, comment, internal, val)
        VALUES (:ds_id, :name, :comment, :internal, :val)
        ON CONFLICT (ds_id, name) DO UPDATE
        SET comment = EXCLUDED.comment,
            internal = EXCLUDED.internal,
            val =  EXCLUDED.val
    ");

    $stmt->execute([
        ":ds_id"   => $data['ds_id'],
        ":name"    => $data['name'] ?? 'lt_numnan', // Standardname
        ":comment" => $data['comment'],
        ":internal"=> $data['internal'] ?? true,
        ":val"=> $data['val'] ?? null
    ]);

    echo json_encode([
        "success" => true,
        "ds_id" => $data['ds_id']
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Serverfehler"]);
}
