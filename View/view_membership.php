<?php
// view_membership.php
// Display membership accounts from database

require_once '../db_connection.php';

// Fetch memberships from database
$sql = "SELECT membership_id, first_name, last_name, email, phone_number, membership_type, start_date, created_at 
        FROM membership 
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<div class="enquiry-container">
    <h2>Membership Accounts</h2>
    <div class="table-container">
        <table class="enquiry-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Membership Type</th>
                    <th>Start Date</th>
                    <th>Join Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $counter . "</td>";
                        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['membership_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['start_date']) . "</td>";
                        echo "<td>" . date('Y-m-d', strtotime($row['created_at'])) . "</td>";
                        echo "</tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr class='empty-message'>";
                    echo "<td colspan='8'>";
                    echo "<i class='fas fa-users'></i>";
                    echo "<p>No membership accounts found</p>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
