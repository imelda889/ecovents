<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$host = "localhost";
$dbname = "users";        
$username = "root";
$password = "";

$roleFilter = isset($_GET['role']) && $_GET['role'] !== ''
    ? $_GET['role']
    : null;

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    if ($roleFilter && $roleFilter !== 'All') {
        $sql = "
            SELECT 
                user_id,
                password,
                name,
                email,
                role,
                google_id,
                profile_image,
                event_id,
                event_name
            FROM organizer_user
            WHERE role = ?
            ORDER BY user_id ASC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$roleFilter]);
    } else {
        $sql = "
            SELECT 
                user_id,
                password,
                name,
                email,
                role,
                google_id,
                profile_image,
                event_id,
                event_name
            FROM organizer_user
            ORDER BY role ASC, user_id ASC
        ";
        $stmt = $pdo->query($sql);
    }

    $users = $stmt->fetchAll();

    echo json_encode([
        "success" => true,
        "count" => count($users),
        "users" => $users
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>