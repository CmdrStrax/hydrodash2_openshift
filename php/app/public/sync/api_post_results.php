<?php
header("Content-Type: application/json");

// Nur POST erlauben
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Nur POST erlaubt"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['analysis_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "analysis_id fehlt"]);
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

    $stmt = $pdo->prepare("
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
            :analysis_id,
            :val,
            :val_lt,
            :val_min,
            :val_lt_min,
            :val_max,
            :val_lt_max,
            :valid_from,
            :valid_to,
            :stat,
            :comment,
            :num_values_expected,
            :num_values_live,
            :num_values_lt
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
    ");

    $stmt->execute([
        ":analysis_id" => $data["analysis_id"],
        ":val" => $data["val"],
        ":val_lt" => $data["val_lt"],
        ":val_min" => $data["val_min"],
        ":val_lt_min" => $data["val_lt_min"],
        ":val_max" => $data["val_max"],
        ":val_lt_max" => $data["val_lt_max"],
        ":valid_from" => $data["valid_from"],
        ":valid_to" => $data["valid_to"],
        ":stat" => $data["stat"],
        ":comment" => $data["comment"],
        ":num_values_expected" => $data["num_values_expected"],
        ":num_values_live" => $data["num_values_live"],
        ":num_values_lt" => $data["num_values_lt"]
    ]);

    echo json_encode([
        "success" => true,
        "analysis_id" => $data["analysis_id"]
    ]);

} catch (Exception $e) {

    http_response_code(500);
    echo json_encode([
        "error" => "Serverfehler",
        "message" => $e->getMessage()
    ]);
}