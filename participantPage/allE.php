<?php
    include "../guestPage/connect.php";
    include "../guestPage/check.php";

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM organizer_user WHERE user_id = $user_id";
    $userResult = mysqli_query($dbConn, $sql);

    if(mysqli_num_rows($userResult) > 0){
        $user = mysqli_fetch_assoc($userResult);
        $name = $user['name'];
        $profile_image = $user['profile_image'];
        $display_id = $_SESSION['display_id'];
    } else {
        $name = "User";
        $profile_image = "";
        $display_id = "";
    }

    $sql = "SELECT eventID, event_name, event_type, description, start_date, end_date, start_time, end_time, earns_point, registration_deadlines, participant_categories, image, event_cost, location, status FROM event WHERE status = 'approved' ORDER BY start_date ASC"; 
    $eventResult = mysqli_query($dbConn, $sql);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Events - EcoVents</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
<link rel="icon" href="../imagessssss/LOGO.png" type="image/png">
<link rel="stylesheet" href="homep.css">
<style>
    td {
        font-family: 'Tinos', serif;
    }
</style>
</head>
<body>

<?php include 'particNavigation.php';?>

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
        <div class="events-containers">
        <?php
        if (mysqli_num_rows($eventResult) > 0) {
            while($row = mysqli_fetch_assoc($eventResult)) {
                $startdate = date("d M, Y", strtotime($row['start_date']));
                $enddate = date("d M, Y", strtotime($row['end_date']));
                $startTime = date("ga", strtotime($row['start_time']));
                $endTime = date("ga", strtotime($row['end_time']));

                $eventEndDate = new DateTime($row['end_date']);
                $todayDate = new DateTime(date("Y-m-d"));
                $isPast = $eventEndDate < $todayDate;

                $eventID = $row['eventID'];
                $checkSql = "SELECT * FROM registration WHERE user_id = $user_id AND eventID = $eventID";
                $checkResult = mysqli_query($dbConn, $checkSql);
                $isRegistered = mysqli_num_rows($checkResult) > 0;
        ?>
                <div class="event-box 
                <?php
                    if ($isPast) {
                        echo 'past';
                    } else {
                        echo 'upcoming';
                    }
                ?>">
                    <div class="event-image">
                        <img src="../guestPage/img/<?php echo $row['image']; ?>">
                    </div>
                    <div class="event-info">
                        <span>📅 <?php echo $startdate . " - " . $enddate; ?></span>
                        <span>🕐 <?php echo $startTime . " - " . $endTime; ?></span>
                        <span class="event-stat 
                            <?php
                                if ($isPast) {
                                    echo 'past';
                                } else {
                                    echo 'upcoming';
                                }
                            ?>">
                            <?php
                                if ($isPast) {
                                    echo 'Past';
                                } else {
                                    echo 'Upcoming';
                                }
                            ?>
                        </span>

                    </div>
                    <div class="event-title"><?php echo $row['event_name']; ?></div>
                    <div class="event-location">📍 <?php echo $row['location']; ?></div>
                    <div class="event-detail"><strong>Type:</strong> <?php echo $row['event_type']; ?></div>
                    <div class="event-detail"><strong>Registration Deadline:</strong> <?php echo date("d M, Y", strtotime($row['registration_deadlines'])); ?></div>
                    <div class="event-detail"><strong>Points:</strong> <?php echo $row['earns_point']; ?> points</div>
                    <div class="event-detail"><strong>Cost:</strong> RM <?php echo $row['event_cost']; ?></div>
                    <div class="event-detail"><strong>Categories:</strong> <?php echo $row['participant_categories']; ?></div>
                    <div class="event-detail"><strong>Description :</strong> <?php echo $row['description']; ?></div>
                    <br>

                    <?php if ($isPast) { ?>
                        <button class="register-btn disabled" disabled>Event Ended</button>
                    <?php } elseif ($isRegistered) { ?>
                        <button class="register-btn registered" disabled>Registered</button>
                    <?php } else { ?>
                        <form action="register_event.php" method="POST">
                            <input type="hidden" name="event_id" value="<?php echo $row['eventID']; ?>">
                            <button type="submit" class="register-btn">Register</button>
                        </form>
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
<?php include 'particFooter.php';?>
</body>
</html>
