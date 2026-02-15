<?php
session_start();
include 'dbConn.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_POST['id']) || !isset($_POST['eventID'])){
    echo "<script>alert('Invalid access!');</script>";
    die("<script>window.location.href='manage_participant.php';</script>");
}
$register_ID = mysqli_real_escape_string($conn, $_POST['id']);
$eventID = mysqli_real_escape_string($conn, $_POST['eventID']);
$sql = "SELECT r.*, u.name, e.event_name, e.start_date, e.end_date 
        FROM registration r 
        JOIN organizer_user u ON r.user_id = u.user_id 
        JOIN event e ON r.eventID = e.eventID 
        WHERE r.register_ID = '$register_ID' AND r.eventID = '$eventID'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if(!$data || $data['event_attendance'] != 'attended') {
    echo "<script>alert('Invalid request!');</script>";
    die("<script>window.location.href='manage_participant.php?eventID=$eventID';</script>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/test.png" type="images" />
    <title>Certificate</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: 'Georgia', serif;
            background: #f5f5f5;
        }
        
        .certificate {
            width: 800px;
            margin: 0 auto;
            padding: 60px;
            background: white;
            border: 15px solid #2e7d32;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        
        .certificate h1 {
            text-align: center;
            font-size: 48px;
            color: #2e7d32;
            margin: 0 0 30px 0;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        
        .certificate .content {
            text-align: center;
            font-size: 18px;
            line-height: 2;
            color: #333;
        }
        
        .participant-name {
            font-size: 36px;
            font-weight: bold;
            color: #0b5c31;
            margin: 20px 0;
            text-decoration: underline;
        }
        
        .event-name {
            font-size: 24px;
            font-weight: bold;
            color: #2e7d32;
            margin: 15px 0;
        }
        
        .date {
            margin-top: 40px;
            font-size: 16px;
            color: #666;
        }
        
        .buttons {
            text-align: center;
            margin: 30px 0;
        }
        
        .btn {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-print {
            background: #2e7d32;
            color: white;
        }
        
        .btn-back {
            background: #666;
            color: white;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .buttons {
                display: none;
            }
            .certificate {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="buttons">
        <button onclick="window.print()" class="btn btn-print">Print Certificate</button>
        <button onclick="window.close()" class="btn btn-back">Back</button>
    </div>

    <div class="certificate">
        <h1>Certificate of Participation</h1>
        
        <div class="content">
            <p>This is to certify that</p>
            
            <div class="participant-name">
                <?php echo htmlspecialchars($data['name']); ?>
            </div>
            
            <p>has successfully participated in</p>
            
            <div class="event-name">
                <?php echo htmlspecialchars($data['event_name']); ?>
            </div>
            
            <p>held on <?php echo date('F d, Y', strtotime($data['start_date'])); ?></p>
            
            <div class="date">
                <p>Issue Date: <?php echo date('F d, Y'); ?></p>
            </div>
        </div>
    </div>
</body>
</html>