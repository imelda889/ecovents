<?php
session_start();
 
include 'dbConn.php';
 
$user_id = $_SESSION['user_id'];
 
if(isset($_POST['delete'])) {
    $eventID = mysqli_real_escape_string($conn, $_POST['delete']);
    $delete_sql = "DELETE FROM event WHERE eventID = '$eventID' AND user_id = '$user_id'";
   
    if(mysqli_query($conn, $delete_sql)) {
        echo "<script>alert('Event deleted successfully!'); window.location.href='participant.php';</script>";
    } else {
        echo "<script>alert('Error deleting event');</script>";
    }
}
 
$sql = "SELECT * FROM event WHERE user_id = '$user_id'";
 
if(isset($_POST['btnSearch']) && !empty($_POST['txtSearch'])){
    $search = mysqli_real_escape_string($conn, $_POST['txtSearch']);
    $sql .= " AND event_name LIKE '%$search%'";
}
 
if(isset($_POST['btnFilter']) && !empty($_POST['filter'])){
    $filter = $_POST['filter'];
    $today = date('Y-m-d');
   
    if($filter == 'now'){
        $sql .= " AND '$today' BETWEEN start_date AND end_date";
    } elseif($filter == 'upcoming'){
        $sql .= " AND start_date > '$today'";
    } elseif($filter == 'previous'){
        $sql .= " AND end_date < '$today'";
    }
}
 
$sql .= " ORDER BY start_date ASC";
 
$result = mysqli_query($conn, $sql);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/test.png" type="images" />
    <style>
        body {
            background-color: #deedde;
            color: #0b5c31;
        }
 
        h2 {
            font-size: 25px;
            margin-bottom: 10px;
            padding: 0 20px;
        }
       
        p {
            margin-left: 20px;
            color: #555;
        }
       
        h1 {
            font-size: 36px;
            margin-top: 40px;
            padding: 0 20px;
        }
       
        h3 {
            margin-left: 20px;
            color: #666;
        }
 
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px;
        }
 
        .create-btn {
            background: #2e7d32;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            cursor: pointer;
        }
 
        .create-btn:hover {
            background: #1b5e20;
        }
 
        .search-filter-section {
            max-width: 900px;
            margin: 0 auto 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
 
        .search-filter-section form {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }
 
        .search-filter-section input[type="text"],
        .search-filter-section select {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
 
        .search-filter-section input[type="submit"] {
            padding: 8px 16px;
            background: #2e7d32;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
 
        .search-filter-section input[type="submit"]:hover {
            background: #1b5e20;
        }
 
        .events-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
 
        .event-card {
            background: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
        }
 
        .event-image-container {
            position: relative;
            width: 150px;
            height: 100px;
        }
 
        .event-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 6px;
        }
 
        .status-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
 
        .status-pending {
            background: #ff9800;
            color: white;
        }
 
        .status-approved {
            background: #4caf50;
            color: white;
        }
 
        .event-details {
            flex: 1;
        }
 
        .event-details h3 {
            margin: 0 0 10px 0;
            font-size: 20px;
            color: #0b5c31;
        }
 
        .event-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
 
        .event-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            justify-content: center;
        }
 
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }
 
        .btn-manage {
            background: #1976d2;
            color: white;
        }
 
        .btn-manage:hover {
            background: #1565c0;
        }
 
        .btn-edit {
            background: #ff9800;
            color: white;
        }
 
        .btn-edit:hover {
            background: #f57c00;
        }
 
        .btn-delete {
            background: #d32f2f;
            color: white;
        }
 
        .btn-delete:hover {
            background: #c62828;
        }
 
        .btn:disabled {
            background: #cccccc;
            cursor: not-allowed;
            opacity: 0.6;
        }
 
        .btn:disabled:hover {
            background: #cccccc;
        }
 
        .no-events {
            text-align: center;
            padding: 40px;
            color: #888;
        }
 
 
 
@media screen and (max-width: 768px) {
    h1 {
        font-size: 24px;
        margin-top: 20px;
        padding: 0 15px;
    }
   
    h2 {
        font-size: 20px;
        padding: 0 15px;
    }
   
    h3 {
        font-size: 16px;
        margin-left: 15px;
    }
   
    p {
        margin-left: 15px;
        font-size: 14px;
    }
   
    .header-section {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
        margin: 15px;
    }
   
    .header-section > div {
        width: 100%;
    }
   
    .create-btn {        
        text-align: center;
        padding: 14px 20px;
        font-size: 16px;
    }
   
    .search-filter-section {
        margin: 15px;
        padding: 15px;
    }
   
    .search-filter-section form {
        flex-direction: column;
        width: 100%;
        gap: 8px;
    }
   
    .search-filter-section input[type="text"],
    .search-filter-section select {
        width: 100%;
        padding: 12px;
        font-size: 15px;
        box-sizing: border-box;
    }
   
    .search-filter-section input[type="submit"] {
        width: 100%;
        padding: 12px;
        font-size: 15px;
        font-weight: 600;
    }
   
    .events-container {
        padding: 0 15px 15px 15px;
    }
   
    .event-card {
        flex-direction: column;
        padding: 0;
        gap: 0;
        overflow: hidden;
    }
   
    .event-image-container {
        width: 100%;
        height: 200px;
    }
 
    .event-image {
        border-radius: 0;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
   
    .event-details {
        width: 100%;
        padding: 15px;
    }
   
    .event-details h3 {
        font-size: 18px;
        margin: 0 0 10px 0;
    }
   
    .event-details p {
        font-size: 14px;
        margin: 6px 0;
    }
   
    .event-actions {
        width: 100%;
        padding: 0 15px 15px 15px;
        gap: 8px;
    }
   
    .btn {
        width: 100%;
        padding: 12px 16px;
        font-size: 15px;
        font-weight: 600;
    }
   
    .no-events {
        padding: 30px 15px;
    }
}
 
@media screen and (max-width: 480px) {
    h1 {
        font-size: 22px;
        margin-top: 15px;
    }
   
    h2 {
        font-size: 18px;
    }
   
    .event-image-container {
        height: 180px;
    }
   
    .event-details {
        padding: 12px;
    }
   
    .event-details h3 {
        font-size: 17px;
    }
   
    .event-details p {
        font-size: 13px;
    }
   
    .event-actions {
        padding: 0 12px 12px 12px;
    }
   
    .btn {
        padding: 11px 14px;
        font-size: 14px;
    }
}
 
@media screen and (max-width: 768px) and (orientation: landscape) {
    .event-image-container {
        height: 150px;
    }
   
    .event-card {
        margin-bottom: 15px;
    }
}
    </style>
</head>
<body>
    <?php include 'header.php';?>
   
    <h2>Participant Management</h2>
    <p>Select an event in "My Events" to manage specific participants.</p>
 
    <div class="header-section">
        <div>
            <h1>My Events</h1>
            <h3>Manage your upcoming and past events.</h3>
        </div>
        <a href="customize_template.php" class="create-btn">+ Create New Event</a>
    </div>
 
    <div class="search-filter-section">
        <form action="#" method="post">
            <input type="text" name="txtSearch" placeholder="Search event name..." value="<?= isset($_POST['txtSearch']) ? htmlspecialchars($_POST['txtSearch']) : '' ?>">
            <input type="submit" value="Search" name="btnSearch">
        </form>
       
        <form action="#" method="post" style="margin-top: 10px;">
            <select name="filter">
                <option value="">All Events</option>
                <option value="now" <?= (isset($_POST['filter']) && $_POST['filter'] == 'now') ? 'selected' : '' ?>>Now</option>
                <option value="upcoming" <?= (isset($_POST['filter']) && $_POST['filter'] == 'upcoming') ? 'selected' : '' ?>>Upcoming</option>
                <option value="previous" <?= (isset($_POST['filter']) && $_POST['filter'] == 'previous') ? 'selected' : '' ?>>Previous</option>
            </select>
            <input type="submit" value="Filter" name="btnFilter">
        </form>
    </div>
 
    <div class="events-container">
        <?php
        if(mysqli_num_rows($result) > 0) {
            while($event = mysqli_fetch_assoc($result)) {
                $isPending = (isset($event['status']) && strtolower($event['status']) == 'pending');
                $isApproved = (isset($event['status']) && strtolower($event['status']) == 'approved');
        ?>
            <div class="event-card">
                <div class="event-image-container">
                    <img src="img/<?= htmlspecialchars($event['image']) ?>" class="event-image" alt="Event Image">
                    <?php if($isPending): ?>
                        <span class="status-badge status-pending">Pending</span>
                    <?php elseif($isApproved): ?>
                        <span class="status-badge status-approved">Approved</span>
                    <?php endif; ?>
                </div>
 
                <div class="event-details">
                    <h3><?= htmlspecialchars($event['event_name']) ?></h3>
                    <p>📅 <?= date('M d, Y', strtotime($event['start_date'])) ?> - <?= date('M d, Y', strtotime($event['end_date'])) ?></p>
                    <p>⏰ <?= date('g:i A', strtotime($event['start_time'])) ?></p>
                    <p>📍 <?= htmlspecialchars($event['location']) ?></p>
                </div>
 
                <div class="event-actions">
                    <form action="participantManage.php" method="POST">
                        <input type="hidden" name="eventID" value="<?= $event['eventID'] ?>">
                        <button type="submit" class="btn btn-manage" <?= $isPending ? 'disabled' : '' ?>>Manage Participants</button>
                    </form>
                    <form action="record.php" method="POST">
                        <input type="hidden" name="eventID" value="<?= $event['eventID'] ?>">
                        <button type="submit" class="btn btn-manage" <?= $isPending ? 'disabled' : '' ?>>View Report</button>
                    </form>
                    <form action="edit_event.php" method="POST">
                        <input type="hidden" name="id" value="<?= $event['eventID'] ?>">
                        <button type="submit" class="btn btn-edit" <?= $isPending ? 'disabled' : '' ?>>Edit Event</button>
                    </form>
                    <form action="participant.php" method="POST">
                        <input type="hidden" name="delete" value="<?= $event['eventID'] ?>">
                        <button type="submit" class="btn btn-delete" <?= $isPending ? 'disabled' : '' ?> onclick="return confirm('Are you sure you want to delete this event?')">Delete Event</button>
                    </form>
                </div>
            </div>
        <?php
            }
        } else {
            echo "<div class='no-events'><p>No events found. Create your first event!</p></div>";
        }
        ?>
    </div>
<?php include 'footer.php'; ?>
</body>
</html>