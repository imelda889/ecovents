
<?php
session_start();

require_once 'dbConn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : 'Event submitted successfully!';
unset($_SESSION['success_message']);

$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/test.png" type="images" />
    <title>Event Submitted Successfully</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #e1efe1;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .success-container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .success-icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: bounce 0.5s;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        h1 {
            color: #2e7d32;
            margin-bottom: 20px;
            font-size: 28px;
        }
        
        .message-box {
            background: #e8f5e9;
            border: 2px solid #2e7d32;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            text-align: left;
        }
        
        .message-box p {
            margin: 0;
            color: #1b5e20;
            line-height: 1.6;
        }
        
        .info-box {
            background: #fff3e0;
            border-left: 4px solid #ff9800;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
        }
        
        .info-box strong {
            display: block;
            margin-bottom: 10px;
            color: #e65100;
        }
        
        .info-box ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        
        .info-box li {
            margin: 5px 0;
            color: #666;
        }
        
        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 30px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .btn-primary {
            background: #2e7d32;
            color: white;
        }
        
        .btn-primary:hover {
            background: #1b5e20;
        }
        
        .btn-secondary {
            background: white;
            color: #2e7d32;
            border: 2px solid #2e7d32;
        }
        
        .btn-secondary:hover {
            background: #e8f5e9;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">✅</div>
        <h1>Event Submitted Successfully!</h1>
        
        <div class="message-box">
            <p><?php echo htmlspecialchars($success_message); ?></p>
        </div>
        
        <div class="info-box">
            <strong>📧 What happens next?</strong>
            <ul>
                <li>An admin will review your event submission</li>
                <li>You will receive an email notification when approved or declined</li>
                <li>Approved events will be visible to all participants</li>
                <li>You can check your event status in "My Events"</li>
            </ul>
        </div>
        
        <div class="btn-group">
            <a href="participant.php" class="btn btn-secondary">View My Events</a>
            <a href="customize_template.php" class="btn btn-primary">Create Another Event</a>
            <a href="organizermainpage.php" class="btn btn-secondary">Go to Dashboard</a>
        </div>
    </div>
</body>
</html>
