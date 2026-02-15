<?php
session_start();
include 'dbConn.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Existing stats queries
$total_events_sql = "SELECT COUNT(*) as total FROM event WHERE user_id = '$user_id'";
$total_events_result = mysqli_query($conn, $total_events_sql);
$total_events = mysqli_fetch_assoc($total_events_result)['total'];

$total_participants_sql = "SELECT COUNT(*) as total 
                           FROM registration r 
                           JOIN event e ON r.eventID = e.eventID 
                           WHERE e.user_id = '$user_id'";
$total_participants_result = mysqli_query($conn, $total_participants_sql);
$total_participants = mysqli_fetch_assoc($total_participants_result)['total'];

$total_attended_sql = "SELECT COUNT(*) as total 
                       FROM registration r 
                       JOIN event e ON r.eventID = e.eventID 
                       WHERE e.user_id = '$user_id' 
                       AND r.event_attendance = 'attended'";
$total_attended_result = mysqli_query($conn, $total_attended_sql);
$total_attended = mysqli_fetch_assoc($total_attended_result)['total'];

$approved_sql = "SELECT COUNT(*) as total 
                 FROM registration r 
                 JOIN event e ON r.eventID = e.eventID 
                 WHERE e.user_id = '$user_id' 
                 AND r.registration_status = 'approved'";
$approved_result = mysqli_query($conn, $approved_sql);
$total_approved = mysqli_fetch_assoc($approved_result)['total'];

$pending_sql = "SELECT COUNT(*) as total 
                FROM registration r 
                JOIN event e ON r.eventID = e.eventID 
                WHERE e.user_id = '$user_id' 
                AND r.registration_status = 'pending'";
$pending_result = mysqli_query($conn, $pending_sql);
$total_pending = mysqli_fetch_assoc($pending_result)['total'];

// NEW: Average attendance rate
$avg_attendance_sql = "SELECT 
    COALESCE(AVG(
        CASE 
            WHEN participant_count > 0 
            THEN (attended_count * 100.0 / participant_count) 
            ELSE 0 
        END
    ), 0) as avg_rate
    FROM (
        SELECT 
            e.eventID,
            COUNT(r.register_ID) as participant_count,
            SUM(CASE WHEN r.event_attendance = 'attended' THEN 1 ELSE 0 END) as attended_count
        FROM event e 
        LEFT JOIN registration r ON e.eventID = r.eventID 
        WHERE e.user_id = '$user_id'
        GROUP BY e.eventID
    ) as event_stats";
$avg_attendance_result = mysqli_query($conn, $avg_attendance_sql);
$avg_attendance_rate = mysqli_fetch_assoc($avg_attendance_result)['avg_rate'];

// Event details table
$events_sql = "SELECT e.event_name, e.start_date, e.location,
               COUNT(r.register_ID) as participant_count,
               SUM(CASE WHEN r.event_attendance = 'attended' THEN 1 ELSE 0 END) as attended_count
               FROM event e 
               LEFT JOIN registration r ON e.eventID = r.eventID 
               WHERE e.user_id = '$user_id' 
               GROUP BY e.eventID 
               ORDER BY e.start_date DESC";
$events_result = mysqli_query($conn, $events_sql);

// NEW: Top 5 most popular events (by registration count)
$popular_events_sql = "SELECT e.event_name, e.start_date, e.location,
                       COUNT(r.register_ID) as participant_count,
                       SUM(CASE WHEN r.event_attendance = 'attended' THEN 1 ELSE 0 END) as attended_count
                       FROM event e 
                       LEFT JOIN registration r ON e.eventID = r.eventID 
                       WHERE e.user_id = '$user_id' 
                       GROUP BY e.eventID 
                       HAVING participant_count > 0
                       ORDER BY participant_count DESC 
                       LIMIT 5";
$popular_events_result = mysqli_query($conn, $popular_events_sql);

// NEW: Recent registrations (last 7 days)
$recent_registrations_sql = "SELECT COUNT(*) as total 
                             FROM registration r 
                             JOIN event e ON r.eventID = e.eventID 
                             WHERE e.user_id = '$user_id' 
                             AND r.registration_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
$recent_registrations_result = mysqli_query($conn, $recent_registrations_sql);
$recent_registrations = mysqli_fetch_assoc($recent_registrations_result)['total'];

$upcoming_events_sql = "SELECT COUNT(*) as total 
                        FROM event 
                        WHERE user_id = '$user_id' 
                        AND start_date > CURDATE()";
$upcoming_events_result = mysqli_query($conn, $upcoming_events_sql);
$upcoming_events = mysqli_fetch_assoc($upcoming_events_result)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytic & Reports</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/test.png" type="images" />
    <style>
        body {
            background-color: #deedde;
            color: #0b5c31;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        h1 {
            color: #0b5c31;
            margin: 20px 0;
        }

        .back {
            display: inline-block;
            color: #2e7d33;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 48px;
            font-weight: bold;
            color: #2e7d32;
            margin: 10px 0;
        }

        .stat-label {
            font-size: 16px;
            color: #666;
            font-weight: 600;
        }

        .stat-icon {
            font-size: 36px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        th {
            background: #2e7d32;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #0b5c31;
            margin: 30px 0 15px 0;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #888;
            background: white;
            border-radius: 8px;
        }

        /* NEW: Popular events styling */
        .popular-card {
            background: linear-gradient(135deg, #66e3ea 0%, #4ba26f 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .popular-card h4 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .popular-card p {
            margin: 5px 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .popular-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 5px;
        }

        .rank-badge {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php include 'header.php';?>
    <div class="container">
        <a href="participant.php" class="back">← Back to Events</a>
        
        <h1>Analytics Dashboard</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-number"><?php echo $total_events; ?></div>
                <div class="stat-label">Total Events</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-number"><?php echo $total_participants; ?></div>
                <div class="stat-label">Total Registrations</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-number"><?php echo $total_approved; ?></div>
                <div class="stat-label">Approved</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <div class="stat-number"><?php echo $total_pending; ?></div>
                <div class="stat-label">Pending</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">✔️</div>
                <div class="stat-number"><?php echo $total_attended; ?></div>
                <div class="stat-label">Attended</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🔥</div>
                <div class="stat-number"><?php echo $recent_registrations; ?></div>
                <div class="stat-label">New This Week</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-number"><?php echo number_format($avg_attendance_rate, 1); ?>%</div>
                <div class="stat-label">Avg Attendance</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🚀</div>
                <div class="stat-number"><?php echo $upcoming_events; ?></div>
                <div class="stat-label">Upcoming Events</div>
            </div>
        </div>

        <div class="section-title">🏆 Most Popular Events</div>
        <?php if(mysqli_num_rows($popular_events_result) > 0) { 
            $rank = 1;
            while($popular = mysqli_fetch_assoc($popular_events_result)) { 
                $attendance_rate = 0;
                if($popular['participant_count'] > 0) {
                    $attendance_rate = ($popular['attended_count'] / $popular['participant_count']) * 100;
                }
        ?>
            <div class="popular-card">
                <span class="rank-badge">#<?php echo $rank++; ?></span>
                <h4><?php echo htmlspecialchars($popular['event_name']); ?></h4>
                <p>📍 <?php echo htmlspecialchars($popular['location']); ?> | 📅 <?php echo date('M d, Y', strtotime($popular['start_date'])); ?></p>
                <span class="popular-badge">👥 <?php echo $popular['participant_count']; ?> Registrations</span>
                <span class="popular-badge">✅ <?php echo $popular['attended_count']; ?> Attended</span>
                <span class="popular-badge">📊 <?php echo number_format($attendance_rate, 1); ?>% Rate</span>
            </div>
        <?php } 
        } else { ?>
            <div class="no-data">
                <p>No events with registrations yet.</p>
            </div>
        <?php } ?>

        <div class="section-title">Event Details</div>

        <?php if(mysqli_num_rows($events_result) > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Registrations</th>
                    <th>Attended</th>
                    <th>Attendance Rate</th>
                </tr>
            </thead>
            <tbody>
                <?php while($event = mysqli_fetch_assoc($events_result)) { 
                    $attendance_rate = 0;
                    if($event['participant_count'] > 0) {
                        $attendance_rate = ($event['attended_count'] / $event['participant_count']) * 100;
                    }
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($event['start_date'])); ?></td>
                    <td><?php echo htmlspecialchars($event['location']); ?></td>
                    <td><?php echo $event['participant_count']; ?></td>
                    <td><?php echo $event['attended_count']; ?></td>
                    <td><?php echo number_format($attendance_rate, 1); ?>%</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
            <div class="no-data">
                <p>No events found. Create your first event to see analytics!</p>
            </div>
        <?php } ?>
    </div>

 <?php include 'footer.php'; ?>   
</body>
</html>