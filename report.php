<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report - EcoEvents</title>
    <link rel="icon" href="../imagessssss/LOGO.png" type="image/png" sizes="280x280">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    
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
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo img {
            height: 50px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 3px 8px rgba(0, 0, 0, 0.15));
        }

        .nav {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.85));
            padding: 12px 25px;
            border-radius: 50px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.7);
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
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.5);
        }

        .profile-circle:hover {
            transform: scale(1.15) rotate(5deg);
            box-shadow: 0 6px 25px rgba(52, 152, 219, 0.7);
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
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(10px);
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
            border-radius: 20px;
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.7);
        }

        .content {
            padding: 50px 40px;
            background: transparent;
            flex: 1;
            width: 100%;
            box-sizing: border-box;
        }

        .page-title {
            margin-bottom: 50px;
            letter-spacing: 4px;
            font-size: 42px;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 900;
            text-align: center;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.1));
            animation: titleSlide 0.8s ease;
        }

        @keyframes titleSlide {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(255, 255, 255, 0.92));
            backdrop-filter: blur(20px);
            padding: 40px 35px;
            border-radius: 25px;
            box-shadow: 0 15px 60px rgba(0, 0, 0, 0.12);
            text-align: center;
            border: 1px solid rgba(52, 152, 219, 0.3);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #3498db, #2980b9, #3498db);
            background-size: 200% 100%;
            animation: shimmer 3s ease infinite;
        }

        @keyframes shimmer {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .stat-card:hover {
            transform: translateY(-12px) scale(1.03);
            box-shadow: 0 25px 80px rgba(52, 152, 219, 0.35);
        }

        .stat-icon {
            font-size: 56px;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 12px rgba(52, 152, 219, 0.3));
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .stat-label {
            font-size: 13px;
            font-weight: 700;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 18px;
        }

        .stat-value {
            font-size: 52px;
            font-weight: 900;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.1;
            text-shadow: 0 4px 20px rgba(52, 152, 219, 0.2);
        }

        .report-filters {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(255, 255, 255, 0.92));
            backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 15px 60px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(52, 152, 219, 0.3);
            margin-bottom: 40px;
            animation: slideUp 0.6s ease;
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

        .filter-title {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 28px;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .filter-title::before {
            content: '🔍';
            font-size: 28px;
        }

        .filter-row {
            display: flex;
            gap: 20px;
            margin-bottom: 0;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 220px;
        }

        .filter-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .filter-input,
        .filter-select {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #3498db, #2980b9) border-box;
            font-size: 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 600;
            color: #2c3e50;
        }

        .filter-input:focus,
        .filter-select:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.15);
            transform: translateY(-2px);
        }

        .filter-select {
            cursor: pointer;
        }

        .generate-btn {
            padding: 14px 40px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 15px;
            font-weight: 800;
            transition: all 0.3s ease;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(52, 152, 219, 0.4);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .generate-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(52, 152, 219, 0.6);
            background: linear-gradient(135deg, #2980b9, #3498db);
        }

        .generate-btn:active {
            transform: translateY(-1px);
        }

        .report-section {
            margin-bottom: 50px;
            animation: sectionSlide 0.6s ease;
        }

        @keyframes sectionSlide {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-title {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 25px;
            color: #2c3e50;
            padding-left: 25px;
            border-left: 6px solid #3498db;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 0;
            bottom: 0;
            width: 6px;
            background: linear-gradient(180deg, #3498db, #2980b9);
            border-radius: 3px;
        }

        .table-wrapper {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 15px 60px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(52, 152, 219, 0.3);
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: linear-gradient(135deg, #3498db, #2980b9);
            padding: 20px 18px;
            text-align: left;
            font-size: 12px;
            font-weight: 800;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border: none;
        }

        td {
            padding: 20px 18px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            font-size: 15px;
            color: #2c3e50;
            font-weight: 500;
        }

        tr:hover {
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.06), rgba(41, 128, 185, 0.06));
            transition: background 0.3s ease;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            padding: 8px 18px;
            border-radius: 25px;
            font-size: 11px;
            font-weight: 800;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .status-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        .status-completed,
        .status-approved {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
        }

        .status-upcoming {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .status-pending {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
        }

        .status-cancelled {
            background: linear-gradient(135deg, #95a5a6, #7f8c8d);
            color: white;
        }

        .status-rejected {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }

        .chart-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(255, 255, 255, 0.92));
            backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 15px 60px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(52, 152, 219, 0.3);
            margin-bottom: 40px;
        }

        .chart-wrapper {
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
            padding: 40px;
            height: 400px;
            position: relative;
            border-radius: 20px;
            box-shadow: inset 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .export-buttons {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .export-btn {
            padding: 16px 36px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(255, 255, 255, 0.92));
            backdrop-filter: blur(20px);
            border: 2px solid #3498db;
            cursor: pointer;
            font-size: 15px;
            font-weight: 800;
            transition: all 0.3s ease;
            border-radius: 15px;
            color: #2c3e50;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .export-btn:hover {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border-color: transparent;
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(52, 152, 219, 0.4);
        }

        @media print {
            @page {
                size: A4;
                margin: 15mm;
            }

            body {
                background: white;
                margin: 0;
                padding: 0;
            }

            .header,
            .nav,
            .profile,
            .export-buttons,
            .report-filters,
            .footer {
                display: none !important;
            }

            .content {
                padding: 0;
                background: white;
            }

            .print-header {
                display: block !important;
                text-align: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 4px solid #3498db;
                page-break-inside: avoid;
            }

            .print-logo {
                font-size: 36px;
                font-weight: 900;
                color: #2c3e50;
                margin-bottom: 8px;
                letter-spacing: 3px;
            }

            .print-subtitle {
                font-size: 16px;
                color: #7f8c8d;
                font-weight: 600;
                margin-bottom: 8px;
            }

            .print-date {
                font-size: 13px;
                color: #95a5a6;
                margin-top: 8px;
                font-weight: 500;
            }

            .page-title {
                color: #2c3e50;
                text-align: center;
                margin-bottom: 40px;
                font-size: 32px;
                letter-spacing: 3px;
                page-break-inside: avoid;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                margin-bottom: 40px;
                page-break-inside: avoid;
            }

            .stat-card {
                background: white;
                border: 3px solid #3498db;
                padding: 25px 20px;
                border-radius: 12px;
                box-shadow: none;
                page-break-inside: avoid;
            }

            .stat-card::before {
                display: none;
            }

            .stat-icon {
                font-size: 36px;
                animation: none;
                margin-bottom: 15px;
            }

            .stat-label {
                color: #7f8c8d;
                font-size: 11px;
                margin-bottom: 12px;
            }

            .stat-value {
                color: #2c3e50;
                font-size: 32px;
            }

            .report-section {
                page-break-inside: avoid;
                margin-bottom: 40px;
            }

            .section-title {
                color: #2c3e50;
                border-left-color: #3498db;
                font-size: 22px;
                margin-bottom: 20px;
                page-break-after: avoid;
            }

            .table-wrapper {
                background: white;
                border: 2px solid #3498db;
                box-shadow: none;
                page-break-inside: avoid;
                margin-bottom: 30px;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            th {
                background: #3498db !important;
                color: white !important;
                padding: 15px 12px;
                font-size: 11px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            td {
                padding: 12px;
                font-size: 12px;
                color: #2c3e50;
                border-bottom: 1px solid #ddd;
            }

            .status-badge {
                padding: 6px 12px;
                font-size: 10px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .chart-container {
                background: white;
                border: 2px solid #3498db;
                padding: 25px;
                page-break-inside: avoid;
                margin-bottom: 30px;
            }

            .chart-wrapper {
                background: white;
                box-shadow: none;
                height: 350px;
                page-break-inside: avoid;
            }

            .print-footer {
                display: block !important;
                text-align: center;
                margin-top: 40px;
                padding-top: 20px;
                border-top: 3px solid #ecf0f1;
                font-size: 11px;
                color: #7f8c8d;
                page-break-inside: avoid;
            }

            .print-footer p {
                margin: 5px 0;
            }

            .print-footer strong {
                color: #2c3e50;
                font-size: 13px;
            }
        }

        .print-header,
        .print-footer {
            display: none;
        }

        .footer {
            padding: 25px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            text-align: center;
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 600;
            box-shadow: 0 -8px 30px rgba(0, 0, 0, 0.08);
        }

        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.03);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #3498db, #2980b9);
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #2980b9, #3498db);
        }

        @media (max-width: 1200px) {
            .content {
                padding: 40px 30px;
            }

            .nav a {
                margin: 0 10px;
                font-size: 13px;
            }

            .page-title {
                font-size: 36px;
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
                padding: 30px 20px;
            }

            .page-title {
                font-size: 30px;
                margin-bottom: 35px;
                letter-spacing: 2px;
            }

            .filter-row {
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .table-wrapper {
                overflow-x: auto;
            }

            table {
                min-width: 800px;
                font-size: 13px;
            }

            th, td {
                padding: 15px 12px;
            }

            .export-buttons {
                flex-direction: column;
            }

            .export-btn {
                width: 100%;
                text-align: center;
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
                padding: 25px 15px;
            }

            .page-title {
                font-size: 26px;
                letter-spacing: 1.5px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 30px 25px;
            }

            .stat-icon {
                font-size: 48px;
            }

            .stat-value {
                font-size: 44px;
            }

            .section-title {
                font-size: 20px;
            }

            .report-filters,
            .chart-container {
                padding: 25px 20px;
            }

            .chart-wrapper {
                padding: 25px 15px;
                height: 320px;
            }

            .filter-group {
                min-width: 100%;
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
            <a href="database-record.php">Database & Records</a>
            <a href="announcements.php">Announcements</a>
            <a href="report.php" class="active">Report</a>
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
        <div class="print-header">
            <div class="print-logo">🌿 ECOEVENTS</div>
            <div class="print-subtitle">Reports & Analytics Dashboard</div>
            <div class="print-date" id="printDate"></div>
        </div>

        <h1 class="page-title">REPORTS & ANALYTICS</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-label">Total Events</div>
                <div class="stat-value" id="totalEvents">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-label">Total Participants</div>
                <div class="stat-value" id="totalParticipants">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🌱</div>
                <div class="stat-label">Total CO₂ Saved (kg)</div>
                <div class="stat-value" id="totalCO2">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⭐</div>
                <div class="stat-label">Total Eco Points</div>
                <div class="stat-value" id="totalPoints">0</div>
            </div>
        </div>

        <div class="report-filters">
            <div class="filter-title">Generate Custom Report</div>
            <div class="filter-row">
                <div class="filter-group">
                    <label class="filter-label">Date From</label>
                    <input type="date" class="filter-input" id="dateFrom">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Date To</label>
                    <input type="date" class="filter-input" id="dateTo">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Event Status</label>
                    <select class="filter-select" id="eventStatus">
                        <option value="">All Status</option>
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="filter-group">
                    <button class="generate-btn" id="generateReport">Generate</button>
                </div>
            </div>
        </div>

        <div class="export-buttons">
            <button class="export-btn" id="printReport">🖨️ Print Report</button>
            <button class="export-btn" id="exportPDF">📄 Download PDF</button>
            <button class="export-btn" id="exportExcel">📊 Export Excel</button>
            <button class="export-btn" id="exportCSV">📑 Export CSV</button>
        </div>

        <div class="report-section">
            <h2 class="section-title">Event Summary</h2>
            <div class="table-wrapper">
                <table id="eventTable">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Max Participants</th>
                            <th>Eco Points Earned</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="eventTableBody">
                        <tr>
                            <td colspan="5" style="text-align: center;">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="report-section">
            <h2 class="section-title">Top Events by Participants</h2>
            <div class="chart-container">
                <div class="chart-wrapper">
                    <canvas id="participantChart"></canvas>
                </div>
            </div>
        </div>

        <div class="report-section">
            <h2 class="section-title">Environmental Impact Report</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Impact Type</th>
                            <th>Total Value</th>
                            <th>Average per Event</th>
                        </tr>
                    </thead>
                    <tbody id="impactTableBody">
                        <tr>
                            <td colspan="3" style="text-align: center;">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="print-footer">
            <p><strong>EcoEvents</strong> - Sustainable Event Management Platform</p>
            <p>Generated on: <span id="printFooterDate"></span></p>
            <p>www.ecoevents.com | support@ecoevents.com | +1 (555) 123-4567</p>
        </div>
    </div>

    <div class="footer">
        © 2026 EcoVents. All rights reserved.
    </div>

    <script>
        let allEvents = [];
        let participantChart = null;

        const profileCircle = document.getElementById('profileCircle');
        const modal = document.getElementById('modal');
        const modalImg = document.getElementById('modalImg');

        profileCircle.onclick = () => {
            modal.style.display = 'flex';
            modalImg.src = profileCircle.querySelector('img').src;
        };

        modal.onclick = () => modal.style.display = 'none';

        function loadReportData() {
            fetch('get_events.php')
                .then(response => response.json())
                .then(data => {
                    console.log('Received data:', data);
                    if (data.success && data.events) {
                        allEvents = data.events;
                        console.log('All events:', allEvents);
                        updateStatistics(allEvents);
                        displayEventTable(allEvents);
                        displayChart(allEvents);
                        updateImpactTable(allEvents);
                    } else {
                        console.error('No events data received');
                        document.getElementById('eventTableBody').innerHTML = 
                            '<tr><td colspan="5" style="text-align: center;">No events found</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error loading data:', error);
                    document.getElementById('eventTableBody').innerHTML = 
                        '<tr><td colspan="5" style="text-align: center;">Error loading data</td></tr>';
                });
        }

        function updateStatistics(events) {
            const totalEvents = events.length;
            const totalParticipants = events.reduce((sum, event) => {
                const value = parseInt(event.maximum_participant) || 0;
                return sum + value;
            }, 0);
            const totalCO2 = events.reduce((sum, event) => sum + (parseInt(event.carbon_reduction) || 0), 0);
            const totalPoints = events.reduce((sum, event) => {
                const value = parseInt(event.earns_point) || 0;
                return sum + value;
            }, 0);

            document.getElementById('totalEvents').textContent = totalEvents;
            document.getElementById('totalParticipants').textContent = totalParticipants.toLocaleString();
            document.getElementById('totalCO2').textContent = totalCO2.toLocaleString();
            document.getElementById('totalPoints').textContent = totalPoints.toLocaleString();
        }

        function displayEventTable(events) {
            const tbody = document.getElementById('eventTableBody');
            
            if (events.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No events found</td></tr>';
                return;
            }

            let html = '';
            events.forEach(event => {
                const statusClass = 'status-' + (event.status || 'pending').toLowerCase();
                const maxParticipants = parseInt(event.maximum_participant) || 0;
                const ecoPoints = parseInt(event.earns_point) || 0;
                
                html += `
                    <tr data-date="${event.start_date}" data-status="${(event.status || 'pending').toLowerCase()}">
                        <td>${event.event_name || 'N/A'}</td>
                        <td>${formatDate(event.start_date)}</td>
                        <td>${maxParticipants}</td>
                        <td>${ecoPoints}</td>
                        <td><span class="status-badge ${statusClass}">${capitalizeFirst(event.status || 'pending')}</span></td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        }

        function displayChart(events) {
            if (events.length === 0) {
                return;
            }

            const sortedEvents = [...events].sort((a, b) => {
                const aValue = parseInt(a.maximum_participant) || 0;
                const bValue = parseInt(b.maximum_participant) || 0;
                return bValue - aValue;
            }).slice(0, 10);

            const labels = sortedEvents.map(e => {
                const name = e.event_name;
                return name.length > 20 ? name.substring(0, 20) + '...' : name;
            });
            
            const data = sortedEvents.map(e => parseInt(e.maximum_participant) || 0);

            const colors = [
                'rgba(52, 152, 219, 0.8)',
                'rgba(46, 204, 113, 0.8)',
                'rgba(155, 89, 182, 0.8)',
                'rgba(52, 73, 94, 0.8)',
                'rgba(241, 196, 15, 0.8)',
                'rgba(230, 126, 34, 0.8)',
                'rgba(231, 76, 60, 0.8)',
                'rgba(149, 165, 166, 0.8)',
                'rgba(26, 188, 156, 0.8)',
                'rgba(142, 68, 173, 0.8)'
            ];

            const ctx = document.getElementById('participantChart').getContext('2d');

            if (participantChart) {
                participantChart.destroy();
            }

            participantChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Max Participants',
                        data: data,
                        backgroundColor: colors,
                        borderColor: colors.map(c => c.replace('0.8', '1')),
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                padding: 20,
                                color: '#2c3e50'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Top 10 Events by Maximum Participants',
                            font: {
                                size: 18,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 30
                            },
                            color: '#2c3e50'
                        },
                        tooltip: {
                            backgroundColor: 'rgba(44, 62, 80, 0.95)',
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                title: function(context) {
                                    return sortedEvents[context[0].dataIndex].event_name;
                                },
                                label: function(context) {
                                    return 'Max Participants: ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: '600'
                                },
                                color: '#7f8c8d',
                                padding: 10
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 11,
                                    weight: '600'
                                },
                                color: '#7f8c8d',
                                maxRotation: 45,
                                minRotation: 45
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        }

        function updateImpactTable(events) {
            const tbody = document.getElementById('impactTableBody');
            
            const totalCO2 = events.reduce((sum, e) => sum + (parseInt(e.carbon_reduction) || 0), 0);
            const totalPoints = events.reduce((sum, e) => sum + (parseInt(e.earns_point) || 0), 0);
            const totalParticipants = events.reduce((sum, e) => sum + (parseInt(e.maximum_participant) || 0), 0);
            
            const avgCO2 = events.length > 0 ? Math.round(totalCO2 / events.length) : 0;
            const avgPoints = events.length > 0 ? Math.round(totalPoints / events.length) : 0;
            const avgParticipants = events.length > 0 ? Math.round(totalParticipants / events.length) : 0;

            tbody.innerHTML = `
                <tr>
                    <td>CO₂ Saved (kg)</td>
                    <td>${totalCO2.toLocaleString()} kg</td>
                    <td>${avgCO2} kg</td>
                </tr>
                <tr>
                    <td>Eco Points Earned</td>
                    <td>${totalPoints.toLocaleString()} points</td>
                    <td>${avgPoints} points</td>
                </tr>
                <tr>
                    <td>Maximum Participants</td>
                    <td>${totalParticipants.toLocaleString()} people</td>
                    <td>${avgParticipants} people</td>
                </tr>
            `;
        }

        document.getElementById('generateReport').onclick = () => {
            filterTable();
        };

        function filterTable() {
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;
            const status = document.getElementById('eventStatus').value.toLowerCase();

            let filteredEvents = allEvents.filter(event => {
                let match = true;

                if (dateFrom && event.start_date < dateFrom) match = false;
                if (dateTo && event.start_date > dateTo) match = false;
                if (status && (event.status || 'pending').toLowerCase() !== status) match = false;

                return match;
            });

            updateStatistics(filteredEvents);
            displayEventTable(filteredEvents);
            displayChart(filteredEvents);
            updateImpactTable(filteredEvents);
        }

        document.getElementById('printReport').onclick = () => {
            const now = new Date();
            const dateStr = now.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('printDate').textContent = `Generated: ${dateStr}`;
            document.getElementById('printFooterDate').textContent = dateStr;
            
            window.print();
        };

        document.getElementById('exportPDF').onclick = () => {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4');
            
            const pageWidth = doc.internal.pageSize.getWidth();
            const pageHeight = doc.internal.pageSize.getHeight();
            let yPosition = 20;
            
            doc.setFillColor(52, 152, 219);
            doc.rect(0, 0, pageWidth, 35, 'F');
            
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(28);
            doc.setFont(undefined, 'bold');
            doc.text('🌿 ECOEVENTS', pageWidth / 2, 15, { align: 'center' });
            
            doc.setFontSize(13);
            doc.setFont(undefined, 'normal');
            doc.text('Reports & Analytics Dashboard', pageWidth / 2, 24, { align: 'center' });
            
            yPosition = 45;
            
            doc.setTextColor(44, 62, 80);
            doc.setFontSize(20);
            doc.setFont(undefined, 'bold');
            doc.text('REPORTS & ANALYTICS', pageWidth / 2, yPosition, { align: 'center' });
            yPosition += 8;
            
            doc.setFontSize(10);
            doc.setFont(undefined, 'normal');
            doc.setTextColor(127, 140, 141);
            const now = new Date();
            doc.text(`Generated: ${now.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })}`, pageWidth / 2, yPosition, { align: 'center' });
            yPosition += 15;
            
            doc.setDrawColor(52, 152, 219);
            doc.setLineWidth(1);
            doc.line(15, yPosition, pageWidth - 15, yPosition);
            yPosition += 10;
            
            doc.setFontSize(15);
            doc.setFont(undefined, 'bold');
            doc.setTextColor(44, 62, 80);
            doc.text('KEY STATISTICS', 15, yPosition);
            yPosition += 8;
            
            const stats = [
                { label: 'Total Events', value: document.getElementById('totalEvents').textContent, icon: '📊' },
                { label: 'Total Participants', value: document.getElementById('totalParticipants').textContent, icon: '👥' },
                { label: 'Total CO₂ Saved (kg)', value: document.getElementById('totalCO2').textContent, icon: '🌱' },
                { label: 'Total Eco Points', value: document.getElementById('totalPoints').textContent, icon: '⭐' }
            ];
            
            const cardWidth = 45;
            const cardHeight = 28;
            const cardSpacing = 3;
            
            stats.forEach((stat, index) => {
                const xPos = 15 + (index * (cardWidth + cardSpacing));
                
                doc.setDrawColor(52, 152, 219);
                doc.setLineWidth(0.8);
                doc.setFillColor(52, 152, 219);
                doc.roundedRect(xPos, yPosition, cardWidth, cardHeight, 3, 3, 'FD');
                
                doc.setFontSize(18);
                doc.text(stat.icon, xPos + 4, yPosition + 10);
                
                doc.setFontSize(8);
                doc.setTextColor(255, 255, 255);
                doc.setFont(undefined, 'bold');
                doc.text(stat.label, xPos + cardWidth / 2, yPosition + 7, { align: 'center' });
                
                doc.setFontSize(20);
                doc.setFont(undefined, 'bold');
                doc.text(stat.value, xPos + cardWidth / 2, yPosition + 20, { align: 'center' });
            });
            
            yPosition += cardHeight + 15;
            
            doc.setFontSize(15);
            doc.setFont(undefined, 'bold');
            doc.setTextColor(44, 62, 80);
            doc.text('EVENT SUMMARY', 15, yPosition);
            yPosition += 5;
            
            const eventTableData = [];
            const rows = document.querySelectorAll('#eventTableBody tr');
            
            rows.forEach(row => {
                if (row.cells.length > 1) {
                    eventTableData.push([
                        row.cells[0].textContent,
                        row.cells[1].textContent,
                        row.cells[2].textContent,
                        row.cells[3].textContent,
                        row.cells[4].textContent.trim()
                    ]);
                }
            });
            
            doc.autoTable({
                startY: yPosition,
                head: [['Event Name', 'Date', 'Max Participants', 'Eco Points', 'Status']],
                body: eventTableData,
                theme: 'striped',
                headStyles: {
                    fillColor: [52, 152, 219],
                    textColor: [255, 255, 255],
                    fontStyle: 'bold',
                    fontSize: 10,
                    halign: 'left'
                },
                bodyStyles: {
                    fontSize: 9,
                    textColor: [44, 62, 80]
                },
                alternateRowStyles: {
                    fillColor: [248, 249, 250]
                },
                margin: { left: 15, right: 15 },
                didDrawPage: function (data) {
                    doc.setFontSize(8);
                    doc.setTextColor(127, 140, 141);
                    doc.text(
                        `Page ${doc.internal.getCurrentPageInfo().pageNumber}`,
                        pageWidth / 2,
                        pageHeight - 10,
                        { align: 'center' }
                    );
                }
            });
            
            yPosition = doc.lastAutoTable.finalY + 15;
            
            if (yPosition > pageHeight - 70) {
                doc.addPage();
                yPosition = 20;
            }
            
            doc.setFontSize(15);
            doc.setFont(undefined, 'bold');
            doc.setTextColor(44, 62, 80);
            doc.text('TOP EVENTS BY PARTICIPANTS', 15, yPosition);
            yPosition += 5;
            
            const chartData = allEvents
                .sort((a, b) => {
                    const aValue = parseInt(a.maximum_participant) || 0;
                    const bValue = parseInt(b.maximum_participant) || 0;
                    return bValue - aValue;
                })
                .slice(0, 10)
                .map((event, index) => [
                    index + 1,
                    event.event_name,
                    parseInt(event.maximum_participant) || 0
                ]);
            
            doc.autoTable({
                startY: yPosition,
                head: [['Rank', 'Event Name', 'Max Participants']],
                body: chartData,
                theme: 'striped',
                headStyles: {
                    fillColor: [52, 152, 219],
                    textColor: [255, 255, 255],
                    fontStyle: 'bold',
                    fontSize: 10
                },
                bodyStyles: {
                    fontSize: 9,
                    textColor: [44, 62, 80]
                },
                alternateRowStyles: {
                    fillColor: [248, 249, 250]
                },
                columnStyles: {
                    0: { cellWidth: 15, halign: 'center' },
                    1: { cellWidth: 130 },
                    2: { cellWidth: 35, halign: 'center' }
                },
                margin: { left: 15, right: 15 }
            });
            
            yPosition = doc.lastAutoTable.finalY + 15;
            
            if (yPosition > pageHeight - 70) {
                doc.addPage();
                yPosition = 20;
            }
            
            doc.setFontSize(15);
            doc.setFont(undefined, 'bold');
            doc.setTextColor(44, 62, 80);
            doc.text('ENVIRONMENTAL IMPACT REPORT', 15, yPosition);
            yPosition += 5;
            
            const impactTableData = [];
            const impactRows = document.querySelectorAll('#impactTableBody tr');
            
            impactRows.forEach(row => {
                if (row.cells.length > 1) {
                    impactTableData.push([
                        row.cells[0].textContent,
                        row.cells[1].textContent,
                        row.cells[2].textContent
                    ]);
                }
            });
            
            doc.autoTable({
                startY: yPosition,
                head: [['Impact Type', 'Total Value', 'Average per Event']],
                body: impactTableData,
                theme: 'striped',
                headStyles: {
                    fillColor: [52, 152, 219],
                    textColor: [255, 255, 255],
                    fontStyle: 'bold',
                    fontSize: 10
                },
                bodyStyles: {
                    fontSize: 9,
                    textColor: [44, 62, 80]
                },
                alternateRowStyles: {
                    fillColor: [248, 249, 250]
                },
                margin: { left: 15, right: 15 }
            });
            
            const totalPages = doc.internal.getNumberOfPages();
            doc.setPage(totalPages);
            
            yPosition = doc.lastAutoTable.finalY + 15;
            
            doc.setDrawColor(236, 240, 241);
            doc.setLineWidth(0.5);
            doc.line(15, yPosition, pageWidth - 15, yPosition);
            yPosition += 8;
            
            doc.setFontSize(11);
            doc.setFont(undefined, 'bold');
            doc.setTextColor(44, 62, 80);
            doc.text('EcoEvents - Sustainable Event Management', pageWidth / 2, yPosition, { align: 'center' });
            yPosition += 6;
            
            doc.setFontSize(9);
            doc.setFont(undefined, 'normal');
            doc.setTextColor(127, 140, 141);
            doc.text('www.ecoevents.com | support@ecoevents.com | +1 (555) 123-4567', pageWidth / 2, yPosition, { align: 'center' });
            
            doc.save(`EcoEvents_Report_${new Date().toISOString().split('T')[0]}.pdf`);
        };

        document.getElementById('exportExcel').onclick = () => {
            const wb = XLSX.utils.book_new();
            
            const statsData = [
                ['ECOEVENTS - REPORTS & ANALYTICS'],
                [`Generated: ${new Date().toLocaleString()}`],
                [],
                ['KEY STATISTICS'],
                ['Metric', 'Value'],
                ['Total Events', document.getElementById('totalEvents').textContent],
                ['Total Participants', document.getElementById('totalParticipants').textContent],
                ['Total CO₂ Saved (kg)', document.getElementById('totalCO2').textContent],
                ['Total Eco Points', document.getElementById('totalPoints').textContent]
            ];
            
            const statsSheet = XLSX.utils.aoa_to_sheet(statsData);
            statsSheet['!cols'] = [{ wch: 30 }, { wch: 20 }];
            XLSX.utils.book_append_sheet(wb, statsSheet, 'Statistics');
            
            const eventData = [['Event Name', 'Date', 'Max Participants', 'Eco Points', 'Status']];
            const rows = document.querySelectorAll('#eventTableBody tr');
            rows.forEach(row => {
                if (row.cells.length > 1) {
                    eventData.push([
                        row.cells[0].textContent,
                        row.cells[1].textContent,
                        row.cells[2].textContent,
                        row.cells[3].textContent,
                        row.cells[4].textContent.trim()
                    ]);
                }
            });
            
            const eventSheet = XLSX.utils.aoa_to_sheet(eventData);
            eventSheet['!cols'] = [
                { wch: 30 },
                { wch: 15 },
                { wch: 18 },
                { wch: 15 },
                { wch: 12 }
            ];
            XLSX.utils.book_append_sheet(wb, eventSheet, 'Event Summary');
            
            const impactData = [['Impact Type', 'Total Value', 'Average per Event']];
            const impactRows = document.querySelectorAll('#impactTableBody tr');
            impactRows.forEach(row => {
                if (row.cells.length > 1) {
                    impactData.push([
                        row.cells[0].textContent,
                        row.cells[1].textContent,
                        row.cells[2].textContent
                    ]);
                }
            });
            
            const impactSheet = XLSX.utils.aoa_to_sheet(impactData);
            impactSheet['!cols'] = [{ wch: 25 }, { wch: 20 }, { wch: 20 }];
            XLSX.utils.book_append_sheet(wb, impactSheet, 'Environmental Impact');
            
            const chartData = [['Rank', 'Event Name', 'Max Participants']];
            allEvents
                .sort((a, b) => {
                    const aValue = parseInt(a.maximum_participant) || 0;
                    const bValue = parseInt(b.maximum_participant) || 0;
                    return bValue - aValue;
                })
                .slice(0, 10)
                .forEach((event, index) => {
                    chartData.push([
                        index + 1,
                        event.event_name,
                        parseInt(event.maximum_participant) || 0
                    ]);
                });
            
            const chartSheet = XLSX.utils.aoa_to_sheet(chartData);
            chartSheet['!cols'] = [{ wch: 8 }, { wch: 35 }, { wch: 18 }];
            XLSX.utils.book_append_sheet(wb, chartSheet, 'Top Events Chart');
            
            XLSX.writeFile(wb, `EcoEvents_Report_${new Date().toISOString().split('T')[0]}.xlsx`);
        };

        document.getElementById('exportCSV').onclick = () => {
            let csv = 'Event Name,Date,Max Participants,Eco Points,Status\n';
            
            const rows = document.querySelectorAll('#eventTableBody tr');
            rows.forEach(row => {
                if (row.style.display !== 'none' && row.cells.length > 1) {
                    const cols = row.querySelectorAll('td');
                    const rowData = [
                        cols[0].textContent,
                        cols[1].textContent,
                        cols[2].textContent,
                        cols[3].textContent,
                        cols[4].textContent.trim()
                    ];
                    csv += rowData.join(',') + '\n';
                }
            });

            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `EcoEvents_Report_${new Date().toISOString().split('T')[0]}.csv`;
            a.click();
            window.URL.revokeObjectURL(url);
        };

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-GB');
        }

        function capitalizeFirst(str) {
            if (!str) return 'Pending';
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        window.onload = () => {
            const today = new Date();
            const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
            
            document.getElementById('dateTo').valueAsDate = today;
            document.getElementById('dateFrom').valueAsDate = lastMonth;

            loadReportData();
        };
    </script>
</body>
</html>