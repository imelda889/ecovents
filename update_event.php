<?php
session_start();
include "dbConn.php";

if(!isset($_POST['event_id'])) {
    echo "<script>alert('Invalid request!');</script>";
    die("<script>window.location.href='participant.php';</script>");
}

$eventID = mysqli_real_escape_string($conn, $_POST['event_id']);
$event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
$event_type = mysqli_real_escape_string($conn, $_POST['event_type']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
$end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
$start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
$end_time = mysqli_real_escape_string($conn, $_POST['end_time']);
$location = mysqli_real_escape_string($conn, $_POST['location']);
$maximum_participant = mysqli_real_escape_string($conn, $_POST['maximum_participant']);
$registration_deadlines = mysqli_real_escape_string($conn, $_POST['registration_deadlines']);
$event_cost = mysqli_real_escape_string($conn, $_POST['event_cost']);
$transportation_plan = mysqli_real_escape_string($conn, $_POST['transportation_plan']);
$carbon_reduction = mysqli_real_escape_string($conn, $_POST['carbon_reduction']);
$earns_point = mysqli_real_escape_string($conn, $_POST['earns_point']);

$participant_categories = '';
if(isset($_POST['participant_categories'])) {
    $participant_categories = implode(',', $_POST['participant_categories']);
}

$sql = "UPDATE event SET ".
    "event_name = '$event_name', ".
    "event_type = '$event_type', ".
    "description = '$description', ".
    "start_date = '$start_date', ".
    "end_date = '$end_date', ".
    "start_time = '$start_time', ".
    "end_time = '$end_time', ".
    "location = '$location', ".
    "maximum_participant = '$maximum_participant', ".
    "registration_deadlines = '$registration_deadlines', ".
    "participant_categories = '$participant_categories', ".
    "event_cost = '$event_cost', ".
    "transportation_plan = '$transportation_plan', ".
    "carbon_reduction = '$carbon_reduction', ".
    "earns_point = '$earns_point', ".
    "updated_at = NOW() ".
    "WHERE eventID = '$eventID'";

mysqli_query($conn, $sql);

if(mysqli_affected_rows($conn) <= 0) {
    echo "<script>alert('Cannot update data!');</script>";
    echo "<script>window.location.href='edit_event.php?eventID=$eventID';</script>";
} else {
    echo "<script>alert('Successfully updated event!');</script>";
    echo "<script>window.location.href='participant.php';</script>";
}
?>