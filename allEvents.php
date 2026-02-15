<?php
    include "connect.php";

    $sql = "SELECT * FROM event WHERE status = 'approved' ORDER BY start_date ASC"; 
    $result = mysqli_query($dbConn, $sql);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Events - Breathe Green</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Story+Script&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
<link rel="icon" href="../imagessssss/LOGO.png" type="image/png" sizes="280x280">
<link rel="stylesheet" href="homepage.css">
<style>
    body {
    min-height: 900px;
    display: flex;
    flex-direction: column;
    }
    td {
            font-family: 'Tinos', serif;
    }
</style>
</head>
<body>
<?php include 'guestNavigation.php';?>

<section class="all-events-section">
    <div class="all-events-container">
        <h1 class="all-events-title">All Events</h1>
        <div class="event-filters">
            <select id="eventFilter" class="filter-select">
                <option value="all">All Events</option>
                <option value="upcoming">Upcoming Events</option>
                <option value="past">Past Events</option>
            </select>
        </div>
        <div class="events-container">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $startdate = date("d M, Y", strtotime($row['start_date']));
                $enddate = date("d M, Y", strtotime($row['end_date']));
                $startTime = date("ga", strtotime($row['start_time']));
                $endTime = date("ga", strtotime($row['end_time']));
                $today = new DateTime();

                $eventEndDate = new DateTime($row['end_date']);

                if ($eventEndDate < $today) {
                    $status = "Past";
                    $statusClass = "past";
                } else {
                    $status = "Upcoming";
                    $statusClass = "upcoming";
                }
                ?>
                <div class="event-box <?php echo $statusClass; ?>">
                    <div class="event-image">
                        <img src="img/<?php echo $row['image']; ?>">
                    </div>
                    
                    <div class="event-info">
                        <span>📅 <?php echo $startdate . " - " . $enddate; ?></span>
                        <span>🕐 <?php echo $startTime . " - " . $endTime; ?></span>
                        <span class="event-status <?php echo $statusClass; ?>">
                            <?php echo $status; ?>
                        </span>
                    </div>
                    
                    <div class="event-title">
                        <?php echo $row['event_name']; ?>
                    </div>
                    <div class="event-location">
                        📍 <?php echo $row['location']; ?>
                    </div>
                    <div class="event-details">
                        <strong>Type:</strong> <?php echo $row['event_type']; ?>
                    </div>
                    <div class="event-details">
                        <strong>Registration Deadline:</strong> <?php echo date("d M, Y", strtotime($row['registration_deadlines'])); ?>
                    </div>
                    <div class="event-details">
                        <strong>Points:</strong> <?php echo $row['earns_point']; ?> points
                    </div>
                    <div class="event-details">
                        <strong>Cost:</strong> RM <?php echo $row['event_cost']; ?>
                    </div>
                    <div class="event-details">
                        <strong>Categories:</strong> <?php echo $row['participant_categories']; ?>
                    </div>
                    <div class="event-details">
                        <strong>Description :</strong> <?php echo $row['description']; ?>
                    </div>
                    <br>
                    <?php if ($status === "Upcoming") { ?>
                        <button class="register-btn" onclick="alert('Please login first to register event.')">
                            Register
                        </button>
                    <?php } else { ?>
                        <button class="register-btn disabled" disabled>
                            Event Ended
                        </button>
                    <?php } ?>
                </div>
                <?php
            }
        } else {
            echo '<div class="no-events">No events coming</div>';
        }
        ?>
                            
        </div>
    </div>
</section>
<?php include 'guestFooter.php';?></body>
</html>
<?php
$dbConn->close();
?>