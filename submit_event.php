<?php
session_start();
require_once 'dbConn.php';

if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : (isset($_SESSION['name']) ? $_SESSION['name'] : '');
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : (isset($_SESSION['email']) ? $_SESSION['email'] : '');
$user_contact = isset($_SESSION['user_contact']) ? $_SESSION['user_contact'] : '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $image_name = '';
    if(isset($_FILES['event_image']) && $_FILES['event_image']['error'] == 0){
        $allowed_types = array('image/jpeg', 'image/png', 'image/jpg', 'image/gif');
        $file_type = $_FILES['event_image']['type'];
        
        if(in_array($file_type, $allowed_types)){
            $file_extension = pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION);
            $image_name = 'event_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
            $upload_path = 'img/' . $image_name;
            
            if(!move_uploaded_file($_FILES['event_image']['tmp_name'], $upload_path)){
                $_SESSION['error_message'] = "Error uploading image file.";
                header("Location: customize_template.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Invalid image format. Please upload JPG, PNG, or GIF.";
            header("Location: customize_template.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Please upload an event image.";
        header("Location: customize_template.php");
        exit();
    }
    
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $event_type = mysqli_real_escape_string($conn, $_POST['event_type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $event_cost = !empty($_POST['event_cost']) ? floatval($_POST['event_cost']) : 0.00;
    $transportation_plan = mysqli_real_escape_string($conn, $_POST['transportation_plan']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($conn, $_POST['end_time']);

    $sustainability = '';
    if(isset($_POST['sustainability']) && is_array($_POST['sustainability'])){
        $sustainability = mysqli_real_escape_string($conn, implode(', ', $_POST['sustainability']));
    }

    $carbon_reduction = isset($_POST['carbon_reduction']) ? (int)$_POST['carbon_reduction'] : 0; 

    $max_participants = (int)$_POST['max_participants'];
    $points_per_participant = (int)$_POST['points_per_participant'];
    $registration_deadline = mysqli_real_escape_string($conn, $_POST['registration_deadline']);

    $participant_categories = '';
    if(isset($_POST['participant_categories']) && is_array($_POST['participant_categories'])){
        $participant_categories = mysqli_real_escape_string($conn, implode(', ', $_POST['participant_categories']));
    }

    $collaborator_emails = array();
    $collaborator_roles = array();

    if(isset($_POST['collaborators']) && is_array($_POST['collaborators'])){
        foreach($_POST['collaborators'] as $collab){
            if(!empty($collab['email'])){
                $collaborator_emails[] = mysqli_real_escape_string($conn, $collab['email']);
                $collaborator_roles[] = mysqli_real_escape_string($conn, $collab['role']);
            }
        }
    }

    $collaborator_email = implode(', ', $collaborator_emails);
    $collaborator_category = implode(', ', $collaborator_roles);
    
    $organizer_name = mysqli_real_escape_string($conn, $user_name);
    $organizer_email = mysqli_real_escape_string($conn, $user_email);
    $organizer_contact = mysqli_real_escape_string($conn, $user_contact);

    $status = 'pending';

    $sql = "INSERT INTO event (
        user_id, 
        event_name, 
        event_type, 
        description, 
        start_date, 
        end_date, 
        start_time, 
        end_time, 
        sustainability, 
        maximum_participant, 
        earns_point, 
        registration_deadlines, 
        participant_categories, 
        image,
        event_cost, 
        location, 
        transportation_plan,
        collaborator_email, 
        collaborator_category, 
        organizer_name, 
        organizer_email, 
        organizer_contact_no, 
        carbon_reduction, 
        status
    ) VALUES (
        '$user_id',
        '$event_name',
        '$event_type',
        '$description',
        '$start_date',
        '$end_date',
        '$start_time',
        '$end_time',
        '$sustainability',
        $max_participants,
        $points_per_participant,
        '$registration_deadline',
        '$participant_categories',
        '$image_name',
        $event_cost,
        '$location',
        '$transportation_plan',
        '$collaborator_email',
        '$collaborator_category',
        '$organizer_name',
        '$organizer_email',
        '$organizer_contact',
        $carbon_reduction,
        '$status'
    )";
    
    if (mysqli_query($conn, $sql)) {
        $event_id = mysqli_insert_id($conn);
        
        $_SESSION['success_message'] = "Event submitted successfully! Your event is pending admin approval. You will receive an email notification once the admin reviews your event.";
        header("Location: success_page.php?event_id=" . $event_id);
        exit();
    } else {
        if(file_exists('img/' . $image_name)){
            unlink('img/' . $image_name);
        }
        $_SESSION['error_message'] = "Error submitting event: " . mysqli_error($conn);
        header("Location: customize_template.php");
        exit();
    }
    
} else {
    header("Location: customize_template.php");
    exit();
}

mysqli_close($conn);
?>