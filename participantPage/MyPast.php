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
        $points = $user['points'];
    } else {
        $name = "User";
        $profile_image = "";
        $display_id = "";
        $points = 0;
    }

    $sql = "SELECT e.eventID, e.event_name, e.event_type, 
                e.start_date, e.end_date,
                e.start_time, e.end_time,
                e.location, e.image,
                r.feedback
            FROM registration r
            JOIN event e ON r.eventID = e.eventID
            WHERE r.user_id = $user_id
            AND r.event_attendance = 'attended'
            ORDER BY e.end_date DESC";

    $pastResult = mysqli_query($dbConn, $sql);
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
</head>

<body>

<?php include 'particNavigation.php';?>

<section class="past-events-section">
    <div class="past-events-container">
        <h1 class="past-events-title">My Past Events</h1>
        <div class="past-filters">
            <select id="pastFilter" class="filter-select">
                <option value="all">All</option>
                <option value="latest">Latest</option>
                <option value="oldest">Oldest</option>
            </select>
        </div>
        <div class="event-container">
        <?php
        if (mysqli_num_rows($pastResult) > 0){
            while($row = mysqli_fetch_assoc($pastResult)){
                $startdate = date("d M, Y", strtotime($row['start_date']));
                $enddate = date("d M, Y", strtotime($row['end_date']));
                $startTime = date("ga", strtotime($row['start_time']));
                $endTime = date("ga", strtotime($row['end_time']));
                ?>
                <div class="event-card" data-date="<?php echo $row['start_date'];?>">
                    <div class="event-image">
                        <div class="event-categories">
                            <?php echo $row['event_type']; ?>
                        </div>
                        <img src="../guestPage/img/<?php echo $row['image']?>" alt="Event Image">
                    </div>
                    <div class="event-infos">
                        <span>📅 <?php echo $startdate . " - " . $enddate; ?></span>
                        <span>🕐 <?php echo $startTime . " - " . $endTime; ?></span>
                    </div>

                    <div class="event-title">
                        <?php echo $row['event_name']; ?>
                    </div>

                    <div class="location">
                        📍 <?php echo $row['location']; ?>
                    </div>
                    <br>

                    <?php if ($row['feedback'] == "" || $row['feedback'] == NULL) { ?>
                        <button class="feedback-btn"
                                onclick="openFeedback(<?php echo $row['eventID']; ?>)">
                            Write Feedback
                        </button>
                    <?php } else { ?>
                        <button class="feedback-btn"
                                style="background: #999; cursor: not-allowed;"
                                disabled>
                            Done Feedback
                        </button>
                    <?php } ?>

                </div>
                <?php
            }
        } else {
            echo "<p>No past events found.</p>";
        }
        ?>
        </div>
    </div>

    <div id="feedbackBox" style="display:none;
     position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,0,0,0.5);">

    <div style="background:white; width:320px;
         margin:150px auto; padding:20px; border-radius:10px;">

        <form method="post" action="submitFeedback.php">
            <input type="hidden" name="event_id" id="event_id">

            <label>Feedback</label><br>
            <textarea name="feedback" required="required"
                      style="width:100%; height:80px;"></textarea><br><br>

            <button type="submit">Submit</button>
            <button type="button" onclick="closeFeedback()">Cancel</button>
        </form>

    </div>
</div>
</section>
<?php include 'particFooter.php';?>
</body>
</html>
