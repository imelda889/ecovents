<?php
session_start();

// Database connection
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

// Assume user is logged in with ID in session
$user_id = $_SESSION['user_id'] ?? 3; // Default to 3 for testing

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $type = $_POST['type'];
        $link = $_POST['link'];
        
        $stmt = $pdo->prepare("INSERT INTO news (user_id, news_title, news_content, news_type, news_link) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $content, $type, $link]);
        
        echo json_encode(['success' => true, 'message' => ucfirst($type) . ' added successfully!']);
        exit;
    }
    
    if ($action === 'edit') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $link = $_POST['link'];
        
        $stmt = $pdo->prepare("UPDATE news SET news_title = ?, news_content = ?, news_link = ? WHERE newsID = ?");
        $stmt->execute([$title, $content, $link, $id]);
        
        echo json_encode(['success' => true, 'message' => 'Updated successfully!']);
        exit;
    }
    
    if ($action === 'delete') {
        $id = $_POST['id'];
        
        $stmt = $pdo->prepare("DELETE FROM news WHERE newsID = ?");
        $stmt->execute([$id]);
        
        echo json_encode(['success' => true, 'message' => 'Deleted successfully!']);
        exit;
    }
}

$stmt = $pdo->query("SELECT * FROM news ORDER BY news_created_at DESC");
$newsItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - EcoEvents</title>
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

        /* Profile */
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

        /* Top Buttons */
        .top-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .add-btn {
            padding: 14px 28px;
            background: linear-gradient(135deg, #27ae60, #229954);
            border: none;
            color: white;
            cursor: pointer;
            font-size: 14px;
            font-weight: 700;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.5);
        }

        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.85));
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(52, 152, 219, 0.2);
            flex-wrap: wrap;
        }

        .search-input,
        .filter-select {
            padding: 10px 15px;
            border: 2px solid #3498db;
            background: white;
            font-size: 14px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .search-input {
            width: 250px;
        }

        .search-input:focus,
        .filter-select:focus {
            outline: none;
            border-color: #2980b9;
            box-shadow: 0 0 15px rgba(52, 152, 219, 0.3);
        }

        .filter-select {
            cursor: pointer;
        }

        /* Table */
        .table-wrapper {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(52, 152, 219, 0.2);
            margin-bottom: 30px;
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

        /* Action Icons */
        .action-icons {
            display: flex;
            gap: 10px;
            font-size: 20px;
        }

        .action-icon {
            cursor: pointer;
            transition: all 0.3s ease;
            filter: grayscale(0.3);
        }

        .action-icon:hover {
            transform: scale(1.3);
            filter: grayscale(0);
        }

        /* Footer */
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

        /* Form Modal */
        .form-modal {
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

        .form-content {
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

        .form-title {
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
        }

        .form-label {
            display: block;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #3498db;
            background: white;
            font-size: 14px;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #2980b9;
            box-shadow: 0 0 15px rgba(52, 152, 219, 0.3);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .save-btn,
        .cancel-btn {
            padding: 12px 40px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            border-radius: 10px;
            transition: all 0.3s ease;
            flex: 1;
        }

        .save-btn {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.5);
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

        /* View Modal */
        .view-modal {
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

        .view-content {
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

        .view-title {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 35px;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .view-field {
            margin-bottom: 25px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            border-left: 4px solid #3498db;
        }

        .view-field-label {
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 8px;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .view-field-value {
            font-size: 15px;
            color: #34495e;
            line-height: 1.7;
            word-wrap: break-word;
        }

        .view-link {
            color: #3498db;
            text-decoration: none;
            word-break: break-all;
            font-weight: 600;
        }

        .view-link:hover {
            text-decoration: underline;
        }

        .close-btn {
            padding: 12px 40px;
            border: none;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            margin-top: 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            width: 100%;
        }

        .close-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.5);
        }

        /* Scrollbar */
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

            .top-buttons {
                flex-direction: column;
            }

            .add-btn {
                width: 100%;
                text-align: center;
            }

            .filters {
                flex-direction: column;
                align-items: stretch;
                padding: 15px;
            }

            .search-input {
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

            .form-content,
            .view-content {
                padding: 30px 20px;
            }

            .form-buttons {
                flex-direction: column;
            }

            .save-btn,
            .cancel-btn {
                width: 100%;
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

            .add-btn {
                padding: 12px 20px;
                font-size: 13px;
            }

            .form-content,
            .view-content {
                padding: 25px 15px;
            }

            .form-title,
            .view-title {
                font-size: 22px;
                margin-bottom: 25px;
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
            <a href="announcements.php" class="active">Announcements</a>
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
        <h1>ANNOUNCEMENTS</h1>

        <div class="top-buttons">
            <button class="add-btn" id="addAnnouncementBtn">+ Add Announcement</button>
            <button class="add-btn" id="addNewsBtn">+ Add News</button>
            <button class="add-btn" id="addTipBtn">+ Add Sustainability Tip</button>
        </div>

        <div class="filters">
            <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search...">
            <select class="filter-select" id="filterCategory">
                <option value="">All Category</option>
                <option value="announcement">Announcement</option>
                <option value="news">News</option>
                <option value="tips">Tips</option>
            </select>
        </div>

        <div class="table-wrapper">
            <table id="newsTable">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Content</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php foreach ($newsItems as $item): ?>
                    <tr data-id="<?= $item['newsID'] ?>" 
                        data-content="<?= htmlspecialchars($item['news_content']) ?>" 
                        data-link="<?= htmlspecialchars($item['news_link']) ?>">
                        <td><?= htmlspecialchars($item['news_title']) ?></td>
                        <td><?= htmlspecialchars($item['news_type']) ?></td>
                        <td><?= htmlspecialchars(substr($item['news_content'], 0, 80)) ?>...</td>
                        <td><?= $item['news_created_at'] ?></td>
                        <td>
                            <div class="action-icons">
                                <span class="action-icon view-icon" title="View">👁️</span>
                                <span class="action-icon edit-icon" title="Edit">✏️</span>
                                <span class="action-icon delete-icon" title="Delete">🗑️</span>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="view-modal" id="viewModal">
        <div class="view-content">
            <div class="view-title">News Details</div>
            
            <div class="view-field">
                <div class="view-field-label">Title</div>
                <div class="view-field-value" id="viewTitle"></div>
            </div>
            
            <div class="view-field">
                <div class="view-field-label">Type</div>
                <div class="view-field-value" id="viewType"></div>
            </div>
            
            <div class="view-field">
                <div class="view-field-label">Content</div>
                <div class="view-field-value" id="viewContent"></div>
            </div>
            
            <div class="view-field">
                <div class="view-field-label">Link</div>
                <div class="view-field-value"><a href="#" id="viewLink" class="view-link" target="_blank"></a></div>
            </div>
            
            <div class="view-field">
                <div class="view-field-label">Created At</div>
                <div class="view-field-value" id="viewCreatedAt"></div>
            </div>
            
            <button class="close-btn" id="closeViewBtn">Close</button>
        </div>
    </div>

    <div class="form-modal" id="formModal">
        <div class="form-content">
            <div class="form-title" id="formTitle">Add Item</div>
            
            <form id="itemForm">
                <input type="hidden" id="itemId" name="id">
                <input type="hidden" id="formAction" name="action" value="add">
                
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-input" id="itemTitle" name="title" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Type</label>
                    <input type="text" class="form-input" id="itemType" name="type" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">Content</label>
                    <textarea class="form-textarea" id="itemContent" name="content" required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Link</label>
                    <input type="url" class="form-input" id="itemLink" name="link" required>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="save-btn">Save</button>
                    <button type="button" class="cancel-btn" id="cancelBtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="footer">
        © 2026 EcoVents. All rights reserved.
    </div>

    <script>

const profileCircle = document.getElementById('profileCircle');
const modal = document.getElementById('modal');
const modalImg = document.getElementById('modalImg');

profileCircle.onclick = () => {
    modal.style.display = 'flex';
    modalImg.src = profileCircle.querySelector('img').src;
};

modal.onclick = () => modal.style.display = 'none';

const formModal = document.getElementById('formModal');
const viewModal = document.getElementById('viewModal');

document.getElementById('addAnnouncementBtn').onclick = () => openForm('announcement', 'Add Announcement');
document.getElementById('addNewsBtn').onclick = () => openForm('news', 'Add News');
document.getElementById('addTipBtn').onclick = () => openForm('tips', 'Add Sustainability Tip');

function openForm(type, title) {
    document.getElementById('formTitle').textContent = title;
    document.getElementById('itemForm').reset();
    document.getElementById('itemType').value = type;
    document.getElementById('formAction').value = 'add';
    document.getElementById('itemId').value = '';
    formModal.style.display = 'flex';
}

document.getElementById('cancelBtn').onclick = () => formModal.style.display = 'none';
document.getElementById('closeViewBtn').onclick = () => viewModal.style.display = 'none';

formModal.onclick = e => {
    if (e.target === formModal) formModal.style.display = 'none';
};
viewModal.onclick = e => {
    if (e.target === viewModal) viewModal.style.display = 'none';
};

document.getElementById('itemForm').onsubmit = async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch('announcements.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert(result.message);
            window.location.reload();
        }
    } catch (error) {
        alert('Error: ' + error.message);
    }
};

document.addEventListener('click', async (e) => {
    if (!e.target.closest('tr')) return;
    const row = e.target.closest('tr');

    if (e.target.classList.contains('view-icon')) {
        document.getElementById('viewTitle').textContent = row.cells[0].textContent;
        document.getElementById('viewType').textContent = row.cells[1].textContent;
        document.getElementById('viewContent').textContent = row.dataset.content || 'No content';
        document.getElementById('viewLink').textContent = row.dataset.link || 'No link';
        document.getElementById('viewLink').href = row.dataset.link || '#';
        document.getElementById('viewCreatedAt').textContent = row.cells[3].textContent;
        viewModal.style.display = 'flex';
    }

    if (e.target.classList.contains('edit-icon')) {
        const type = row.cells[1].textContent;
        const typeTitle = type === 'announcement' ? 'Announcement' : 
                         type === 'news' ? 'News' : 'Sustainability Tip';
        
        document.getElementById('formTitle').textContent = 'Edit ' + typeTitle;
        document.getElementById('itemId').value = row.dataset.id;
        document.getElementById('itemTitle').value = row.cells[0].textContent;
        document.getElementById('itemType').value = type;
        document.getElementById('itemContent').value = row.dataset.content || '';
        document.getElementById('itemLink').value = row.dataset.link || '';
        document.getElementById('formAction').value = 'edit';
        formModal.style.display = 'flex';
    }

    if (e.target.classList.contains('delete-icon')) {
        if (confirm(`Delete "${row.cells[0].textContent}"?`)) {
            try {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', row.dataset.id);
                
                const response = await fetch('announcements.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert(result.message);
                    window.location.reload();
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }
    }
});

function filterTable() {
    const search = searchInput.value.toLowerCase();
    const category = filterCategory.value;

    document.querySelectorAll('#tableBody tr').forEach(row => {
        const match =
            row.cells[0].textContent.toLowerCase().includes(search) &&
            (!category || row.cells[1].textContent === category);
        row.style.display = match ? '' : 'none';
    });
}

searchInput.onkeyup = filterTable;
filterCategory.onchange = filterTable;
</script>
</body>
</html>