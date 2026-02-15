<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode([
        "success" => false, 
        "error" => "Connection failed: " . $conn->connect_error
    ]));
}

$sql = "SELECT 
    eventID,
    user_id,
    event_name,
    event_type,
    description,
    start_date,
    end_date,
    start_time,
    end_time,
    sustainability,
    maximum_participant,
    earns_point,
    registration_deadlines,
    participant_categories,
    image,
    event_cost,
    location,
    transportation_plan,
    collaborator_email,
    collaborator_category,
    organizer_name,
    organizer_email,
    organizer_contact_no,
    carbon_reduction,
    status,
    created_at,
    updated_at
FROM event 
ORDER BY start_date DESC";

$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['maximum_participant'] = (int)$row['maximum_participant'];
        $row['earns_point'] = (int)$row['earns_point'];
        $row['carbon_reduction'] = (int)$row['carbon_reduction'];
        $row['event_cost'] = (int)$row['event_cost'];
        
        $events[] = $row;
    }
    
    echo json_encode([
        "success" => true, 
        "events" => $events,
        "count" => count($events)
    ]);
} else {
    echo json_encode([
        "success" => true, 
        "events" => [],
        "count" => 0,
        "message" => "No events found"
    ]);
}

$conn->close();
?>