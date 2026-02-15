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

$stmt = $pdo->query("SELECT * FROM news ORDER BY news_created_at DESC");
$newsItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Database & Records - EcoEvents</title>
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
        background: transparent;
        flex: 1;
        width: 100%;
        box-sizing: border-box;
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

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.85));
        backdrop-filter: blur(10px);
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        text-align: center;
        border: 1px solid rgba(52, 152, 219, 0.2);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
    }

    .stat-card h3 {
        margin: 0 0 15px 0;
        font-size: 15px;
        font-weight: 600;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-card .count {
        font-size: 42px;
        font-weight: 800;
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.85));
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        overflow: hidden;
        border: 1px solid rgba(52, 152, 219, 0.2);
    }

    .section-header {
        padding: 25px 30px;
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(41, 128, 185, 0.1));
        border-bottom: 2px solid rgba(52, 152, 219, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-header h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #2c3e50;
        letter-spacing: 0.5px;
    }

    .add-btn {
        background: linear-gradient(135deg, #27ae60, #229954);
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
    }

    .add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(39, 174, 96, 0.5);
    }

    .tabs {
        display: flex;
        gap: 0;
        margin-bottom: 25px;
        flex-wrap: wrap;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .tab {
        padding: 14px 30px;
        background: linear-gradient(135deg, #7f8c8d, #95a5a6);
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        transition: all 0.3s ease;
        flex: 1;
    }

    .tab:hover {
        background: linear-gradient(135deg, #34495e, #2c3e50);
        transform: translateY(-2px);
    }

    .tab.active {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: #fff;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
    }

    .controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding: 20px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7));
        border: 1px solid rgba(52, 152, 219, 0.2);
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        flex-wrap: wrap;
        gap: 15px;
    }

    .show-entries {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
    }

    .show-entries select {
        padding: 8px 12px;
        border: 2px solid #3498db;
        border-radius: 8px;
        background: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .show-entries select:hover {
        border-color: #2980b9;
        box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
    }

    .search-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
    }

    .search-bar input {
        padding: 8px 15px;
        border: 2px solid #3498db;
        border-radius: 8px;
        font-size: 14px;
        width: 250px;
        transition: all 0.3s ease;
    }

    .search-bar input:focus {
        outline: none;
        border-color: #2980b9;
        box-shadow: 0 0 15px rgba(52, 152, 219, 0.3);
    }

    .table-wrapper {
        overflow-x: auto;
        background: white;
        border-radius: 15px;
        border: 1px solid rgba(52, 152, 219, 0.2);
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(41, 128, 185, 0.1));
        padding: 16px;
        text-align: left;
        font-size: 13px;
        font-weight: 700;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid rgba(52, 152, 219, 0.3);
    }

    td {
        padding: 16px;
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
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .view-btn {
        background: linear-gradient(135deg, #27ae60, #229954);
        color: white;
    }

    .view-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(39, 174, 96, 0.4);
    }

    .edit-btn {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
    }

    .edit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.4);
    }

    .delete-btn-table {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
    }

    .delete-btn-table:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
    }

    .add-user-modal {
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
        overflow-y: auto;
        padding: 20px;
        animation: fadeIn 0.3s ease;
    }

    .add-user-content {
        background: linear-gradient(135deg, #ecf0f1, #bdc3c7);
        width: 90%;
        max-width: 650px;
        padding: 40px;
        position: relative;
        margin: 20px auto;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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

    .close-add-modal {
        position: absolute;
        top: 15px;
        right: 25px;
        font-size: 32px;
        cursor: pointer;
        font-weight: 300;
        color: #2c3e50;
        line-height: 1;
        transition: all 0.3s ease;
    }

    .close-add-modal:hover {
        color: #e74c3c;
        transform: scale(1.2) rotate(90deg);
    }

    .add-user-title {
        font-size: 26px;
        font-weight: 800;
        margin-bottom: 35px;
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .form-group {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
        gap: 15px;
    }

    .form-label {
        min-width: 150px;
        font-weight: 600;
        padding-top: 8px;
        color: #2c3e50;
        font-size: 15px;
    }

    .save-btn {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        border: none;
        padding: 12px 40px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    }

    .save-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.5);
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
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        animation: slideUp 0.4s ease;
    }

    .overview-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px 30px;
        border-radius: 20px 20px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .overview-title {
        font-size: 26px;
        font-weight: bold;
        margin: 0;
    }

    .close-overview {
        font-size: 32px;
        cursor: pointer;
        color: white;
        line-height: 1;
        transition: all 0.3s ease;
    }

    .close-overview:hover {
        transform: scale(1.2) rotate(90deg);
    }

    .overview-body {
        padding: 30px;
    }

    .overview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 25px;
    }

    .overview-field {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }

    .overview-field:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .overview-label {
        font-weight: 600;
        color: #495057;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .overview-value {
        font-size: 16px;
        color: #212529;
        word-wrap: break-word;
        line-height: 1.6;
        font-weight: 500;
    }

    .overview-full-width {
        grid-column: 1 / -1;
    }

    .overview-section-title {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin: 30px 0 20px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
    }

    .overview-image {
        width: 100%;
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin-top: 10px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .overview-footer {
        padding: 20px 30px;
        background: #f8f9fa;
        border-radius: 0 0 20px 20px;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .overview-close-btn {
        padding: 12px 30px;
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }

    .overview-close-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(108, 117, 125, 0.5);
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-badge.pending {
        background: linear-gradient(135deg, #f39c12, #e67e22);
        color: white;
    }

    .status-badge.approved {
        background: linear-gradient(135deg, #27ae60, #229954);
        color: white;
    }

    .status-badge.rejected {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
    }

    .footer {
        padding: 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        text-align: center;
        font-size: 13px;
        color: #7f8c8d;
        font-weight: 600;
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

    @media (max-width: 1200px) {
        .content {
            padding: 30px;
        }

        .nav a {
            margin: 0 10px;
            font-size: 13px;
        }
    }

    @media (max-width: 900px) {
        .header {
            flex-wrap: wrap;
            gap: 15px;
        }

        .nav {
            order: 3;
            width: 100%;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 10px 15px;
        }

        .nav a {
            margin: 5px 8px;
            font-size: 12px;
        }

        .content {
            padding: 20px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 30px;
        }

        .stats-cards {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .tabs {
            flex-direction: column;
        }

        .tab {
            width: 100%;
            text-align: center;
        }

        .controls {
            flex-direction: column;
            align-items: stretch;
        }

        .search-bar input {
            width: 100%;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            min-width: 800px;
            font-size: 12px;
        }

        th, td {
            padding: 12px 10px;
        }

        .overview-content {
            width: 95%;
        }

        .overview-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .header {
            padding: 10px 15px;
        }

        .logo img {
            height: 40px;
        }

        .profile-circle {
            width: 35px;
            height: 35px;
            border-width: 2px;
        }

        .content {
            padding: 15px;
        }

        h1 {
            font-size: 24px;
            letter-spacing: 1px;
        }

        .stats-cards {
            grid-template-columns: 1fr;
        }

        .stat-card {
            padding: 25px;
        }

        .stat-card .count {
            font-size: 36px;
        }

        .section-header h2 {
            font-size: 18px;
        }

        .add-btn {
            padding: 10px 20px;
            font-size: 13px;
        }

        .add-user-content {
            padding: 25px 15px;
        }

        .form-group {
            flex-direction: column;
            align-items: stretch;
        }

        .form-label {
            min-width: auto;
            margin-bottom: 8px;
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
        <a href="mainpage.php">Dashboard</a>
        <a href="manage-user.php">Manage User Account</a>
        <a href="approve-reject.php">Approve / Reject</a>
        <a href="database-record.php" class="active">Database & Records</a>
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

<div class="add-user-modal" id="viewUserModal">
    <div class="add-user-content">
        <span class="close-add-modal" id="closeViewModal">&times;</span>
        
        <div class="add-user-title">View User Account</div>

        <div style="padding: 20px 0;">
            <div class="form-group">
                <label class="form-label">User ID:</label>
                <div style="flex: 1; max-width: 380px; font-weight: 600; color: #2c3e50;" id="viewUserId">-</div>
            </div>

            <div class="form-group">
                <label class="form-label">Name:</label>
                <div style="flex: 1; max-width: 380px; font-weight: 600; color: #2c3e50;" id="viewUserName">-</div>
            </div>

            <div class="form-group">
                <label class="form-label">Email:</label>
                <div style="flex: 1; max-width: 380px; font-weight: 600; color: #2c3e50;" id="viewUserEmail">-</div>
            </div>

            <div class="form-group">
                <label class="form-label">Password:</label>
                <div style="flex: 1; max-width: 380px; font-weight: 600; color: #2c3e50;" id="viewUserPassword">-</div>
            </div>

            <div class="form-group">
                <label class="form-label">Role:</label>
                <div style="flex: 1; max-width: 380px; font-weight: 600; color: #2c3e50;" id="viewUserRole">-</div>
            </div>

            <div class="form-group">
                <label class="form-label">Google ID:</label>
                <div style="flex: 1; max-width: 380px; font-weight: 600; color: #2c3e50;" id="viewGoogleId">-</div>
            </div>

            <div class="form-group">
                <label class="form-label">Event Name:</label>
                <div style="flex: 1; max-width: 380px; font-weight: 600; color: #2c3e50;" id="viewEventName">-</div>
            </div>

            <div class="form-group">
                <label class="form-label"></label>
                <button class="save-btn" id="closeViewBtn">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="add-user-modal" id="viewAnnouncementModal">
    <div class="add-user-content">
        <span class="close-add-modal" id="closeAnnouncementModal">&times;</span>
        
        <div class="add-user-title">View Announcement</div>

        <div style="padding: 20px 0;">
            <div class="form-group">
                <label class="form-label">Title:</label>
                <div style="flex: 1; max-width: 380px; font-weight: 600; color: #2c3e50;" id="viewAnnTitle">-</div>
            </div>

            <div class="form-group">
                <label class="form-label">Type:</label>
                <div style="flex: 1; max-width: 380px; font-weight: 600; color: #2c3e50;" id="viewAnnType">-</div>
            </div>

            <div class="form-group">
                <label class="form-label">Content:</label>
                <div style="flex: 1; max-width: 380px; font-weight: 400; line-height: 1.6; color: #34495e;" id="viewAnnContent">-</div>
            </div>

            <div class="form-group">
                <label class="form-label">Link:</label>
                <div style="flex: 1; max-width: 380px; font-weight: 400; word-break: break-all; color: #34495e;" id="viewAnnLink">-</div>
            </div>

            <div class="form-group">
                <label class="form-label">Created:</label>
                <div style="flex: 1; max-width: 380px; font-weight: 600; color: #2c3e50;" id="viewAnnDate">-</div>
            </div>

            <div class="form-group">
                <label class="form-label"></label>
                <button class="save-btn" id="closeAnnouncementBtn">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <h1>DATABASE & RECORDS</h1>

    <div class="stats-cards">
        <div class="stat-card">
            <h3>Total Users</h3>
            <div class="count" id="totalUsers">0</div>
        </div>
        <div class="stat-card">
            <h3>Total Approved Events</h3>
            <div class="count" id="totalEvents">0</div>
        </div>
        <div class="stat-card">
            <h3>Total CO2 Saved</h3>
            <div class="count">0 kg</div>
        </div>
        <div class="stat-card">
            <h3>Total Trees Planted</h3>
            <div class="count">0</div>
        </div>
    </div>

    <div class="section">
        <div class="section-header">
            <h2>All Users</h2>
            <button class="add-btn" onclick="window.location.href='manage-user.php'">Add User</button>
        </div>
        
        <div style="padding: 25px;">
            <div class="tabs">
                <button class="tab active" data-tab="All">All Users</button>
                <button class="tab" data-tab="Admin">Admin</button>
                <button class="tab" data-tab="Participant">Participants</button>
                <button class="tab" data-tab="Organizer">Organizers</button>
            </div>

            <div class="controls">
                <div class="show-entries">
                    Show 
                    <select id="entriesSelect">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> 
                    entries
                </div>
                <div class="search-bar">
                    <label>Search:</label>
                    <input type="text" id="searchInput" placeholder="Search users...">
                </div>
            </div>

            <div class="table-wrapper">
                <table id="userTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Google ID</th>
                            <th>Event Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr><td colspan="9" style="text-align:center;">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-header">
            <h2>Events Overview</h2>
            <button class="add-btn">Add Event</button>
        </div>
        <div style="padding: 25px;">
            <div class="table-wrapper">
                <table id="eventsTable">
                    <thead>
                        <tr>
                            <th>Event ID</th>
                            <th>Title</th>
                            <th>Organizer</th>
                            <th>Date</th>
                            <th>Participants</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="eventsTableBody">
                        <tr><td colspan="8" style="text-align:center;">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-header">
            <h2>News & Announcements</h2>
            <button class="add-btn" onclick="window.location.href='announcements.php'">Add</button>
        </div>
        <div style="padding: 25px;">
            <div class="controls" style="margin-bottom: 15px;">
                <div class="search-bar">
                    <label>Search:</label>
                    <input type="text" id="announcementSearchInput" placeholder="Search announcements...">
                </div>
                <div class="show-entries">
                    <label>Filter by Type:</label>
                    <select id="announcementTypeFilter">
                        <option value="">All Types</option>
                        <option value="announcement">Announcement</option>
                        <option value="news">News</option>
                        <option value="tips">Tips</option>
                    </select>
                </div>
            </div>
            
            <div class="table-wrapper">
                <table id="announcementsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Content</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="announcementsTableBody">
                        <?php if (!empty($newsItems)): ?>
                            <?php foreach ($newsItems as $item): ?>
                            <tr data-id="<?= $item['newsID'] ?>" 
                                data-type="<?= htmlspecialchars($item['news_type']) ?>"
                                data-content="<?= htmlspecialchars($item['news_content']) ?>" 
                                data-link="<?= htmlspecialchars($item['news_link']) ?>">
                                <td><?= $item['newsID'] ?></td>
                                <td><?= htmlspecialchars($item['news_title']) ?></td>
                                <td><?= ucfirst(htmlspecialchars($item['news_type'])) ?></td>
                                <td><?= htmlspecialchars(substr($item['news_content'], 0, 50)) ?>...</td>
                                <td><?= date('M d, Y', strtotime($item['news_created_at'])) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn view-btn view-announcement-btn">View</button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" style="text-align:center;">No announcements found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
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

<div class="footer">
    © 2026 EcoVents. All rights reserved.
</div>

<script>
    let currentRole = 'All';
    let currentPage = 1;
    let entriesPerPage = 10;
    let allUsers = [];
    let allEvents = [];
    
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

    function loadUsers(role) {
        currentRole = role;
        const tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = '<tr><td colspan="9" style="text-align:center;">Loading...</td></tr>';
        
        const url = role === 'All' ? 'get_user.php?role=All' : 'get_user.php?role=' + encodeURIComponent(role);
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.users.length > 0) {
                    allUsers = data.users;
                    currentPage = 1;
                    
                    document.getElementById('totalUsers').textContent = allUsers.length;
                    
                    displayUsers();
                } else {
                    tableBody.innerHTML = '<tr><td colspan="9" style="text-align:center;">No users found</td></tr>';
                    document.getElementById('totalUsers').textContent = '0';
                    allUsers = [];
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tableBody.innerHTML = '<tr><td colspan="9" style="text-align:center;">Error loading data</td></tr>';
                allUsers = [];
            });
    }

    function displayUsers() {
        const tableBody = document.getElementById('tableBody');
        const startIndex = (currentPage - 1) * entriesPerPage;
        const endIndex = startIndex + entriesPerPage;
        const usersToDisplay = allUsers.slice(startIndex, endIndex);
        
        if (usersToDisplay.length > 0) {
            let html = '';
            usersToDisplay.forEach((user, index) => {
                html += `
                    <tr data-user-id="${user.user_id}">
                        <td>${startIndex + index + 1}</td>
                        <td>${user.user_id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.password}</td>
                        <td>${user.role}</td>
                        <td>${user.google_id || '-'}</td>
                        <td>${user.event_name || '-'}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn view-btn" data-action="view">View</button>
                                <button class="action-btn edit-btn" data-action="edit" onclick="window.location.href='manage-user.php'">Edit</button>
                                <button class="action-btn delete-btn-table" data-action="delete">Delete</button>
                            </div>
                        </td>
                    </tr>
                `;
            });
            tableBody.innerHTML = html;
            attachActionListeners();
        } else {
            tableBody.innerHTML = '<tr><td colspan="9" style="text-align:center;">No users found</td></tr>';
        }
    }

    document.getElementById('entriesSelect').addEventListener('change', function() {
        entriesPerPage = parseInt(this.value);
        currentPage = 1;
        displayUsers();
    });

    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const tabName = this.getAttribute('data-tab');
            loadUsers(tabName);
        });
    });

    function attachActionListeners() {
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const userId = row.cells[1].textContent;
                const userName = row.cells[2].textContent;
                const userEmail = row.cells[3].textContent;
                const userPassword = row.cells[4].textContent;
                const userRole = row.cells[5].textContent;
                const googleId = row.cells[6].textContent;
                const eventName = row.cells[7].textContent;
                
                document.getElementById('viewUserId').textContent = userId;
                document.getElementById('viewUserName').textContent = userName;
                document.getElementById('viewUserEmail').textContent = userEmail;
                document.getElementById('viewUserPassword').textContent = userPassword;
                document.getElementById('viewUserRole').textContent = userRole;
                document.getElementById('viewGoogleId').textContent = googleId;
                document.getElementById('viewEventName').textContent = eventName;
                
                document.getElementById('viewUserModal').style.display = 'flex';
            });
        });
    }

    document.getElementById('closeViewModal').addEventListener('click', () => {
        document.getElementById('viewUserModal').style.display = 'none';
    });

    document.getElementById('closeViewBtn').addEventListener('click', () => {
        document.getElementById('viewUserModal').style.display = 'none';
    });

    document.getElementById('viewUserModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('viewUserModal')) {
            document.getElementById('viewUserModal').style.display = 'none';
        }
    });

    document.querySelectorAll('.view-announcement-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const title = row.cells[1].textContent;
            const type = row.cells[2].textContent;
            const content = row.dataset.content;
            const link = row.dataset.link;
            const date = row.cells[4].textContent;
            
            document.getElementById('viewAnnTitle').textContent = title;
            document.getElementById('viewAnnType').textContent = type;
            document.getElementById('viewAnnContent').textContent = content;
            
            const linkElement = document.getElementById('viewAnnLink');
            if (link && link !== '') {
                linkElement.innerHTML = `<a href="${link}" target="_blank" style="color: #3498db; text-decoration: none; font-weight: 600;">${link}</a>`;
            } else {
                linkElement.textContent = '-';
            }
            
            document.getElementById('viewAnnDate').textContent = date;
            
            document.getElementById('viewAnnouncementModal').style.display = 'flex';
        });
    });

    document.getElementById('closeAnnouncementModal').addEventListener('click', () => {
        document.getElementById('viewAnnouncementModal').style.display = 'none';
    });

    document.getElementById('closeAnnouncementBtn').addEventListener('click', () => {
        document.getElementById('viewAnnouncementModal').style.display = 'none';
    });

    document.getElementById('viewAnnouncementModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('viewAnnouncementModal')) {
            document.getElementById('viewAnnouncementModal').style.display = 'none';
        }
    });

    document.getElementById('announcementSearchInput').addEventListener('keyup', function() {
        filterAnnouncements();
    });

    document.getElementById('announcementTypeFilter').addEventListener('change', function() {
        filterAnnouncements();
    });

    function filterAnnouncements() {
        const searchValue = document.getElementById('announcementSearchInput').value.toLowerCase();
        const typeFilter = document.getElementById('announcementTypeFilter').value.toLowerCase();
        const rows = document.querySelectorAll('#announcementsTableBody tr');

        rows.forEach(row => {
            if (row.cells.length <= 1) return; 

            const title = row.cells[1].textContent.toLowerCase();
            const type = row.dataset.type ? row.dataset.type.toLowerCase() : '';
            const content = row.dataset.content ? row.dataset.content.toLowerCase() : '';
            
            const matchesSearch = title.includes(searchValue) || content.includes(searchValue);
            const matchesType = !typeFilter || type === typeFilter;

            if (matchesSearch && matchesType) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        
        if (filter === '') {
            displayUsers();
        } else {
            const tableBody = document.getElementById('tableBody');
            const filteredUsers = allUsers.filter(user => {
                return user.user_id.toString().toLowerCase().includes(filter) ||
                       user.name.toLowerCase().includes(filter) ||
                       user.email.toLowerCase().includes(filter) ||
                       user.role.toLowerCase().includes(filter) ||
                       (user.google_id && user.google_id.toLowerCase().includes(filter)) ||
                       (user.event_name && user.event_name.toLowerCase().includes(filter));
            });
            
            if (filteredUsers.length > 0) {
                let html = '';
                filteredUsers.forEach((user, index) => {
                    html += `
                        <tr data-user-id="${user.user_id}">
                            <td>${index + 1}</td>
                            <td>${user.user_id}</td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.password}</td>
                            <td>${user.role}</td>
                            <td>${user.google_id || '-'}</td>
                            <td>${user.event_name || '-'}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn view-btn" data-action="view">View</button>
                                    <button class="action-btn edit-btn" data-action="edit" onclick="window.location.href='manage-user.php'">Edit</button>
                                    <button class="action-btn delete-btn-table" data-action="delete">Delete</button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                tableBody.innerHTML = html;
                attachActionListeners();
            } else {
                tableBody.innerHTML = '<tr><td colspan="9" style="text-align:center;">No matching users found</td></tr>';
            }
        }
    });

    function loadEvents() {
        fetch('get_events.php')
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('eventsTableBody');

                if (data.success && data.events.length > 0) {
                    allEvents = data.events;
                    
                    const approvedEventsCount = data.events.filter(event => 
                        event.status && event.status.toLowerCase() === 'approved'
                    ).length;
                    
                    const totalEventsCard = document.querySelectorAll('.stat-card')[1];
                    if (totalEventsCard) {
                        totalEventsCard.querySelector('.count').textContent = approvedEventsCount;
                    }
                    
                    let html = '';
                    data.events.forEach(event => {
                        const statusClass = 'status-' + (event.status || 'pending').toLowerCase();
                        html += `
                            <tr data-event-id="${event.eventID}">
                                <td>${event.eventID}</td>
                                <td>${event.event_name}</td>
                                <td>${event.organizer_email || '-'}</td>
                                <td>${formatDate(event.start_date)}</td>
                                <td>${event.max_participants || 0}</td>
                                <td class="${statusClass}">${capitalizeFirst(event.status || 'pending')}</td>
                                <td>${event.address || '-'}</td>
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
                    tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;">No events found</td></tr>';
                    
                    const totalEventsCard = document.querySelectorAll('.stat-card')[1];
                    if (totalEventsCard) {
                        totalEventsCard.querySelector('.count').textContent = '0';
                    }
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('eventsTableBody').innerHTML = 
                    '<tr><td colspan="8" style="text-align:center;">Error loading events</td></tr>';
            });
    }

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

    function showEventOverview(eventId) {
        const event = allEvents.find(e => e.eventID == eventId);
        if (!event) return;

        document.getElementById('ovEventName').textContent = event.event_name || '-';
        document.getElementById('ovEventType').textContent = event.event_type || '-';
        document.getElementById('ovEmail').textContent = event.organizer_email || '-';
        document.getElementById('ovContact').textContent = event.contact_number || '-';
        
        const status = event.status || 'pending';
        const statusBadge = `<span class="status-badge ${status}">${capitalizeFirst(status)}</span>`;
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

    loadUsers('All');
    loadEvents();
</script>

</body>
</html>