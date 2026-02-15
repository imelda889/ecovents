<?php
session_start();
include 'dbConn.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(!isset($_POST['eventID'])) {
    echo "<script>alert('No event ID provided!');</script>";
    die("<script>window.location.href='participant.php';</script>");
}

$eventID = mysqli_real_escape_string($conn, $_POST['eventID']);

$event_sql = "SELECT * FROM event WHERE eventID = '$eventID' AND user_id = '$user_id'";
$event_result = mysqli_query($conn, $event_sql);
$event = mysqli_fetch_assoc($event_result);

if(!$event) {
    echo "<script>alert('Event not found!');</script>";
    die("<script>window.location.href='participant.php';</script>");
}

$total_registered = mysqli_fetch_assoc(mysqli_query($conn, 
    "SELECT COUNT(*) as total FROM registration WHERE eventID = '$eventID'"))['total'];

$total_approved = mysqli_fetch_assoc(mysqli_query($conn, 
    "SELECT COUNT(*) as total FROM registration WHERE eventID = '$eventID' AND registration_status = 'approved'"))['total'];

$total_attended = mysqli_fetch_assoc(mysqli_query($conn, 
    "SELECT COUNT(*) as total FROM registration WHERE eventID = '$eventID' AND event_attendance = 'attended'"))['total'];

$participants_sql = "SELECT r.*, u.name, u.email 
                     FROM registration r 
                     JOIN organizer_user u ON r.user_id = u.user_id 
                     WHERE r.eventID = '$eventID' 
                     ORDER BY u.name ASC";
$participants_result = mysqli_query($conn, $participants_sql);

$total_points = $total_attended * $event['earns_point'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Report</title>
    <link rel="icon" href="img/test.png" type="images" />
    <style>
        body {
            background-color: #deedde;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #0b5c31;
            margin-bottom: 10px;
        }

        h2 {
            color: #0b5c31;
            font-size: 20px;
            margin-top: 30px;
            margin-bottom: 15px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        th {
            background: #2e7d32;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .info-table td {
            border: 1px solid #ddd;
        }

        .info-table td:first-child {
            font-weight: bold;
            width: 200px;
            background: #f5f5f5;
        }

        .stats {
            display: flex;
            gap: 15px;
            margin: 20px 0;
        }

        .stat-box {
            flex: 1;
            background: #f5f5f5;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
        }

        .stat-box .number {
            font-size: 32px;
            font-weight: bold;
            color: #2e7d32;
        }

        .stat-box .label {
            font-size: 14px;
            color: #666;
        }

        .actions {
            text-align: center;
            margin-top: 30px;
        }

        .btn {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-print {
            background: #2e7d32;
            color: white;
        }

        .btn-back {
            background: #888;
            color: white;
        }

        @media print {
            .actions {
                display: none;
            }
            body {
                background: white;
            }
        }

        @media screen and (max-width: 768px) {
        body {
            padding: 10px;
        }
        
        .container {
            padding: 20px 15px;
        }
        
        h1 {
            font-size: 22px;
        }
        
        h2 {
            font-size: 18px;
            margin-top: 25px;
            margin-bottom: 12px;
        }
        
        .info-table {
            font-size: 13px;
        }
        
        .info-table td:first-child {
            width: 120px;
            font-size: 12px;
            padding: 8px;
        }
        
        .info-table td:last-child {
            padding: 8px;
            font-size: 13px;
        }
        
        .stats {
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .stat-box {
            flex: 1 1 calc(50% - 10px);
            padding: 12px 10px;
        }
        
        .stat-box .number {
            font-size: 24px;
        }
        
        .stat-box .label {
            font-size: 12px;
        }
        
        table {
            font-size: 12px;
        }
        
        th {
            padding: 8px 6px;
            font-size: 12px;
        }
        
        td {
            padding: 8px 6px;
            font-size: 12px;
        }
        
        .btn {
            padding: 12px 20px;
            font-size: 14px;
        }
    }

    @media screen and (max-width: 480px) {
        body {
            padding: 8px;
        }
        
        .container {
            padding: 15px 12px;
        }
        
        h1 {
            font-size: 20px;
        }
        
        h2 {
            font-size: 16px;
        }
        
        .info-table td:first-child {
            width: 100%;
            display: block;
            border-bottom: none;
            padding-bottom: 4px;
            background: #f0f0f0;
            font-size: 11px;
        }
        
        .info-table td:last-child {
            width: 100%;
            display: block;
            padding-top: 4px;
            font-size: 12px;
        }
        
        .stats {
            gap: 8px;
        }
        
        .stat-box {
            flex: 1 1 calc(50% - 8px);
            padding: 10px 8px;
        }
        
        .stat-box .number {
            font-size: 22px;
        }
        
        .stat-box .label {
            font-size: 11px;
        }
        
        table {
            font-size: 11px;
        }
        
        th {
            padding: 6px 4px;
            font-size: 11px;
        }
        
        td {
            padding: 6px 4px;
            font-size: 11px;
        }
        
        .actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .btn {
            
            margin: 0;
            padding: 12px;
        }
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Event Report</h1>
        <p style="text-align: center; color: #666; margin-bottom: 30px;">
            <?php echo htmlspecialchars($event['event_name']); ?>
        </p>

        <h2>Event Details</h2>
        <table class="info-table">
            <tr>
                <td>Event Name</td>
                <td><?php echo htmlspecialchars($event['event_name']); ?></td>
            </tr>
            <tr>
                <td>Event Type</td>
                <td><?php echo ucfirst($event['event_type']); ?></td>
            </tr>
            <tr>
                <td>Date</td>
                <td><?php echo date('F d, Y', strtotime($event['start_date'])); ?> - <?php echo date('F d, Y', strtotime($event['end_date'])); ?></td>
            </tr>
            <tr>
                <td>Time</td>
                <td><?php echo date('g:i A', strtotime($event['start_time'])); ?> - <?php echo date('g:i A', strtotime($event['end_time'])); ?></td>
            </tr>
            <tr>
                <td>Location</td>
                <td><?php echo htmlspecialchars($event['location']); ?></td>
            </tr>
            <tr>
                <td>Max Participants</td>
                <td><?php echo $event['maximum_participant']; ?></td>
            </tr>
            <tr>
                <td>Points per Person</td>
                <td><?php echo $event['earns_point']; ?></td>
            </tr>
        </table>

        <h2>Summary</h2>
        <div class="stats">
            <div class="stat-box">
                <div class="number"><?php echo $total_registered; ?></div>
                <div class="label">Registered</div>
            </div>
            <div class="stat-box">
                <div class="number"><?php echo $total_approved; ?></div>
                <div class="label">Approved</div>
            </div>
            <div class="stat-box">
                <div class="number"><?php echo $total_attended; ?></div>
                <div class="label">Attended</div>
            </div>
            <div class="stat-box">
                <div class="number"><?php echo $total_points; ?></div>
                <div class="label">Total Points</div>
            </div>
        </div>

        <h2>Participant List</h2>
        <?php if(mysqli_num_rows($participants_result) > 0) { ?>
        <table>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Attendance</th>
            </tr>
            <?php 
            $no = 1;
            while($p = mysqli_fetch_assoc($participants_result)) { 
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($p['name']); ?></td>
                <td><?php echo htmlspecialchars($p['email']); ?></td>
                <td><?php echo ucfirst($p['registration_status']); ?></td>
                <td><?php echo $p['event_attendance'] == 'attended' ? 'Yes' : 'No'; ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php } else { ?>
            <p style="text-align: center; color: #888;">No participants yet.</p>
        <?php } ?>

        <div class="actions">
            <button onclick="window.print()" class="btn btn-print">Print Report</button>
            <a href="participant.php" class="btn btn-back">Back</a>
        </div>
    </div>
</body>
</html>