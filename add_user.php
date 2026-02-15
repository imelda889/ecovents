<?php
session_start();
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'users';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        echo json_encode(['success' => false, 'error' => 'All fields are required']);
        exit();
    }
    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM organizer_user WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'error' => 'Email already exists']);
        exit();
    }
    
    try {
        $stmt = $pdo->query("SELECT MAX(user_id) as max_id FROM organizer_user");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $next_id = ($result['max_id'] ?? 0) + 1;
        
        $acc_status = ($role === 'Admin') ? '' : 'Approved';
        $points = 0;
        
        $stmt = $pdo->prepare("INSERT INTO organizer_user (user_id, name, email, password, role, google_id, profile_image, event_id, event_name, acc_status, points) VALUES (?, ?, ?, ?, ?, NULL, NULL, NULL, NULL, ?, ?)");
        
        $stmt->execute([
            $next_id,
            $name,
            $email,
            $password,
            $role,
            $acc_status,
            $points
        ]);
        
        echo json_encode([
            'success' => true,
            'message' => 'User added successfully',
            'user_id' => $next_id
        ]);
        
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Failed to add user: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>