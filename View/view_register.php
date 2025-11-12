<?php
// view_register.php
// Display workshop registrations from database

require_once '../db_connection.php';

// Fetch registrations from database
$sql = "SELECT register_id, full_name, email, phone_number, workshop_name, preferred_date, notes, created_at 
        FROM register 
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<div class="enquiry-container">
    <h2>Workshop Registrations</h2>
    <div class="table-container">
        <table class="enquiry-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Workshop Type</th>
                    <th>Preferred Date</th>
                    <th>Additional Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $counter . "</td>";
                        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['workshop_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['preferred_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['notes'] ?? '') . "</td>";
                        echo "</tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr class='empty-message'>";
                    echo "<td colspan='7'>";
                    echo "<i class='fas fa-clipboard-list'></i>";
                    echo "<p>No workshop registrations found</p>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
