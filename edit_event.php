<?php
session_start();
include 'dbConn.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(!isset($_POST['id'])) {
    echo "<script>alert('No event ID provided!');</script>";
    die("<script>window.location.href='participant.php';</script>");
}

$eventID = mysqli_real_escape_string($conn, $_POST['id']);

$sql = "SELECT * FROM event WHERE eventID = '$eventID' AND user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if($rows = mysqli_fetch_array($result)) {
    $event_name = $rows['event_name'];
    $event_type = $rows['event_type'];
    $description = $rows['description'];
    $start_date = $rows['start_date'];
    $end_date = $rows['end_date'];
    $start_time = $rows['start_time'];
    $end_time = $rows['end_time'];
    $location = $rows['location'];
    $maximum_participant = $rows['maximum_participant'];
    $registration_deadlines = $rows['registration_deadlines'];
    $participant_categories = $rows['participant_categories'];
    $event_cost = $rows['event_cost'];
    $transportation_plan = $rows['transportation_plan'];
    $sustainability = $rows['sustainability'];
    $carbon_reduction = $rows['carbon_reduction'];
    $earns_point = $rows['earns_point'];
} else {
    echo "<script>alert('No data from db! Technical errors!');</script>";
    die("<script>window.location.href='participant.php';</script>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="icon" href="img/test.png" type="images" />
    <style>
        body {
            background-color: #deedde;
            font-family: Arial, sans-serif;
        }
        
        h1 {
            text-align: center;
            color: #0b5c31;
            margin-top: 30px;
        }
        
        form {
            max-width: 700px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            text-align: left;
            padding: 10px;
            color: #333;
            font-weight: 600;
        }
        
        td {
            padding: 10px;
        }
        
        input[type="text"],
        input[type="date"],
        input[type="time"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        input[type="submit"] {
            background: #2e7d32;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin: 5px;
        }
        
        input[type="submit"]:hover {
            background: #1b5e20;
        }
        
        .checkbox-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .checkbox-item input {
            width: auto;
        }
    </style>
</head>
<body>
    <center>
        <h1>Edit Event</h1>
        <form method="post" action="update_event.php">
            <table>
                <tr>
                    <th width="200px">Event ID:</th>
                    <td width="500px">
                        <input type="text" name="event_id" value="<?php echo $eventID; ?>" readonly/>
                    </td>
                </tr>
                
                <tr>
                    <th>Event Name:</th>
                    <td>
                        <input type="text" name="event_name" value="<?php echo $event_name; ?>" required/>
                    </td>
                </tr>
                
                <tr>
                    <th>Event Type:</th>
                    <td>
                        <select name="event_type" required>
                            <option value="">Select event type</option>
                            <option value="conference" <?php if($event_type == "conference") echo "selected"; ?>>Conference</option>
                            <option value="workshop" <?php if($event_type == "workshop") echo "selected"; ?>>Workshop</option>
                            <option value="seminar" <?php if($event_type == "seminar") echo "selected"; ?>>Seminar</option>
                            <option value="webinar" <?php if($event_type == "webinar") echo "selected"; ?>>Webinar</option>
                            <option value="communitycleanup" <?php if($event_type == "communitycleanup") echo "selected"; ?>>Community Cleanup</option>
                            <option value="treesplantation" <?php if($event_type == "treesplantation") echo "selected"; ?>>Tree Plantation</option>
                            <option value="other" <?php if($event_type == "other") echo "selected"; ?>>Other</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <th>Description:</th>
                    <td>
                        <textarea name="description" required><?php echo $description; ?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <th>Start Date:</th>
                    <td>
                        <input type="date" name="start_date" value="<?php echo $start_date; ?>" required/>
                    </td>
                </tr>
                
                <tr>
                    <th>End Date:</th>
                    <td>
                        <input type="date" name="end_date" value="<?php echo $end_date; ?>" required/>
                    </td>
                </tr>
                
                <tr>
                    <th>Start Time:</th>
                    <td>
                        <input type="time" name="start_time" value="<?php echo $start_time; ?>" required/>
                    </td>
                </tr>
                
                <tr>
                    <th>End Time:</th>
                    <td>
                        <input type="time" name="end_time" value="<?php echo $end_time; ?>" required/>
                    </td>
                </tr>
                
                <tr>
                    <th>Location:</th>
                    <td>
                        <input type="text" name="location" value="<?php echo $location; ?>" required/>
                    </td>
                </tr>
                
                <tr>
                    <th>Maximum Participants:</th>
                    <td>
                        <input type="number" name="maximum_participant" value="<?php echo $maximum_participant; ?>" required/>
                    </td>
                </tr>
                
                <tr>
                    <th>Registration Deadline:</th>
                    <td>
                        <input type="date" name="registration_deadlines" value="<?php echo $registration_deadlines; ?>" required/>
                    </td>
                </tr>
                
                <tr>
                    <th>Participant Categories:</th>
                    <td>
                        <div class="checkbox-group">
                            <?php 
                            $categories = explode(',', $participant_categories);
                            ?>
                            <div class="checkbox-item">
                                <input type="checkbox" name="participant_categories[]" value="student" 
                                <?php if(in_array('student', $categories)) echo "checked"; ?>>
                                <label>Student</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="participant_categories[]" value="faculty" 
                                <?php if(in_array('faculty', $categories)) echo "checked"; ?>>
                                <label>Faculty</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="participant_categories[]" value="staff" 
                                <?php if(in_array('staff', $categories)) echo "checked"; ?>>
                                <label>Staff</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="participant_categories[]" value="alumni" 
                                <?php if(in_array('alumni', $categories)) echo "checked"; ?>>
                                <label>Alumni</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="participant_categories[]" value="external" 
                                <?php if(in_array('external', $categories)) echo "checked"; ?>>
                                <label>External</label>
                            </div>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <th>Event Cost (RM):</th>
                    <td>
                        <input type="number" name="event_cost" value="<?php echo $event_cost; ?>" step="0.01"/>
                    </td>
                </tr>
                
                <tr>
                    <th>Transportation Plan:</th>
                    <td>
                        <textarea name="transportation_plan"><?php echo $transportation_plan; ?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <th>Carbon Reduction:</th>
                    <td>
                        <input type="number" name="carbon_reduction" value="<?php echo $carbon_reduction; ?>" step="0.01"/>
                    </td>
                </tr>
                
                <tr>
                    <th>Points per Participant:</th>
                    <td>
                        <input type="number" name="earns_point" value="<?php echo $earns_point; ?>" required/>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <br/>
                        <center>
                            <input type="submit" value="Update Event"/>
                            <input type="submit" value="Back to Previous Page" formaction="participant.php"/>
                        </center>
                    </td>
                </tr>
            </table>
        </form>
    </center>
</body>
</html>