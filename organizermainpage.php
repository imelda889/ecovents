<?php
include 'dbConn.php';
include 'check.php';
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoVents Organizer Main Page</title>
    <link rel="icon" href="img/test.png" type="images" />
    
    <link rel="stylesheet" href="style.css">
    
    <style>
        
        .ecobackground{
            position: relative;
            width:100%;
            height: clamp(220px,35vw, 380px);
            background-image:url("img/ecobackground.jpg");
            background-size: cover;
            background-position: center;
        }
        .ecobackground::before{
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(255,255,255,0.75); 
        }
        .ecobackground-overlay{
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-top: 50px;
            text-align: center;
            gap: 15px;
        }
        .ecobackground-overlay h1{
            margin: 0;
            margin-top: 0;
            font-size: clamp(28px, 4vw, 48px);
            font-weight: 800;
            letter-spacing: 2px;
            color: #135E4B;
        }
        .ecobackground-overlay h2{
            margin: 0;
            font-size: clamp(28px, 4vw, 48px);
            font-weight: 800;
            letter-spacing: 2px;
            color: #469c86;
        }
        .ecobackground-overlay p{
            margin: 0;
            font-size: clamp(14px, 2vw, 20px);
            font-weight: 600;
            color: #15b96c;
        }
        .hero-buttons{
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 10px;
            width: 220px;
        }
        .create-event-btn{
            padding: 14px 32px;
            background-color: #469c71;
            color: white;
            border: none;
            border-radius: 18px;
            font-size: clamp(14px, 1.5vw, 18px);
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;         
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
        }
        .create-event-btn:hover{
            background-color: #135e41;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .create-event-btn:active{
            transform: translateY(0);
        }
        .explore-features-btn{
            padding: 14px 32px;
            background-color: #145d37;
            color: white;
            border: none;
            border-radius: 18px;
            font-size: clamp(14px, 1.5vw, 18px);
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
        }
        .explore-features-btn:hover{
            background-color: #348974;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .explore-features-btn:active{
            transform: translateY(0);
        }
        .ecobackground{
            min-height: 480px;
            height: auto;
        }
        
        .features {
            padding: 64px 32px;
        }
        .features h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 48px;
            color: #4CAF50;
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
            max-width: 900px;
            margin: 0 auto;
        }
        .content1{
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #83d699;
            color: white;
            padding: 24px;
            border-radius: 25px;
            border: 1px double rgba(197, 224, 198, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            aspect-ratio: unset;
            min-height: 200px;
        }
        .content1:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
            border-color: #558c6e;
        }
        .content1 h3 {
            margin-top: 0;
            margin-bottom: 16px;
            font-size: 1.3rem;
            color:#135E4B
        }
        .content1 p {
            margin: 0;
            line-height: 1.6;
        }
        
        @media (max-width: 768px) {
            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="ecobackground">
        <div class="ecobackground-overlay">
            <h1 class="from-bottom delay-1">Create Change</h1>
            <h2 class="from-bottom delay-2">Lead the Movement</h2>
            <p class="from-bottom delay-3">Empower your community to take action. Organize a sustainability event </p>
            <p class="from-bottom delay-3">that inspires change, builds awareness, and creates lasting impact for our planet.</p>
            
            <div class="hero-buttons">
                <button class="create-event-btn" onclick="window.location.href='createevent.php'">Create Event</button>
                <button class="explore-features-btn" onclick="document.getElementById('features-section').scrollIntoView({ behavior: 'smooth' })">Explore Features</button>
            </div>
        </div>

        
    </section>

    <section class="features" id="features-section">
        <h2>Everything You Need to Make an Impact</h2>
        <div class="feature-grid">
            <div class="content1" onclick="window.location.href='organizermainpage.php'"><h3>Dashboard</h3><p>Get a comprehensive overview of all your sustainability initiatives with real-time metrics and insights.</p></div>
            <div class="content1" onclick="window.location.href='createevent.php'"><h3>Create Events</h3><p>Design and launch eco-friendly events with our intuitive event creation tools and templates.</p></div>
            <div class="content1" onclick="window.location.href='participant.php'"><h3>Participants</h3><p>Track engagement, manage registrations, and build your community of eco-champions.</p></div>
            <div class="content1" onclick="window.location.href='analytic.php'"><h3>Analytics</h3><p>Comprehensive insights into your sustainable event impact</p></div>
            <div class="content1" onclick="window.location.href='participant.php'"><h3>Records</h3><p>Generate detailed impact reports showcasing your environmental contributions and achievements.</p></div>
            <div class="content1" onclick="window.location.href='event_calendar.php'"><h3>Calendar</h3><p>Manage your event schedule and never miss an important sustainability milestone.</p></div>
        </div>
    </section>
<?php include 'footer.php'; ?>
</body>
</html>