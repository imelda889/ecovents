<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - EcoEvents</title>
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

        .tabs {
            display: flex;
            gap: 0;
            margin-bottom: 30px;
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
        }

        .show-entries {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
        }

        .show-entries select {
            padding: 8px 12px;
            margin: 0 8px;
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
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: #2c3e50;
        }

        .search-bar input {
            padding: 8px 15px;
            width: 250px;
            border: 2px solid #3498db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #2980b9;
            box-shadow: 0 0 15px rgba(52, 152, 219, 0.3);
        }

        .table-wrapper {
            background: white;
            border-radius: 15px;
            margin-bottom: 30px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(52, 152, 219, 0.2);
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
            align-items: center;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

        .view-btn {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
        }

        .view-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.4);
        }

        .add-new-btn {
            padding: 14px 35px;
            background: linear-gradient(135deg, #27ae60, #229954);
            border: none;
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        }

        .add-new-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.5);
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
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .form-label {
            width: 180px;
            font-size: 15px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #3498db;
            background-color: #fff;
            font-size: 14px;
            max-width: 380px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #2980b9;
            box-shadow: 0 0 15px rgba(52, 152, 219, 0.3);
        }

        .show-password-wrapper {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .show-password-wrapper input[type="checkbox"] {
            margin-right: 8px;
            cursor: pointer;
        }

        .show-password-wrapper label {
            font-size: 14px;
            cursor: pointer;
            font-weight: 600;
            color: #2c3e50;
        }

        .save-btn {
            padding: 12px 40px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            margin-top: 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.5);
        }

        .delete-btn {
            padding: 12px 40px;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            margin-top: 15px;
            margin-left: 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.5);
        }

        .confirm-modal {
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
            z-index: 1001;
            animation: fadeIn 0.3s ease;
        }

        .confirm-content {
            background: linear-gradient(135deg, #ecf0f1, #bdc3c7);
            width: 90%;
            max-width: 450px;
            padding: 35px;
            position: relative;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .confirm-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .confirm-message {
            font-size: 15px;
            margin-bottom: 30px;
            line-height: 1.6;
            color: #34495e;
        }

        .confirm-buttons {
            display: flex;
            gap: 15px;
        }

        .confirm-btn,
        .cancel-btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            font-size: 15px;
            font-weight: 700;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .confirm-btn {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
        }

        .confirm-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(39, 174, 96, 0.5);
        }

        .cancel-btn {
            background: linear-gradient(135deg, #95a5a6, #7f8c8d);
            color: white;
            box-shadow: 0 4px 12px rgba(127, 140, 141, 0.3);
        }

        .cancel-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(127, 140, 141, 0.5);
        }

        .close-confirm {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 28px;
            cursor: pointer;
            line-height: 1;
            color: #2c3e50;
            transition: all 0.3s ease;
        }

        .close-confirm:hover {
            color: #e74c3c;
            transform: scale(1.2);
        }

        .success-modal {
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
            animation: fadeIn 0.3s ease;
        }

        .success-content {
            background: linear-gradient(135deg, #ecf0f1, #bdc3c7);
            width: 90%;
            max-width: 450px;
            padding: 35px;
            position: relative;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .success-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #27ae60;
        }

        .success-message {
            font-size: 15px;
            margin-bottom: 30px;
            color: #34495e;
            line-height: 1.6;
        }

        .success-btn {
            width: 100%;
            padding: 12px 20px;
            border: none;
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
            cursor: pointer;
            font-size: 15px;
            font-weight: 700;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
        }

        .success-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(39, 174, 96, 0.5);
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
                font-size: 24px;
                margin-bottom: 25px;
            }

            .tabs {
                flex-direction: column;
            }

            .tab {
                width: 100%;
                padding: 12px 20px;
                text-align: center;
            }

            .controls {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
                padding: 15px;
            }

            .show-entries,
            .search-bar {
                width: 100%;
            }

            .search-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-bar input {
                width: 100%;
            }

            .table-wrapper {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            table {
                min-width: 800px;
                font-size: 12px;
            }

            th, td {
                padding: 10px 8px;
                font-size: 11px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }

            .action-btn {
                width: 100%;
                padding: 6px 10px;
                font-size: 11px;
            }

            .add-user-content {
                width: 95%;
                max-width: 95%;
                padding: 30px 20px;
                margin: 10px;
            }

            .add-user-title {
                font-size: 22px;
                margin-bottom: 25px;
            }

            .form-group {
                flex-direction: column;
                align-items: stretch;
                margin-bottom: 20px;
            }

            .form-label {
                width: 100%;
                margin-bottom: 8px;
            }

            .form-input {
                width: 100%;
                max-width: 100%;
            }

            .close-add-modal {
                font-size: 28px;
                right: 15px;
                top: 15px;
            }

            .save-btn,
            .delete-btn {
                padding: 10px 30px;
                font-size: 14px;
                width: 100%;
                margin-left: 0;
                margin-top: 10px;
            }

            .confirm-content,
            .success-content {
                width: 90%;
                padding: 25px;
            }

            .confirm-title,
            .success-title {
                font-size: 18px;
            }

            .confirm-message,
            .success-message {
                font-size: 14px;
            }

            .confirm-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .confirm-btn,
            .cancel-btn {
                width: 100%;
            }

            .add-new-btn {
                width: 100%;
                padding: 12px 25px;
                font-size: 14px;
            }

            .footer {
                padding: 15px;
                font-size: 12px;
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

            .nav {
                padding: 8px 10px;
                border-radius: 30px;
            }

            .nav a {
                margin: 3px 5px;
                font-size: 11px;
            }

            .content {
                padding: 15px;
            }

            h1 {
                font-size: 20px;
                margin-bottom: 20px;
                letter-spacing: 1px;
            }

            .tab {
                padding: 10px 15px;
                font-size: 13px;
            }

            .controls {
                padding: 12px;
            }

            .show-entries,
            .search-bar label {
                font-size: 13px;
            }

            .show-entries select,
            .search-bar input {
                padding: 6px 10px;
                font-size: 13px;
            }

            table {
                min-width: 700px;
                font-size: 11px;
            }

            th, td {
                padding: 8px 6px;
                font-size: 10px;
            }

            .add-user-content {
                padding: 25px 15px;
            }

            .add-user-title {
                font-size: 20px;
                margin-bottom: 20px;
            }

            .form-label {
                font-size: 14px;
            }

            .form-input {
                padding: 10px 12px;
                font-size: 13px;
            }

            .save-btn,
            .delete-btn {
                padding: 10px 25px;
                font-size: 13px;
            }

            .show-password-wrapper label {
                font-size: 13px;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
            .nav a {
                margin: 0 8px;
                font-size: 13px;
            }

            .content {
                padding: 30px;
            }

            .tabs {
                flex-direction: row;
            }

            .tab {
                flex: 1;
            }

            table {
                font-size: 13px;
            }

            th, td {
                padding: 12px 10px;
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
            <a href="manage-user.php" class="active">Manage User Account</a>
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

    <div class="add-user-modal" id="addUserModal">
        <div class="add-user-content">
            <span class="close-add-modal" id="closeAddModal">&times;</span>
            
            <div class="add-user-title">Add New Admin</div>

            <form id="addUserForm">
                <div class="form-group">
                    <label class="form-label">Name(required)</label>
                    <input type="text" class="form-input" id="userName" name="name" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email(required)</label>
                    <input type="email" class="form-input" id="userEmail" name="email" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div style="flex: 1; max-width: 380px;">
                        <input type="password" class="form-input" id="userPassword" name="password" required style="width: 100%; max-width: none;">
                        <div class="show-password-wrapper">
                            <input type="checkbox" id="showPasswordAdd">
                            <label for="showPasswordAdd">Show Password</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-input" id="confirmPassword" required>
                </div>

                <div class="form-group">
                    <label class="form-label"></label>
                    <button type="submit" class="save-btn">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="add-user-modal" id="settingsUserModal">
        <div class="add-user-content">
            <span class="close-add-modal" id="closeSettingsModal">&times;</span>
            
            <div class="add-user-title">Edit User Account</div>

            <form id="settingsUserForm">
                <input type="hidden" id="userIdSettings" name="user_id">
                
                <div class="form-group">
                    <label class="form-label">Name(required)</label>
                    <input type="text" class="form-input" id="userNameSettings" name="name" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email(required)</label>
                    <input type="email" class="form-input" id="userEmailSettings" name="email" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div style="flex: 1; max-width: 380px;">
                        <input type="password" class="form-input" id="userPasswordSettings" name="password" required style="width: 100%; max-width: none;">
                        <div class="show-password-wrapper">
                            <input type="checkbox" id="showPasswordSettings">
                            <label for="showPasswordSettings">Show Password</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-input" id="confirmPasswordSettings" required>
                </div>

                <div class="form-group">
                    <label class="form-label"></label>
                    <button type="submit" class="save-btn">Save Changes</button>
                </div>
            </form>
        </div>
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
                    <label class="form-label">Profile Image:</label>
                    <div style="flex: 1; max-width: 380px; font-weight: 600; color: #2c3e50;" id="viewProfileImage">-</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Event ID:</label>
                    <div style="flex: 1; max-width: 380px; font-weight: 600; color: #2c3e50;" id="viewEventId">-</div>
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

    <div class="confirm-modal" id="confirmModal">
        <div class="confirm-content">
            <span class="close-confirm" id="closeConfirm">&times;</span>
            <div class="confirm-title" id="confirmTitle">Confirm Account Creation</div>
            <div class="confirm-message" id="confirmMessage">
                Are you sure you want to create this account?
            </div>
            <div class="confirm-buttons">
                <button class="confirm-btn" id="confirmYes">Yes</button>
                <button class="cancel-btn" id="confirmNo">Cancel</button>
            </div>
        </div>
    </div>

    <div class="success-modal" id="successModal">
        <div class="success-content">
            <span class="close-confirm" id="closeSuccess">&times;</span>
            <div class="success-title" id="successTitle">Account Created</div>
            <div class="success-message" id="successMessage">
                Your admin account has been successfully created. Welcome!
            </div>
            <button class="success-btn" id="goBackToDashboard">OK</button>
        </div>
    </div>

    <div class="content">
        <h1>MANAGE USER ACCOUNT</h1>

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

        <button class="add-new-btn">+ Add New</button>
    </div>

    <div class="footer">
        © 2026 EcoVents. All rights reserved.
    </div>

    <script>
    let currentRole = 'All';
    let currentPage = 1;
    let entriesPerPage = 10;
    let allUsers = [];

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
                    displayUsers();
                } else {
                    tableBody.innerHTML = '<tr><td colspan="9" style="text-align:center;">No users found</td></tr>';
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
                                <button class="action-btn edit-btn" data-action="edit">Edit</button>
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
                document.getElementById('viewProfileImage').textContent = '-';
                document.getElementById('viewEventId').textContent = '-';
                document.getElementById('viewEventName').textContent = eventName;
                
                document.getElementById('viewUserModal').style.display = 'flex';
            });
        });

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const userId = row.cells[1].textContent;
                const userName = row.cells[2].textContent;
                const userEmail = row.cells[3].textContent;
                const userPassword = row.cells[4].textContent;
                
                document.getElementById('userIdSettings').value = userId;
                document.getElementById('userNameSettings').value = userName;
                document.getElementById('userEmailSettings').value = userEmail;
                document.getElementById('userPasswordSettings').value = userPassword;
                document.getElementById('confirmPasswordSettings').value = userPassword;
                
                document.getElementById('showPasswordSettings').checked = false;
                document.getElementById('userPasswordSettings').type = 'password';
                document.getElementById('confirmPasswordSettings').type = 'password';
                
                document.getElementById('settingsUserModal').style.display = 'flex';
            });
        });

        document.querySelectorAll('.delete-btn-table').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const userId = row.cells[1].textContent;
                const userName = row.cells[2].textContent;
                
                document.getElementById('userIdSettings').value = userId;
                
                document.getElementById('confirmTitle').textContent = 'Confirm Account Delete';
                document.getElementById('confirmMessage').textContent = `Are you sure you want to delete "${userName}"? This action cannot be undone!`;
                document.getElementById('confirmModal').style.display = 'flex';
                
                window.pendingUserData = { type: 'delete' };
            });
        });
    }

    const addNewBtn = document.querySelector('.add-new-btn');
    addNewBtn.addEventListener('click', function() {
        if (currentRole === 'All') {
            alert('Please select a specific role tab (Admin, Participant, or Organizer) to add a new user.');
            return;
        }
        document.querySelector('.add-user-title').textContent = 'Add New ' + currentRole;
        document.getElementById('addUserModal').style.display = 'flex';
    });

    document.getElementById('closeAddModal').addEventListener('click', () => {
        document.getElementById('addUserModal').style.display = 'none';
        document.getElementById('addUserForm').reset();
    });

    document.getElementById('closeViewModal').addEventListener('click', () => {
        document.getElementById('viewUserModal').style.display = 'none';
    });

    document.getElementById('closeViewBtn').addEventListener('click', () => {
        document.getElementById('viewUserModal').style.display = 'none';
    });

    document.getElementById('closeSettingsModal').addEventListener('click', () => {
        document.getElementById('settingsUserModal').style.display = 'none';
        document.getElementById('settingsUserForm').reset();
    });

    document.getElementById('showPasswordSettings').addEventListener('change', function() {
        const passwordField = document.getElementById('userPasswordSettings');
        const confirmPasswordField = document.getElementById('confirmPasswordSettings');
        passwordField.type = this.checked ? 'text' : 'password';
        confirmPasswordField.type = this.checked ? 'text' : 'password';
    });

    document.getElementById('showPasswordAdd').addEventListener('change', function() {
        const passwordField = document.getElementById('userPassword');
        const confirmPasswordField = document.getElementById('confirmPassword');
        passwordField.type = this.checked ? 'text' : 'password';
        confirmPasswordField.type = this.checked ? 'text' : 'password';
    });

    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const name = document.getElementById('userName').value;
        const email = document.getElementById('userEmail').value;
        const password = document.getElementById('userPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        if (password !== confirmPassword) {
            alert('Passwords do not match!');
            return;
        }
        
        const formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('role', currentRole);
        
        fetch('add_user.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('addUserModal').style.display = 'none';
                document.getElementById('addUserForm').reset();
                document.getElementById('successTitle').textContent = 'User Added';
                document.getElementById('successMessage').textContent = 'New user account has been successfully created!';
                document.getElementById('successModal').style.display = 'flex';
            } else {
                alert('Error: ' + (data.error || 'Unknown error occurred'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to add user. Please try again.');
        });
    });

    document.getElementById('settingsUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const userId = document.getElementById('userIdSettings').value;
        const name = document.getElementById('userNameSettings').value;
        const email = document.getElementById('userEmailSettings').value;
        const password = document.getElementById('userPasswordSettings').value;
        const confirmPassword = document.getElementById('confirmPasswordSettings').value;
        
        if (password !== confirmPassword) {
            alert('Passwords do not match!');
            return;
        }
        
        const formData = new FormData();
        formData.append('user_id', userId);
        formData.append('name', name);
        formData.append('email', email);
        formData.append('password', password);
        
        fetch('update_user.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('settingsUserModal').style.display = 'none';
                document.getElementById('settingsUserForm').reset();
                document.getElementById('successTitle').textContent = 'User Updated';
                document.getElementById('successMessage').textContent = 'User account has been successfully updated!';
                document.getElementById('successModal').style.display = 'flex';
            } else {
                alert('Error: ' + (data.error || 'Unknown error occurred'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update user. Please try again.');
        });
    });

    document.getElementById('confirmNo').addEventListener('click', () => {
        document.getElementById('confirmModal').style.display = 'none';
        window.pendingUserData = null;
    });

    document.getElementById('closeConfirm').addEventListener('click', () => {
        document.getElementById('confirmModal').style.display = 'none';
        window.pendingUserData = null;
    });

    document.getElementById('confirmYes').addEventListener('click', function() {
        if (window.pendingUserData && window.pendingUserData.type === 'delete') {
            const userId = document.getElementById('userIdSettings').value;
            
            const formData = new FormData();
            formData.append('user_id', userId);
            
            fetch('delete_user.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('confirmModal').style.display = 'none';
                    document.getElementById('successTitle').textContent = 'User Deleted';
                    document.getElementById('successMessage').textContent = 'User account has been successfully deleted!';
                    document.getElementById('successModal').style.display = 'flex';
                    window.pendingUserData = null;
                } else {
                    alert('Error: ' + (data.error || 'Unknown error occurred'));
                    document.getElementById('confirmModal').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete user. Please try again.');
                document.getElementById('confirmModal').style.display = 'none';
            });
        }
    });

    document.getElementById('goBackToDashboard').addEventListener('click', () => {
        document.getElementById('successModal').style.display = 'none';
        loadUsers(currentRole);
    });

    document.getElementById('closeSuccess').addEventListener('click', () => {
        document.getElementById('successModal').style.display = 'none';
        loadUsers(currentRole);
    });

    document.getElementById('addUserModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('addUserModal')) {
            document.getElementById('addUserModal').style.display = 'none';
            document.getElementById('addUserForm').reset();
        }
    });

    document.getElementById('settingsUserModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('settingsUserModal')) {
            document.getElementById('settingsUserModal').style.display = 'none';
            document.getElementById('settingsUserForm').reset();
        }
    });

    document.getElementById('viewUserModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('viewUserModal')) {
            document.getElementById('viewUserModal').style.display = 'none';
        }
    });

    document.getElementById('confirmModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('confirmModal')) {
            document.getElementById('confirmModal').style.display = 'none';
            window.pendingUserData = null;
        }
    });

    document.getElementById('successModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('successModal')) {
            document.getElementById('successModal').style.display = 'none';
            loadUsers(currentRole);
        }
    });

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
                                    <button class="action-btn edit-btn" data-action="edit">Edit</button>
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

    loadUsers('All');
    </script>

</body>
</html>