<?php
session_start();
include "dbConn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../library/PHPMailer/src/Exception.php';
require '../library/PHPMailer/src/PHPMailer.php';
require '../library/PHPMailer/src/SMTP.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id']) || !isset($_GET['action']) || !isset($_GET['eventID'])) {
    echo "<script>alert('Invalid request!');</script>";
    die("<script>window.location.href='participant.php';</script>");
}

$register_ID = mysqli_real_escape_string($conn, $_GET['id']);
$action = mysqli_real_escape_string($conn, $_GET['action']);
$eventID = mysqli_real_escape_string($conn, $_GET['eventID']);

if($action == 'approve') {
    $sql = "UPDATE registration SET registration_status = 'approved' WHERE register_ID = '$register_ID'";
    
    if(mysqli_query($conn, $sql)) {

        $email_sql = "SELECT u.email, u.name, e.event_name, e.start_date, e.location
                      FROM registration r
                      JOIN organizer_user u ON r.user_id = u.user_id
                      JOIN event e ON r.eventID = e.eventID
                      WHERE r.register_ID = '$register_ID'";

        $result = mysqli_query($conn, $email_sql);
        $data = mysqli_fetch_assoc($result);

        sendApprovalEmail(
            $data['email'],
            $data['name'],
            $data['event_name'],
            date('M d, Y', strtotime($data['start_date'])),
            $data['location']
        );
        echo "<script>alert('Participant approved successfully!');</script>";
    } else {
        echo "<script>alert('Error approving participant!');</script>";
    }
    
} elseif($action == 'decline') {
    $sql = "UPDATE registration SET registration_status = 'declined' WHERE register_ID = '$register_ID'";
    
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Participant declined!');</script>";
    } else {
        echo "<script>alert('Error declining participant!');</script>";
    }
    
} elseif($action == 'attendance') {
    if(!isset($_GET['points']) || !isset($_GET['userid'])) {
        echo "<script>alert('Missing parameters!');</script>";
        die("<script>window.location.href='participantManage.php?eventID=$eventID';</script>");
    }
    
    $points = mysqli_real_escape_string($conn, $_GET['points']);
    $participant_id = mysqli_real_escape_string($conn, $_GET['userid']);
    
    $sql = "UPDATE registration SET event_attendance = 'attended' WHERE register_ID = '$register_ID'";
    
    if(mysqli_query($conn, $sql)) {
        $update_points = "UPDATE organizer_user SET points = points + $points WHERE user_id = '$participant_id'";
        
        if(mysqli_query($conn, $update_points)) {
            echo "<script>alert('Attendance marked and $points points awarded!');</script>";
        } else {
            echo "<script>alert('Attendance marked but error awarding points!');</script>";
        }
    } else {
        echo "<script>alert('Error marking attendance!');</script>";
    }
}

echo "<script>window.location.href='participantManage.php?eventID=$eventID';</script>";

function sendApprovalEmail($toEmail, $toName, $eventName, $eventDate, $location) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'company.ecovents@gmail.com';
        $mail->Password = 'zhdi lhtn afjk famb';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('company.ecovents@gmail.com', 'EcoVents');
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);
        $mail->Subject = 'Event Registration Approved';

        $mail->Body = "
            <h3>🎉 Registration Approved</h3>
            <p>Hello <b>$toName</b>,</p>
            <p>Your registration for the following event has been approved:</p>
            <ul>
                <li><b>Event:</b> $eventName</li>
                <li><b>Date:</b> $eventDate</li>
                <li><b>Location:</b> $location</li>
            </ul>
            <p>We look forward to seeing you there 🌱</p>
            <br>
            <p>Best Regards,<br>EcoVents Team</p>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email error: {$mail->ErrorInfo}");
    }
}

?>