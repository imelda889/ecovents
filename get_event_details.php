<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'users';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed']);
    exit;
}

$conn->set_charset("utf8mb4");

$eventID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($eventID <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid event ID']);
    exit;
}

$sql = "SELECT * FROM event WHERE eventID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eventID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'event' => $event
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'Event not found']);
}

$stmt->close();
$conn->close();
?>