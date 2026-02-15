<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EcoVents - Breathe Green</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Story+Script&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
<link rel="icon" href="../imagessssss/LOGO.png" type="image/png" sizes="280x280">
<link rel="stylesheet" href="homepage.css">
<style>
    body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
    td {
        font-family: 'Tinos', serif;
}
</style>
</head>

<body>

<?php include 'guestNavigation.php';?>
<section class="leaderboard-section">
    <center>
        <br>
        <h1>User Leaderboard</h1>
        <br>

        <table border="1", style="width:60%">
            <tr bgcolor="#dfffc1">
                <th>Rank</th>
                <th>Name</th>
                <th>User ID</th>
                <th>Points</th>
            </tr>

            <?php
                include "connect.php";
                $sql = "SELECT * FROM organizer_user 
                        WHERE role = 'Participant'
                        ORDER BY points DESC";

                $result = mysqli_query($dbConn, $sql);

                if (mysqli_num_rows($result) <= 0) {
                    echo "<tr><td colspan='4'>No data found</td></tr>";
                }

                $rank = 1; 
                while ($rows = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>".$rank."</td>";
                    echo "<td>".$rows['name']."</td>";
                    echo "<td>PA".$rows['user_id']."</td>";
                    echo "<td>".$rows['points']."</td>";
                    echo "</tr>";

                    $rank++;
                }
            ?>
        </table>
    </center>
</section>

<?php include 'guestFooter.php';?>
</body>
</html>