<?php
session_start();
include 'dbConn.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$month = isset($_POST['month']) ? $_POST['month'] : date('m');
$year = isset($_POST['year']) ? $_POST['year'] : date('Y');

$events_sql = "SELECT eventID, event_name, start_date, end_date, location 
               FROM event 
               WHERE user_id = '$user_id' 
               AND ((MONTH(start_date) = '$month' AND YEAR(start_date) = '$year') 
                    OR (MONTH(end_date) = '$month' AND YEAR(end_date) = '$year'))
               ORDER BY start_date";
$events_result = mysqli_query($conn, $events_sql);

$events_by_date = array();
while($event = mysqli_fetch_assoc($events_result)) {
    $start = new DateTime($event['start_date']);
    $end = new DateTime($event['end_date']);
    $end->modify('+1 day'); 
    
    $period = new DatePeriod($start, new DateInterval('P1D'), $end);
    
    foreach($period as $date) {
        $date_key = $date->format('Y-m-d');
        if(!isset($events_by_date[$date_key])) {
            $events_by_date[$date_key] = array();
        }
        $events_by_date[$date_key][] = $event;
    }
}

$first_day = mktime(0, 0, 0, $month, 1, $year);
$days_in_month = date('t', $first_day);
$day_of_week = date('w', $first_day);
$month_name = date('F Y', $first_day);

$prev_month = $month - 1;
$prev_year = $year;
if($prev_month < 1) {
    $prev_month = 12;
    $prev_year--;
}

$next_month = $month + 1;
$next_year = $year;
if($next_month > 12) {
    $next_month = 1;
    $next_year++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Calendar</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/test.png" type="images" />
    <style>
        body {
            background-color: #deedde;
            color: #0b5c31;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .back {
            display: inline-block;
            color: #2e7d33;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .calendar-header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .calendar-header h2 {
            margin: 0;
            color: #0b5c31;
        }

        .nav-links form{
            display: inline-block;
            margin: 0 5px;
        }
        .nav-links button {
            padding: 8px 16px;
            background: #2e7d32;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 0 5px;
            border: none;
            cursor: pointer;
        }

        .nav-links button:hover {
            background: #1b5e20;
        }

        .calendar {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #2e7d32;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: 600;
        }

        td {
            padding: 10px;
            vertical-align: top;
            border: 1px solid #ddd;
            height: 100px;
            position: relative;
        }

        .day-number {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .today {
            background: #e8f5e9;
        }

        .other-month {
            background: #f5f5f5;
            color: #999;
        }

        .event-dot {
            background: #2e7d32;
            color: white;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 11px;
            display: block;
            margin: 2px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .event-dot:hover {
            background: #1b5e20;
            overflow: visible;
            white-space: normal;
            z-index: 10;
            position: relative;
        }

    @media screen and (max-width: 768px) {
    .container {
        padding: 0 10px;
        margin: 10px auto;
    }
    
    .back {
        font-size: 14px;
        margin-bottom: 15px;
        display: block;
    }
    
    .calendar-header {
        flex-direction: column;
        padding: 15px;
        gap: 10px;
    }
    
    .calendar-header h2 {
        font-size: 18px;
        order: -1;
    }
    
    .nav-links {
        display: flex;
        width: 100%;
        justify-content: space-between;
    }
    
    .nav-links form{
        flex: 1;
        margin: 0 5px;
    }

    .nav-links button {
        padding: 8px 12px;
        font-size: 14px;
        flex: 1;
        text-align: center;
        margin: 0 5px;
        border: none;
        cursor: pointer;
    }
    
    .calendar {
        overflow-x: auto;
    }
    
    table {
        min-width: 100%;
    }
    
    th {
        padding: 8px 4px;
        font-size: 12px;
    }
    
    td {
        padding: 5px;
        height: 80px;
        font-size: 12px;
    }
    
    .day-number {
        font-size: 13px;
        margin-bottom: 3px;
    }
    
    .event-dot {
        font-size: 9px;
        padding: 2px 4px;
        margin: 1px 0;
    }
}

@media screen and (max-width: 480px) {
    h1 {
        font-size: 20px;
    }
    
    h2 {
        font-size: 18px;
    }
    
    .event-card {
        padding: 12px;
    }
    
    .event-image {
        height: 150px;
    }
    
    .event-details h3 {
        font-size: 16px;
    }
    
    .calendar-header h2 {
        font-size: 16px;
    }
    
    th {
        padding: 6px 2px;
        font-size: 11px;
    }
    
    td {
        padding: 3px;
        height: 70px;
    }
    
    .day-number {
        font-size: 12px;
    }
    
    .event-dot {
        font-size: 8px;
        padding: 2px 3px;
    }
}

@media screen and (max-width: 768px) and (orientation: landscape) {
    td {
        height: 60px;
    }
    
    .event-dot {
        font-size: 10px;
    }
}
    </style>
</head>
<body>
    <?php include 'header.php';?>
    
    <div class="container">
        <a href="participant.php" class="back">← Back to Events</a>
        
        <div class="calendar-header">
            <div class="nav-links">
                <form method="post" action="event_calendar.php">
                    <input type="hidden" name="month" value="<?php echo $prev_month; ?>">
                    <input type="hidden" name="year" value="<?php echo $prev_year; ?>">
                    <button type="submit">← Previous</button>
                </form>
            </div>
            <h2>📅 <?php echo $month_name; ?></h2>
            <div class="nav-links">
                <form method="post" action="event_calendar.php">
                    <input type="hidden" name="month" value="<?php echo $next_month; ?>">
                    <input type="hidden" name="year" value="<?php echo $next_year; ?>">
                    <button type="submit">Next →</button>
                </form>
            </div>
        </div>

        <div class="calendar">
            <table>
                <thead>
                    <tr>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php
                    for($i = 0; $i < $day_of_week; $i++) {
                        echo '<td class="other-month"></td>';
                    }
                    
                    for($day = 1; $day <= $days_in_month; $day++) {
                        $current_date = sprintf('%04d-%02d-%02d', $year, $month, $day);
                        $is_today = ($current_date == date('Y-m-d')) ? 'today' : '';
                        
                        echo '<td class="' . $is_today . '">';
                        echo '<div class="day-number">' . $day . '</div>';
                        
                        if(isset($events_by_date[$current_date])) {
                            foreach($events_by_date[$current_date] as $event) {
                                echo '<div class="event-dot" title="' . htmlspecialchars($event['event_name']) . ' - ' . htmlspecialchars($event['location']) . '">';
                                echo htmlspecialchars(substr($event['event_name'], 0, 15));
                                echo '</div>';
                            }
                        }
                        
                        echo '</td>';
                        
                        if(($day + $day_of_week) % 7 == 0 && $day != $days_in_month) {
                            echo '</tr><tr>';
                        }
                    }
                    
                    $remaining = (7 - (($days_in_month + $day_of_week) % 7)) % 7;
                    for($i = 0; $i < $remaining; $i++) {
                        echo '<td class="other-month"></td>';
                    }
                    ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html>