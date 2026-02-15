<?php
require_once 'config.php';

header('Content-Type: application/json');

$conn = getDBConnection();
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'fetch':
        fetchNews($conn);
        break;
    
    case 'add':
        addNews($conn);
        break;
    
    case 'update':
        updateNews($conn);
        break;
    
    case 'delete':
        deleteNews($conn);
        break;
    
    case 'search':
        searchNews($conn);
        break;
    
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

$conn->close();

function fetchNews($conn) {
    $type = $_GET['type'] ?? '';
    $search = $_GET['search'] ?? '';
    
    $sql = "SELECT newsID, news_title, news_content, news_type, news_link, news_created_at 
            FROM news WHERE 1=1";
    
    if ($type) {
        $sql .= " AND news_type = '" . $conn->real_escape_string($type) . "'";
    }
    
    if ($search) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (news_title LIKE '%$search%' OR news_content LIKE '%$search%')";
    }
    
    $sql .= " ORDER BY news_created_at DESC";
    
    $result = $conn->query($sql);
    $data = [];
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    echo json_encode(['success' => true, 'data' => $data]);
}

function addNews($conn) {
    $userId = getCurrentUserId();
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $type = $_POST['type'] ?? '';
    $link = $_POST['link'] ?? '';
    
    if (empty($title) || empty($content) || empty($type)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        return;
    }
    
    $stmt = $conn->prepare("INSERT INTO news (user_id, news_title, news_content, news_type, news_link) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $userId, $title, $content, $type, $link);
    
    if ($stmt->execute()) {
        $newId = $conn->insert_id;
        echo json_encode([
            'success' => true, 
            'message' => ucfirst($type) . ' added successfully',
            'id' => $newId,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add ' . $type]);
    }
    
    $stmt->close();
}

function updateNews($conn) {
    $id = $_POST['id'] ?? 0;
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $link = $_POST['link'] ?? '';
    
    if (empty($id) || empty($title) || empty($content)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        return;
    }
    
    $stmt = $conn->prepare("UPDATE news SET news_title = ?, news_content = ?, news_link = ? WHERE newsID = ?");
    $stmt->bind_param("sssi", $title, $content, $link, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update']);
    }
    
    $stmt->close();
}

function deleteNews($conn) {
    $id = $_POST['id'] ?? 0;
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        return;
    }
    
    $stmt = $conn->prepare("DELETE FROM news WHERE newsID = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete']);
    }
    
    $stmt->close();
}

function searchNews($conn) {
    fetchNews($conn);
}
?>