<?php
session_start();
require_once 'dbConn.php';
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : $_SESSION['name'];
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : $_SESSION['email'];

$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Event</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/test.png" type="images" />
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        .back {
            display: inline-block;
            color: #2e7d33;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #2e7d33;
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }
        
        .required {
            color: #d32f2f;
        }
        
        input[type="text"],
        input[type="date"],
        input[type="time"],
        input[type="number"],
        input[type="email"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2e7d33;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 5px;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .checkbox-item input {
            width: auto;
        }
        
        .checkbox-item label {
            margin: 0;
            font-weight: normal;
        }
        
        .btn-submit {
            background: #2e7d33;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }
        
        .btn-submit:hover {
            background: #1b5e20;
        }
        
        .btn-add {
            background: #fff;
            color: #2e7d33;
            padding: 10px 20px;
            border: 2px solid #2e7d33;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .btn-add:hover {
            background: #f1f8f1;
        }
        
        .collaborator-item {
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 10px;
            margin-bottom: 10px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 4px;
        }
        
        .btn-remove {
            background: #d32f2f;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-remove:hover {
            background: #b71c1c;
        }
        
        .alert {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #2e7d33;
            margin: 30px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .sustainability-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .sustainability-item {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            transition: all 0.3s;
        }
        
        .sustainability-item:hover {
            border-color: #2e7d33;
            background: #f9fdf9;
        }
        
        .sustainability-item input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
        }
        
        .sustainability-item label {
            cursor: pointer;
            display: block;
            margin: 0;
            font-weight: normal;
        }
        
        .sustainability-item label strong {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
        }
        
        .sustainability-item label .impact {
            display: block;
            color: #2e7d33;
            font-weight: 600;
            font-size: 13px;
            margin: 5px 0;
        }
        
        .sustainability-item label small {
            display: block;
            color: #666;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .carbon-total {
            background: #e8f5e9;
            border: 2px solid #2e7d33;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }
        
        .carbon-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .carbon-value {
            font-size: 32px;
            font-weight: 700;
            color: #2e7d33;
        }
        
        @media (max-width: 768px) {
            .sustainability-options {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <a href="createevent.php" class="back">← Back to Templates</a>

    <div class="container">
        <h1>Create New Event</h1>
        <p class="subtitle">Fill in the details below to create your sustainable event.</p>

        <?php if ($error_message): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="submit_event.php" enctype="multipart/form-data">
            <input type="hidden" name="status" value="pending">
            
            <div class="section-title">Basic Information</div>
            
            <div class="form-group">
                <label>Event Name <span class="required">*</span></label>
                <input type="text" name="event_name" placeholder="Enter event name" required>
            </div>

            <div class="form-group">
                <label>Event Type <span class="required">*</span></label>
                <select name="event_type" required>
                    <option value="">Select event type</option>
                    <option value="conference">Conference</option>
                    <option value="workshop">Workshop</option>
                    <option value="seminar">Seminar</option>
                    <option value="webinar">Webinar</option>
                    <option value="communitycleanup">Community Cleanup</option>
                    <option value="treesplantation">Tree Plantation</option>
                    <option value="awarenesscampaign">Awareness Campaign</option>
                    <option value="fundraiser">Fundraiser</option>
                    <option value="exhibition">Exhibition</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Description <span class="required">*</span></label>
                <textarea name="description" placeholder="Describe your event and its goals" required></textarea>
            </div>

            <div class="form-group">
                <label>Event Image <span class="required">*</span></label>
                <input type="file" name="event_image" accept="image/*" required>
            </div>

            <div class="form-group">
                <label>Location <span class="required">*</span></label>
                <input type="text" name="location" placeholder="e.g., Main Auditorium, Building A" required>
            </div>

            <div class="form-group">
                <label>Event Cost (Optional)</label>
                <input type="number" name="event_cost" placeholder="0.00" step="0.01" min="0">
                <small style="color: #666; font-size: 12px;">Leave blank if free. Amount in RM.</small>
            </div>

            <div class="form-group">
                <label>Transportation Plan (Optional)</label>
                <textarea name="transportation_plan" placeholder="Describe transportation options, parking availability, public transport routes, carpooling arrangements, etc." rows="3"></textarea>
            </div>

            <div class="section-title">Date & Time</div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Start Date <span class="required">*</span></label>
                    <input type="date" name="start_date" required>
                </div>
                <div class="form-group">
                    <label>End Date <span class="required">*</span></label>
                    <input type="date" name="end_date" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Start Time <span class="required">*</span></label>
                    <input type="time" name="start_time" required>
                </div>
                <div class="form-group">
                    <label>End Time <span class="required">*</span></label>
                    <input type="time" name="end_time" required>
                </div>
            </div>

            <div class="section-title">Participant Details</div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Maximum Participants <span class="required">*</span></label>
                    <input type="number" name="max_participants" placeholder="e.g., 150" required>
                </div>
                <div class="form-group">
                    <label>Registration Deadline <span class="required">*</span></label>
                    <input type="date" name="registration_deadline" required>
                </div>
            </div>

            <div class="form-group">
                <label>Points per Participant <span class="required">*</span></label>
                <input type="number" name="points_per_participant" placeholder="e.g., 50" required>
            </div>

            <div class="form-group">
                <label>Who can participate?</label>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" name="participant_categories[]" value="student" id="cat_student">
                        <label for="cat_student">Student</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="participant_categories[]" value="faculty" id="cat_faculty">
                        <label for="cat_faculty">Faculty</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="participant_categories[]" value="staff" id="cat_staff">
                        <label for="cat_staff">Staff</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="participant_categories[]" value="alumni" id="cat_alumni">
                        <label for="cat_alumni">Alumni</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="participant_categories[]" value="external" id="cat_external">
                        <label for="cat_external">External</label>
                    </div>
                </div>
            </div>

            <div class="section-title">Sustainability Features (Optional)</div>
            <p style="color: #666; font-size: 13px; margin-bottom: 15px;">Select sustainability options to calculate your event's carbon reduction impact.</p>
            
            <div class="form-group">
                <div class="sustainability-options">
                    <div class="sustainability-item">
                        <input type="checkbox" name="sustainability[]" value="zero_waste" id="zero_waste" data-co2="15" onchange="updateCarbon()">
                        <label for="zero_waste">
                            <strong>🗑️ Zero Waste Initiative</strong>
                            <span class="impact">-15kg CO₂</span>
                            <small>Comprehensive waste segregation and recycling</small>
                        </label>
                    </div>
                    
                    <div class="sustainability-item">
                        <input type="checkbox" name="sustainability[]" value="digital_first" id="digital_first" data-co2="8" onchange="updateCarbon()">
                        <label for="digital_first">
                            <strong>📱 Digital-First Approach</strong>
                            <span class="impact">-8kg CO₂</span>
                            <small>Minimize paper with digital materials and QR codes</small>
                        </label>
                    </div>
                    
                    <div class="sustainability-item">
                        <input type="checkbox" name="sustainability[]" value="local_sourcing" id="local_sourcing" data-co2="12" onchange="updateCarbon()">
                        <label for="local_sourcing">
                            <strong>📍 Local Sourcing</strong>
                            <span class="impact">-12kg CO₂</span>
                            <small>Source food and materials from local vendors</small>
                        </label>
                    </div>
                    
                    <div class="sustainability-item">
                        <input type="checkbox" name="sustainability[]" value="renewable_energy" id="renewable_energy" data-co2="20" onchange="updateCarbon()">
                        <label for="renewable_energy">
                            <strong>⚡ Renewable Energy</strong>
                            <span class="impact">-20kg CO₂</span>
                            <small>Use solar or wind-powered equipment</small>
                        </label>
                    </div>
                    
                    <div class="sustainability-item">
                        <input type="checkbox" name="sustainability[]" value="public_transport" id="public_transport" data-co2="25" onchange="updateCarbon()">
                        <label for="public_transport">
                            <strong>🚌 Public Transport Incentive</strong>
                            <span class="impact">-25kg CO₂</span>
                            <small>Encourage carpooling and public transportation</small>
                        </label>
                    </div>
                    
                    <div class="sustainability-item">
                        <input type="checkbox" name="sustainability[]" value="reusable_materials" id="reusable_materials" data-co2="10" onchange="updateCarbon()">
                        <label for="reusable_materials">
                            <strong>♻️ Reusable Materials</strong>
                            <span class="impact">-10kg CO₂</span>
                            <small>Use reusable decorations and utensils</small>
                        </label>
                    </div>
                </div>
                
                <div class="carbon-total">
                    <div class="carbon-label">Total Carbon Reduction</div>
                    <div class="carbon-value">-<span id="carbonTotal">0</span>kg CO₂</div>
                </div>
                <input type="hidden" name="carbon_reduction" id="carbonReduction" value="0">
            </div>

            <div class="section-title">Collaborators (Optional)</div>
            
            <div id="collaboratorsList"></div>
            
            <button type="button" class="btn-add" onclick="addCollaborator()">+ Add Collaborator</button>

            <button type="submit" class="btn-submit">Submit Event for Approval</button>
        </form>
    </div>

    <script>
        let collaboratorCount = 0;

        function addCollaborator() {
            collaboratorCount++;
            const div = document.createElement('div');
            div.className = 'collaborator-item';
            div.innerHTML = `
                <input type="email" name="collaborators[${collaboratorCount}][email]" placeholder="Enter email address">
                <select name="collaborators[${collaboratorCount}][role]">
                    <option value="co-organizer">Co-Organizer</option>
                    <option value="coordinator">Coordinator</option>
                    <option value="volunteer">Volunteer</option>
                </select>
                <button type="button" class="btn-remove" onclick="this.parentElement.remove()">Remove</button>
            `;
            document.getElementById('collaboratorsList').appendChild(div);
        }
        
        function updateCarbon() {
            const checkboxes = document.querySelectorAll('input[name="sustainability[]"]:checked');
            let total = 0;
            checkboxes.forEach(cb => {
                total += parseInt(cb.dataset.co2);
            });
            document.getElementById('carbonTotal').textContent = total;
            document.getElementById('carbonReduction').value = total;
        }
    </script>
</body>
</html>