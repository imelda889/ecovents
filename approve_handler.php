<?php
while (ob_get_level()) {
    ob_end_clean();
}

ob_start();

$host = 'localhost';
$dbname = 'users';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed']);
    exit;
}

$action = isset($_POST['action']) ? $_POST['action'] : '';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$type = isset($_POST['type']) ? $_POST['type'] : '';

if ($type !== 'event' || $id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
    exit;
}

$stmt = $conn->prepare("SELECT event_name FROM event WHERE eventID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
$stmt->close();

if (!$event) {
    echo json_encode(['success' => false, 'error' => 'Event not found']);
    exit;
}

$status = ($action === 'approve') ? 'approved' : 'rejected';
$stmt = $conn->prepare("UPDATE event SET status = ? WHERE eventID = ?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'eventName' => $event['event_name']
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'Update failed']);
}

$stmt->close();
$conn->close();
exit;
?>