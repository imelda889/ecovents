<?php
session_start();
include 'dbConn.php';
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/test.png" type="images" />
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        
        .main-container {
            max-width: 600px;
            margin: 80px auto;
            padding: 40px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
        
        h1 {
            color: #2e7d32;
            margin-bottom: 10px;
            font-size: 32px;
        }
        
        p {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .create-btn {
            background: #2e7d32;
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
        }
        
        .create-btn:hover {
            background: #1b5e20;
        }
        
        .features {
            margin-top: 40px;
            text-align: left;
            padding-top: 30px;
            border-top: 1px solid #e0e0e0;
        }
        
        .feature-item {
            display: flex;
            align-items: start;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .feature-icon {
            font-size: 20px;
            margin-top: 2px;
        }
        
        .feature-text {
            color: #666;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .main-container {
                margin: 40px 20px;
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php';?>
    
    <div class="main-container">
        <div class="icon">🌱</div>
        <h1>Create Sustainable Event</h1>
        <p>Start planning your eco-friendly event in minutes. Add all the details, invite participants, and track your environmental impact.</p>
        
        <a href="customize_template.php" class="create-btn">Create New Event</a>
        
        <div class="features">
            <div class="feature-item">
                <span class="feature-icon">✅</span>
                <span class="feature-text">Easy event setup with all essential details</span>
            </div>
            <div class="feature-item">
                <span class="feature-icon">👥</span>
                <span class="feature-text">Invite collaborators and manage participants</span>
            </div>
            <div class="feature-item">
                <span class="feature-icon">🌍</span>
                <span class="feature-text">Track sustainability impact and carbon reduction</span>
            </div>
            <div class="feature-item">
                <span class="feature-icon">📊</span>
                <span class="feature-text">Monitor registrations and engagement</span>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>

<?php
mysqli_close($conn);
?>