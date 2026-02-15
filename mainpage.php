<?php
session_start();

$host = 'localhost';
$dbname = 'users';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$stmt = $pdo->query("SELECT * FROM news ORDER BY news_created_at DESC LIMIT 5");
$recentAnnouncements = $stmt->fetchAll(PDO::FETCH_ASSOC);

$countStmt = $pdo->query("SELECT COUNT(*) as total FROM news");
$totalAnnouncementsCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EcoEvents Dashboard</title>
<link rel="icon" href="../imagessssss/LOGO.png" type="image/png" sizes="280x280">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        background-attachment: fixed;
        color: #000;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 15px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .logo img {
        height: 50px;
        width: auto;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    .nav {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.8));
        padding: 12px 25px;
        border-radius: 50px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.6);
    }

    .nav a {
        text-decoration: none;
        color: #2c3e50;
        margin: 0 15px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav a:hover {
        color: #3498db;
        transform: translateY(-2px);
    }

    .nav a.active {
        color: #3498db;
        font-weight: 700;
    }

    .nav a.active::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3498db, #2980b9);
        border-radius: 2px;
    }

    .profile {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
    }

    .profile-text a {
        text-decoration: none;
        color: #2c3e50;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .profile-text a:hover {
        color: #3498db;
    }

    .profile-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #3498db;
        cursor: pointer;
        background: linear-gradient(135deg, #3498db, #2980b9);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
    }

    .profile-circle:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.6);
    }

    .profile-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
        justify-content: center;
        align-items: center;
        z-index: 999;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .content {
        padding: 40px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        flex: 1;
        width: 100%;
        box-sizing: border-box;
        border-radius: 0;
        box-shadow: none;
    }

    h1 {
        margin-bottom: 40px;
        letter-spacing: 2px;
        font-size: 36px;
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 800;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }

    .card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7));
        padding: 30px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3498db, #2980b9);
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(52, 152, 219, 0.3);
    }

    .card h3 {
        margin: 0 0 20px 0;
        font-size: 14px;
        font-weight: 700;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .card p {
        font-size: 42px;
        margin-top: 15px;
        font-weight: 800;
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-title {
        padding: 20px 25px;
        background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
        font-weight: 700;
        color: white;
        border-radius: 15px 15px 0 0;
        font-size: 18px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .table-wrapper {
        background: white;
        border-radius: 15px;
        margin-bottom: 40px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(52, 152, 219, 0.2);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 18px;
        text-align: left;
    }

    th {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(41, 128, 185, 0.1));
        font-weight: 700;
        color: #2c3e50;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid rgba(52, 152, 219, 0.2);
    }

    td {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 14px;
        color: #34495e;
    }

    tr:hover {
        background: rgba(52, 152, 219, 0.05);
        transition: background 0.3s ease;
    }

    tr:last-child td {
        border-bottom: none;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .view-btn {
        background: linear-gradient(135deg, #34495e, #2c3e50);
        color: white;
    }

    .view-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 73, 94, 0.4);
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .status-pending {
        background: linear-gradient(135deg, #f39c12, #e67e22);
        color: white;
    }

    .status-approved {
        background: linear-gradient(135deg, #27ae60, #229954);
        color: white;
    }

    .status-rejected {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
    }

    .status-complete {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
    }

    .status-upcoming {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
    }

    .overview-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        justify-content: center;
        align-items: center;
        z-index: 1002;
        overflow-y: auto;
        padding: 20px 0;
        animation: fadeIn 0.3s ease;
    }

    .overview-content {
        background: #ffffff;
        width: 90%;
        max-width: 900px;
        margin: auto;
        padding: 0;
        border-radius: 20px;
        box-shadow: 0 20px 80px rgba(0, 0, 0, 0.3);
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        animation: slideUp 0.4s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .overview-header {
        background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
        color: white;
        padding: 30px;
        border-radius: 20px 20px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .overview-title {
        font-size: 28px;
        font-weight: 800;
        margin: 0;
        letter-spacing: 1px;
    }

    .close-overview {
        font-size: 32px;
        cursor: pointer;
        color: white;
        line-height: 1;
        transition: transform 0.2s ease, opacity 0.2s ease;
        opacity: 0.9;
    }

    .close-overview:hover {
        transform: scale(1.2) rotate(90deg);
        opacity: 1;
    }

    .overview-body {
        padding: 35px;
    }

    .overview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 25px;
    }

    .overview-field {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.05), rgba(41, 128, 185, 0.05));
        padding: 22px;
        border-radius: 12px;
        border-left: 5px solid #3498db;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .overview-field:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 25px rgba(52, 152, 219, 0.15);
    }

    .overview-label {
        font-weight: 700;
        color: #3498db;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .overview-value {
        font-size: 16px;
        color: #2c3e50;
        word-wrap: break-word;
        line-height: 1.6;
        font-weight: 500;
    }

    .overview-full-width {
        grid-column: 1 / -1;
    }

    .overview-section-title {
        font-size: 22px;
        font-weight: 700;
        color: #2c3e50;
        margin: 35px 0 25px 0;
        padding-bottom: 15px;
        border-bottom: 3px solid;
        border-image: linear-gradient(90deg, #3498db, #2980b9) 1;
    }

    .overview-image {
        width: 100%;
        max-width: 100%;
        height: auto;
        border-radius: 15px;
        margin-top: 10px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .overview-image:hover {
        transform: scale(1.02);
    }

    .overview-footer {
        padding: 25px 35px;
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.05), rgba(41, 128, 185, 0.05));
        border-radius: 0 0 20px 20px;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .overview-close-btn {
        padding: 12px 35px;
        background: linear-gradient(135deg, #34495e, #2c3e50);
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(52, 73, 94, 0.3);
    }

    .overview-close-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(52, 73, 94, 0.5);
    }

    .announcement-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        justify-content: center;
        align-items: center;
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }

    .announcement-modal-content {
        background: white;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        border-radius: 20px;
        padding: 35px;
        position: relative;
        overflow-y: auto;
        box-shadow: 0 20px 80px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.4s ease;
    }

    .close-announcement-modal {
        position: absolute;
        top: 20px;
        right: 25px;
        font-size: 32px;
        cursor: pointer;
        font-weight: 300;
        color: #95a5a6;
        transition: all 0.3s ease;
    }

    .close-announcement-modal:hover {
        color: #3498db;
        transform: scale(1.2) rotate(90deg);
    }

    .announcement-modal-title {
        font-size: 26px;
        font-weight: 800;
        margin-bottom: 30px;
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .announcement-field {
        margin-bottom: 25px;
    }

    .announcement-field-label {
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 10px;
        color: #3498db;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .announcement-field-value {
        font-size: 15px;
        color: #2c3e50;
        line-height: 1.8;
        padding: 18px;
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.05), rgba(41, 128, 185, 0.05));
        border-left: 5px solid #27ae60;
        border-radius: 8px;
    }

    .announcement-close-btn {
        background: linear-gradient(135deg, #34495e, #2c3e50);
        color: white;
        border: none;
        padding: 12px 35px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 25px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(52, 73, 94, 0.3);
    }

    .announcement-close-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(52, 73, 94, 0.5);
    }

    .footer {
        padding: 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        text-align: center;
        font-size: 13px;
        color: #7f8c8d;
        font-weight: 600;
        border-radius: 0;
        box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.05);
    }

    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #3498db, #2980b9);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #2980b9, #3498db);
    }

    @media (max-width: 900px) {
        .content {
            padding: 25px;
        }

        .overview-content {
            width: 95%;
            margin: 10px auto;
        }

        .overview-body {
            padding: 25px;
        }

        .overview-grid {
            grid-template-columns: 1fr;
        }

        .overview-header {
            padding: 25px;
        }

        .overview-title {
            font-size: 22px;
        }
    }
</style>
</head>
<body>

<div class="header">
    <div class="logo">
        <img src="photo/Logo.png" alt="Logo">
    </div>

    <div class="nav">
        <a href="mainpage.php" class="active">Dashboard</a>
        <a href="manage-user.php">Manage User Account</a>
        <a href="approve-reject.php">Approve / Reject</a>
        <a href="database-record.php">Database & Records</a>
        <a href="announcements.php">Announcements</a>
        <a href="report.php">Report</a>
    </div>

    <div class="profile">
        <div class="profile-text">
            <a href="adminprofile.php">My Profile</a>
        </div>
        <div class="profile-circle" id="profileCircle">
            <img src="photo/profile.jpg" alt="Profile Photo">
        </div>
    </div>
</div>

<div class="modal" id="modal">
    <img src="" alt="Profile Image" id="modalImg">
</div>

<div class="content">
    <h1>DASHBOARD</h1>

    <div class="cards">
        <div class="card">
            <h3>Total Users</h3>
            <p class="count" id="totalUsersCount">0</p>
        </div>
        <div class="card">
            <h3>Total Approved Events</h3>
            <p class="count" id="totalEventsCount">0</p>
        </div>
        <div class="card">
            <h3>Total Announcements</h3>
            <p class="count"><?= $totalAnnouncementsCount ?></p>
        </div>
        <div class="card">
            <h3>CO₂ Saved (kg)</h3>
            <p class="count" id="totalCO2Count">0</p>
        </div>
    </div>

    <div class="table-wrapper">
        <div class="section-title">All Events</div>
        <table>
            <thead>
                <tr>
                    <th>Events</th>
                    <th>Organizers</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="eventsTableBody">
                <tr><td colspan="4" style="text-align:center;">Loading...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="table-wrapper">
        <div class="section-title">Recent Announcements</div>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="announcementsTableBody">
                <?php if (!empty($recentAnnouncements)): ?>
                    <?php foreach ($recentAnnouncements as $item): ?>
                    <tr data-id="<?= $item['newsID'] ?>" 
                        data-type="<?= htmlspecialchars($item['news_type']) ?>"
                        data-content="<?= htmlspecialchars($item['news_content']) ?>" 
                        data-link="<?= htmlspecialchars($item['news_link']) ?>">
                        <td><?= htmlspecialchars($item['news_title']) ?></td>
                        <td><?= ucfirst(htmlspecialchars($item['news_type'])) ?></td>
                        <td><?= date('M d, Y', strtotime($item['news_created_at'])) ?></td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn view-btn view-announcement-btn">View</button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align:center;">No announcements found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="overview-modal" id="eventOverviewModal">
    <div class="overview-content">
        <div class="overview-header">
            <h2 class="overview-title">Event Overview</h2>
            <span class="close-overview" id="closeEventOverview">&times;</span>
        </div>
        
        <div class="overview-body">
            <div class="overview-grid">
                <div class="overview-field overview-full-width">
                    <div class="overview-label">Event Name</div>
                    <div class="overview-value" id="ovEventName">-</div>
                </div>
                
                <div class="overview-field">
                    <div class="overview-label">Event Type</div>
                    <div class="overview-value" id="ovEventType">-</div>
                </div>
                
                <div class="overview-field">
                    <div class="overview-label">Status</div>
                    <div class="overview-value" id="ovStatus">-</div>
                </div>
                
                <div class="overview-field">
                    <div class="overview-label">Organizer Email</div>
                    <div class="overview-value" id="ovEmail">-</div>
                </div>
                
                <div class="overview-field">
                    <div class="overview-label">Contact Number</div>
                    <div class="overview-value" id="ovContact">-</div>
                </div>
            </div>

            <h3 class="overview-section-title">📅 Date & Time</h3>
            <div class="overview-grid">
                <div class="overview-field">
                    <div class="overview-label">Start Date</div>
                    <div class="overview-value" id="ovStartDate">-</div>
                </div>
                
                <div class="overview-field">
                    <div class="overview-label">End Date</div>
                    <div class="overview-value" id="ovEndDate">-</div>
                </div>
                
                <div class="overview-field">
                    <div class="overview-label">Start Time</div>
                    <div class="overview-value" id="ovStartTime">-</div>
                </div>
                
                <div class="overview-field">
                    <div class="overview-label">End Time</div>
                    <div class="overview-value" id="ovEndTime">-</div>
                </div>
            </div>

            <h3 class="overview-section-title">📍 Location</h3>
            <div class="overview-grid">
                <div class="overview-field overview-full-width">
                    <div class="overview-label">Address</div>
                    <div class="overview-value" id="ovAddress">-</div>
                </div>
                
                <div class="overview-field">
                    <div class="overview-label">State</div>
                    <div class="overview-value" id="ovState">-</div>
                </div>
                
                <div class="overview-field">
                    <div class="overview-label">Postcode</div>
                    <div class="overview-value" id="ovPostcode">-</div>
                </div>
            </div>

            <h3 class="overview-section-title">📋 Event Details</h3>
            <div class="overview-grid">
                <div class="overview-field overview-full-width">
                    <div class="overview-label">Description</div>
                    <div class="overview-value" id="ovDescription">-</div>
                </div>
                
                <div class="overview-field">
                    <div class="overview-label">Max Participants</div>
                    <div class="overview-value" id="ovMaxParticipants">-</div>
                </div>
                
                <div class="overview-field">
                    <div class="overview-label">Registration Deadline</div>
                    <div class="overview-value" id="ovRegistrationDeadline">-</div>
                </div>
            </div>

            <h3 class="overview-section-title">🖼️ Event Image</h3>
            <div class="overview-field overview-full-width">
                <img id="ovEventImage" class="overview-image" src="" alt="Event Image" style="display:none;">
                <div id="ovNoImage" style="text-align:center; padding:40px; color:#999; display:none;">
                    No image available
                </div>
            </div>

            <h3 class="overview-section-title">ℹ️ Additional Information</h3>
            <div class="overview-grid">
                <div class="overview-field">
                    <div class="overview-label">Date Submitted</div>
                    <div class="overview-value" id="ovCreatedAt">-</div>
                </div>
                
                <div class="overview-field">
                    <div class="overview-label">Event ID</div>
                    <div class="overview-value" id="ovEventId">-</div>
                </div>
            </div>
        </div>

        <div class="overview-footer">
            <button class="overview-close-btn" id="closeEventOverviewBtn">Close</button>
        </div>
    </div>
</div>

<div class="announcement-modal" id="announcementModal">
    <div class="announcement-modal-content">
        <span class="close-announcement-modal" id="closeAnnouncementModal">&times;</span>
        
        <div class="announcement-modal-title">Announcement Details</div>

        <div class="announcement-field">
            <div class="announcement-field-label">Title:</div>
            <div class="announcement-field-value" id="annTitle" style="background: #fff; border-left: none; padding: 5px 0; font-weight: 600;">-</div>
        </div>

        <div class="announcement-field">
            <div class="announcement-field-label">Type:</div>
            <div class="announcement-field-value" id="annType" style="background: #fff; border-left: none; padding: 5px 0;">-</div>
        </div>

        <div class="announcement-field">
            <div class="announcement-field-label">Content:</div>
            <div class="announcement-field-value" id="annContent">-</div>
        </div>

        <div class="announcement-field">
            <div class="announcement-field-label">Link:</div>
            <div class="announcement-field-value" id="annLink" style="background: #fff; border-left: none; padding: 5px 0; word-break: break-all;">-</div>
        </div>

        <div class="announcement-field">
            <div class="announcement-field-label">Date Created:</div>
            <div class="announcement-field-value" id="annDate" style="background: #fff; border-left: none; padding: 5px 0;">-</div>
        </div>

        <button class="announcement-close-btn" id="closeAnnouncementBtn">Close</button>
    </div>
</div>

<div class="footer">
    © 2026 EcoVents. All rights reserved.
</div>

<script>
    let allEvents = [];
    let allAnnouncements = [];

    const profileCircle = document.getElementById('profileCircle');
    const modal = document.getElementById('modal');
    const modalImg = document.getElementById('modalImg');

    profileCircle.addEventListener('click', () => {
        modal.style.display = 'flex';
        modalImg.src = profileCircle.querySelector('img').src;
    });

    modal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-GB');
    }

    function formatTime(timeString) {
        if (!timeString) return 'N/A';
        return timeString;
    }

    function capitalizeFirst(str) {
        if (!str) return '';
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function loadStatistics() {
        fetch('get_user.php?role=All')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    animateCount('totalUsersCount', data.users.length);
                }
            })
            .catch(error => console.error('Error loading users:', error));

        fetch('get_events.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const approvedCount = data.events.filter(e => 
                        e.status && e.status.toLowerCase() === 'approved'
                    ).length;
                    animateCount('totalEventsCount', approvedCount);
                }
            })
            .catch(error => console.error('Error loading events:', error));

        animateCount('totalCO2Count', 520);
    }

    function animateCount(elementId, target) {
        const element = document.getElementById(elementId);
        let current = 0;
        const speed = target / 50;
        
        const updateCount = () => {
            if (current < target) {
                current += speed;
                element.textContent = Math.ceil(current);
                setTimeout(updateCount, 20);
            } else {
                element.textContent = target;
            }
        };
        updateCount();
    }

    function loadRecentEvents() {
        fetch('get_events.php')
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('eventsTableBody');
                
                if (data.success && data.events.length > 0) {
                    allEvents = data.events;
                    const recentEvents = data.events;
                    
                    let html = '';
                    recentEvents.forEach(event => {
                        const statusClass = event.status ? event.status.toLowerCase() : 'pending';
                        html += `
                            <tr data-event-id="${event.eventID}">
                                <td>${event.event_name}</td>
                                <td>${event.organizer_email || '-'}</td>
                                <td><span class="status-badge status-${statusClass}">${capitalizeFirst(event.status || 'Pending')}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn view-btn view-event-btn">View</button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                    tbody.innerHTML = html;
                    attachEventViewListeners();
                } else {
                    tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;">No events found</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('eventsTableBody').innerHTML = 
                    '<tr><td colspan="4" style="text-align:center;">Error loading events</td></tr>';
            });
    }

    function attachAnnouncementViewListeners() {
        document.querySelectorAll('.view-announcement-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const title = row.cells[0].textContent;
                const type = row.cells[1].textContent;
                const date = row.cells[2].textContent;
                const content = row.getAttribute('data-content');
                const link = row.getAttribute('data-link');

                document.getElementById('annTitle').textContent = title;
                document.getElementById('annType').textContent = type;
                document.getElementById('annContent').textContent = content || 'No content';
                document.getElementById('annDate').textContent = date;
                
                const linkElement = document.getElementById('annLink');
                if (link && link !== '') {
                    linkElement.innerHTML = `<a href="${link}" target="_blank" style="color: #0066cc; text-decoration: none;">${link}</a>`;
                } else {
                    linkElement.textContent = '-';
                }

                document.getElementById('announcementModal').style.display = 'flex';
            });
        });
    }

    function showEventOverview(eventId) {
        const event = allEvents.find(e => e.eventID == eventId);
        if (!event) return;

        document.getElementById('ovEventName').textContent = event.event_name || '-';
        document.getElementById('ovEventType').textContent = event.event_type || '-';
        document.getElementById('ovEmail').textContent = event.organizer_email || '-';
        document.getElementById('ovContact').textContent = event.contact_number || '-';
        
        const status = event.status || 'pending';
        const statusBadge = `<span class="status-badge status-${status.toLowerCase()}">${capitalizeFirst(status)}</span>`;
        document.getElementById('ovStatus').innerHTML = statusBadge;

        document.getElementById('ovStartDate').textContent = formatDate(event.start_date);
        document.getElementById('ovEndDate').textContent = formatDate(event.end_date);
        document.getElementById('ovStartTime').textContent = formatTime(event.start_time);
        document.getElementById('ovEndTime').textContent = formatTime(event.end_time);

        document.getElementById('ovAddress').textContent = event.address || '-';
        document.getElementById('ovState').textContent = event.state || '-';
        document.getElementById('ovPostcode').textContent = event.postcode || '-';

        document.getElementById('ovDescription').textContent = event.description || '-';
        document.getElementById('ovMaxParticipants').textContent = event.max_participants || '-';
        document.getElementById('ovRegistrationDeadline').textContent = formatDate(event.registration_deadline);

        const eventImage = document.getElementById('ovEventImage');
        const noImage = document.getElementById('ovNoImage');
        if (event.event_image) {
            eventImage.src = event.event_image;
            eventImage.style.display = 'block';
            noImage.style.display = 'none';
        } else {
            eventImage.style.display = 'none';
            noImage.style.display = 'block';
        }

        document.getElementById('ovCreatedAt').textContent = formatDate(event.created_at);
        document.getElementById('ovEventId').textContent = event.eventID || '-';

        document.getElementById('eventOverviewModal').style.display = 'flex';
    }

    function attachEventViewListeners() {
        document.querySelectorAll('.view-event-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const eventId = row.getAttribute('data-event-id');
                showEventOverview(eventId);
            });
        });
    }

    document.getElementById('closeEventOverview').addEventListener('click', function() {
        document.getElementById('eventOverviewModal').style.display = 'none';
    });

    document.getElementById('closeEventOverviewBtn').addEventListener('click', function() {
        document.getElementById('eventOverviewModal').style.display = 'none';
    });

    document.getElementById('eventOverviewModal').addEventListener('click', function(e) {
        if (e.target === document.getElementById('eventOverviewModal')) {
            document.getElementById('eventOverviewModal').style.display = 'none';
        }
    });

    document.getElementById('closeAnnouncementModal').addEventListener('click', () => {
        document.getElementById('announcementModal').style.display = 'none';
    });

    document.getElementById('closeAnnouncementBtn').addEventListener('click', () => {
        document.getElementById('announcementModal').style.display = 'none';
    });

    document.getElementById('announcementModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('announcementModal')) {
            document.getElementById('announcementModal').style.display = 'none';
        }
    });

    loadStatistics();
    loadRecentEvents();
    attachAnnouncementViewListeners();
</script>

</body>
</html>