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

$sql = "SELECT r.*, u.name, u.email 
        FROM registration r 
        JOIN organizer_user u ON r.user_id = u.user_id 
        WHERE r.eventID = '$eventID' 
        ORDER BY r.registration_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Participant</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/test.png" type="images" />
    <style>
        body {
            background-color: #deedde;
            color: #0b5c31;
            font-family: Arial, sans-serif;
        }

        h2 {
            font-size: 25px;
            margin-bottom: 10px;
            padding: 0 20px;
        }
        
        .back {
            display: inline-block;
            color: #2e7d33;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 20px;
            margin-left: 20px;
        }
        
        .event-info {
            background: white;
            padding: 15px 20px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .event-info h3 {
            margin: 0 0 10px 0;
            color: #0b5c31;
        }
        
        .event-info p {
            margin: 5px 0;
            color: #555;
        }
        
        .container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 0 20px;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
            vertical-align: top;
        }
        
        tr:hover {
            background: #f5f5f5;
        }
        
        .status {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-approved {
            background: #d4edda;
            color: #155724;
        }
        
        .status-declined {
            background: #f8d7da;
            color: #721c24;
        }
        
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            margin: 2px;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-approve {
            background: #28a745;
            color: white;
        }
        
        .btn-approve:hover {
            background: #218838;
        }
        
        .btn-decline {
            background: #dc3545;
            color: white;
        }
        
        .btn-decline:hover {
            background: #c82333;
        }
        
        .btn-attendance {
            background: #007bff;
            color: white;
        }
        
        .btn-attendance:hover {
            background: #0056b3;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #888;
        }
        
        .attendance-check {
            color: #28a745;
            font-weight: bold;
        }
        
        .feedback-text {
            max-width: 250px;
            font-size: 13px;
            color: #333;
            line-height: 1.4;
        }
        
        .no-feedback {
            color: #999;
            font-style: italic;
            font-size: 13px;
        }

        
        
    </style>
</head>
<body>
    <?php include 'header.php';?>
    
    <h2>Participant Management</h2>
    <a href="participant.php" class="back">← Back to List</a>
    
    <div class="event-info">
        <h3><?php echo htmlspecialchars($event['event_name']); ?></h3>
        <p>📅 <?php echo date('M d, Y', strtotime($event['start_date'])); ?> | 
           📍 <?php echo htmlspecialchars($event['location']); ?> | 
           🎯 Points: <?php echo $event['earns_point']; ?></p>
    </div>

    <div class="container">
        <?php if(mysqli_num_rows($result) > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Participant Name</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                    <th>Status</th>
                    <th>Attendance</th>
                    <th>Feedback</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($result)) { 
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['registration_date'])); ?></td>
                    <td>
                        <?php 
                        $status = $row['registration_status'];
                        $status_class = 'status-pending';
                        if($status == 'approved') $status_class = 'status-approved';
                        if($status == 'declined') $status_class = 'status-declined';
                        ?>
                        <span class="status <?php echo $status_class; ?>">
                            <?php echo ucfirst($status); ?>
                        </span>
                    </td>
                    <td>
                        <?php 
                        if($row['event_attendance'] == 'attended') {
                            echo '<span class="attendance-check">✓ Attended</span>';
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                    <td>
                        <?php if(!empty($row['feedback'])) { ?>
                            <div class="feedback-text"><?php echo htmlspecialchars($row['feedback']); ?></div>
                        <?php } else { ?>
                            <span class="no-feedback">No feedback</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if($status == 'pending') { ?>
                            <a href="update_registration.php?id=<?php echo $row['register_ID']; ?>&action=approve&eventID=<?php echo $eventID; ?>" 
                               class="btn btn-approve" 
                               onclick="return confirm('Approve this participant?')">
                                Approve
                            </a>
                            <a href="update_registration.php?id=<?php echo $row['register_ID']; ?>&action=decline&eventID=<?php echo $eventID; ?>" 
                               class="btn btn-decline" 
                               onclick="return confirm('Decline this participant?')">
                                Decline
                            </a>
                        <?php } ?>
                        
                        <?php if($status == 'approved' && $row['event_attendance'] != 'attended') { ?>
                            <a href="update_registration.php?id=<?php echo $row['register_ID']; ?>&action=attendance&eventID=<?php echo $eventID; ?>&points=<?php echo $event['earns_point']; ?>&userid=<?php echo $row['user_id']; ?>" 
                               class="btn btn-attendance" 
                               onclick="return confirm('Mark as attended and award points?')">
                                Mark Attendance
                            </a>
                        <?php } ?>

                        <?php if($status == 'approved' && $row['event_attendance'] == 'attended') { ?>
                            <form action="generate_certificate.php" method="POST" target="_blank" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['register_ID']; ?>">
                                <input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
                                <button type="submit" class="btn btn-attendance">
                                    Generate Certificate
                                </button>
                            </form>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
            <div class="no-data">
                <p>No participants registered yet.</p>
            </div>
        <?php } ?>
    </div>
<?php include 'footer.php'; ?>
</body>
</html>