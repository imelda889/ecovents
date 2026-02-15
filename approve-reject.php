<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval/Reject - EcoEvents</title>
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

        .search-container {
            margin-bottom: 25px;
        }

        .search-bar {
            padding: 12px 20px;
            background: white;
            border: 2px solid #3498db;
            border-radius: 10px;
            font-size: 14px;
            width: 100%;
            max-width: 400px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .search-bar:focus {
            outline: none;
            border-color: #2980b9;
            box-shadow: 0 0 15px rgba(52, 152, 219, 0.3);
        }

        .search-bar::placeholder {
            color: #95a5a6;
            font-weight: 500;
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

        .status-pending {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            box-shadow: 0 2px 8px rgba(243, 156, 18, 0.3);
        }

        .status-approved {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
            box-shadow: 0 2px 8px rgba(39, 174, 96, 0.3);
        }

        .status-rejected {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
        }

        .action-icons {
            display: flex;
            gap: 15px;
            font-size: 20px;
            align-items: center;
        }

        .action-approve {
            cursor: pointer;
            color: #27ae60;
            font-weight: bold;
            transition: all 0.3s ease;
            font-size: 24px;
        }

        .action-approve:hover {
            transform: scale(1.3);
            filter: drop-shadow(0 2px 8px rgba(39, 174, 96, 0.5));
        }

        .action-reject {
            cursor: pointer;
            color: #e74c3c;
            font-weight: bold;
            transition: all 0.3s ease;
            font-size: 24px;
        }

        .action-reject:hover {
            transform: scale(1.3);
            filter: drop-shadow(0 2px 8px rgba(231, 76, 60, 0.5));
        }

        .action-disabled {
            opacity: 0.2;
            cursor: not-allowed;
            filter: grayscale(100%);
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

            .search-bar {
                max-width: 100%;
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

            .confirm-content {
                width: 90%;
                padding: 25px;
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

            .content {
                padding: 15px;
            }

            h1 {
                font-size: 20px;
                margin-bottom: 20px;
                letter-spacing: 1px;
            }

            .search-bar {
                padding: 10px 15px;
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

            .action-icons {
                font-size: 18px;
                gap: 10px;
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
            <a href="approve-reject.php" class="active">Approve / Reject</a>
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
        <h1>EVENT SUBMISSION APPROVAL</h1>

        <div class="search-container">
            <input type="text" class="search-bar" id="searchInput" placeholder="Search events...">
        </div>

        <div class="table-wrapper">
            <table id="approvalTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Event Name</th>
                        <th>Email</th>
                        <th>Event Type</th>
                        <th>Date Submitted</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Data will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="confirm-modal" id="confirmModal">
        <div class="confirm-content">
            <span class="close-confirm" id="closeConfirm">&times;</span>
            <div class="confirm-title" id="confirmTitle">Confirm Action</div>
            <div class="confirm-message" id="confirmMessage">
                Are you sure you want to perform this action?
            </div>
            <div class="confirm-buttons">
                <button class="confirm-btn" id="confirmYes">Yes</button>
                <button class="cancel-btn" id="confirmNo">Cancel</button>
            </div>
        </div>
    </div>

    <div class="footer">
        © 2026 EcoVents. All rights reserved.
    </div>

    <script>
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

        let pendingAction = null;

        function loadEventSubmissions() {
            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '<tr><td colspan="7" style="text-align:center;">Loading...</td></tr>';
            
            fetch('get_events.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.events.length > 0) {
                        let html = '';
                        data.events.forEach((event, index) => {
                            const statusClass = 'status-' + event.status.toLowerCase();
                            const isProcessed = event.status !== 'pending';
                            const disabledClass = isProcessed ? 'action-disabled' : '';
                            
                            html += `
                                <tr data-id="${event.eventID}" data-type="event">
                                    <td>${index + 1}</td>
                                    <td>${event.event_name}</td>
                                    <td>${event.organizer_email}</td>
                                    <td>${event.event_type}</td>
                                    <td>${formatDate(event.created_at || event.start_date)}</td>
                                    <td><span class="${statusClass}">${capitalizeFirst(event.status)}</span></td>
                                    <td>
                                        <div class="action-icons">
                                            <span class="action-approve ${disabledClass}" title="Approve" ${isProcessed ? 'style="pointer-events:none;"' : ''}>✔</span>
                                            <span class="action-reject ${disabledClass}" title="Reject" ${isProcessed ? 'style="pointer-events:none;"' : ''}>✖</span>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                        tableBody.innerHTML = html;
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="7" style="text-align:center;">No events found</td></tr>';
                    }
                    attachActionListeners();
                })
                .catch(error => {
                    console.error('Error:', error);
                    tableBody.innerHTML = '<tr><td colspan="7" style="text-align:center;">Error loading data</td></tr>';
                });
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-GB');
        }

        function capitalizeFirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function attachActionListeners() {
            document.querySelectorAll('.action-approve:not(.action-disabled)').forEach(icon => {
                icon.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const id = row.getAttribute('data-id');
                    const type = row.getAttribute('data-type');
                    const name = row.cells[1].textContent;
                    const eventType = row.cells[3].textContent;
                    
                    pendingAction = {
                        action: 'approve',
                        id: id,
                        type: type,
                        row: row,
                        name: name
                    };
                    
                    document.getElementById('confirmTitle').textContent = 'Confirm Approval';
                    document.getElementById('confirmMessage').textContent = 
                        `Are you sure you want to approve "${name}" (${eventType})?`;
                    document.getElementById('confirmModal').style.display = 'flex';
                });
            });

            document.querySelectorAll('.action-reject:not(.action-disabled)').forEach(icon => {
                icon.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const id = row.getAttribute('data-id');
                    const type = row.getAttribute('data-type');
                    const name = row.cells[1].textContent;
                    const eventType = row.cells[3].textContent;
                    
                    pendingAction = {
                        action: 'reject',
                        id: id,
                        type: type,
                        row: row,
                        name: name
                    };
                    
                    document.getElementById('confirmTitle').textContent = 'Confirm Rejection';
                    document.getElementById('confirmMessage').textContent = 
                        `Are you sure you want to reject "${name}" (${eventType})?`;
                    document.getElementById('confirmModal').style.display = 'flex';
                });
            });
        }

        document.getElementById('confirmYes').addEventListener('click', function() {
            if (pendingAction) {
                const formData = new FormData();
                formData.append('action', pendingAction.action);
                formData.append('id', pendingAction.id);
                formData.append('type', pendingAction.type);
                
                fetch('approve_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    location.reload();
                })
                .catch(error => {
                    console.log('Fetch completed with warning:', error);
                    location.reload();
                });
            }
            
            document.getElementById('confirmModal').style.display = 'none';
            pendingAction = null;
        });

        document.getElementById('confirmNo').addEventListener('click', function() {
            document.getElementById('confirmModal').style.display = 'none';
            pendingAction = null;
        });

        document.getElementById('closeConfirm').addEventListener('click', function() {
            document.getElementById('confirmModal').style.display = 'none';
            pendingAction = null;
        });

        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === document.getElementById('confirmModal')) {
                document.getElementById('confirmModal').style.display = 'none';
                pendingAction = null;
            }
        });

        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const table = document.getElementById('approvalTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }

                row.style.display = found ? '' : 'none';
            }
        });

        loadEventSubmissions();
    </script>
</body>
</html>