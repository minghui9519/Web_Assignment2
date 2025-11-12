<?php
// view_deleted_enquiry.php
// Display deleted enquiries from database with restore functionality

require_once '../db_connection.php';

// Handle restore enquiry
$update_message = '';
$update_type = '';

if (isset($_GET['restore_id'])) {
    $deleted_id = intval($_GET['restore_id']);
    
    // Get the deleted enquiry data
    $sql = "SELECT original_enquiry_id, first_name, last_name, email, phone_number, enquiry_type, comments, status, original_created_at 
            FROM deleted_enquiries WHERE deleted_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $deleted_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $enquiry_data = $result->fetch_assoc();
        $stmt->close();
        
        // Check if the original enquiry_id exists in enquiry table
        $check_sql = "SELECT enquiry_id FROM enquiry WHERE enquiry_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $enquiry_data['original_enquiry_id']);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $check_stmt->close();
        
        // Insert back into enquiry table
        // If original ID exists, let it auto-increment; otherwise use original ID
        if ($check_result->num_rows > 0) {
            // Original ID is taken, use auto-increment
            $sql = "INSERT INTO enquiry (first_name, last_name, email, phone_number, enquiry_type, comments, status, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", 
                $enquiry_data['first_name'],
                $enquiry_data['last_name'],
                $enquiry_data['email'],
                $enquiry_data['phone_number'],
                $enquiry_data['enquiry_type'],
                $enquiry_data['comments'],
                $enquiry_data['status'],
                $enquiry_data['original_created_at']
            );
        } else {
            // Original ID is available, use it
            $sql = "INSERT INTO enquiry (enquiry_id, first_name, last_name, email, phone_number, enquiry_type, comments, status, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issssssss", 
                $enquiry_data['original_enquiry_id'],
                $enquiry_data['first_name'],
                $enquiry_data['last_name'],
                $enquiry_data['email'],
                $enquiry_data['phone_number'],
                $enquiry_data['enquiry_type'],
                $enquiry_data['comments'],
                $enquiry_data['status'],
                $enquiry_data['original_created_at']
            );
        }
        
        if ($stmt->execute()) {
            $stmt->close();
            
            // Delete from deleted_enquiries table
            $sql = "DELETE FROM deleted_enquiries WHERE deleted_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $deleted_id);
            
            if ($stmt->execute()) {
                // Redirect to show success message
                $page_param = '?page=view_deleted_enquiry.php';
                if (isset($_GET['page'])) {
                    $page_param = '?page=' . urlencode($_GET['page']);
                }
                header("Location: dashboard.php" . $page_param . "&restored=success");
                exit;
            } else {
                $update_message = "Error removing from deleted enquiries: " . $conn->error;
                $update_type = "error";
            }
            $stmt->close();
        } else {
            $update_message = "Error restoring enquiry: " . $conn->error;
            $update_type = "error";
            $stmt->close();
        }
    } else {
        $update_message = "Deleted enquiry not found.";
        $update_type = "error";
        $stmt->close();
    }
}

// Show success message if redirected after restore
if (isset($_GET['restored']) && $_GET['restored'] == 'success') {
    $update_message = "Enquiry restored successfully. It has been moved back to enquiries.";
    $update_type = "success";
}

// Fetch deleted enquiries from database
$sql = "SELECT deleted_id, original_enquiry_id, first_name, last_name, email, phone_number, enquiry_type, comments, status, deleted_at, original_created_at 
        FROM deleted_enquiries 
        ORDER BY deleted_at DESC";

$result = $conn->query($sql);
?>

<div class="enquiry-container">
    <h2>Deleted Enquiries</h2>
    
    <?php if ($update_message): ?>
    <div class="status-message <?php echo $update_type; ?>">
        <i class="fas <?php echo $update_type == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
        <?php echo $update_message; ?>
    </div>
    <?php endif; ?>
    
    <div class="table-container">
        <table class="enquiry-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Enquirer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Enquiry Type</th>
                    <th>Comments</th>
                    <th>Status</th>
                    <th>Deleted Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        $current_status = $row['status'] ?? 'Pending';
                        echo "<tr>";
                        echo "<td>" . $counter . "</td>";
                        echo "<td>" . htmlspecialchars($row['first_name'] . " " . $row['last_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['enquiry_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['comments']) . "</td>";
                        echo "<td>";
                        echo "<span class='status-badge status-" . strtolower(str_replace(' ', '-', $current_status)) . "'>";
                        echo htmlspecialchars($current_status);
                        echo "</span>";
                        echo "</td>";
                        echo "<td>" . date('Y-m-d H:i:s', strtotime($row['deleted_at'])) . "</td>";
                        echo "<td>";
                        // Maintain page parameter
                        $page_param = isset($_GET['page']) ? '?page=' . urlencode($_GET['page']) : '?page=view_deleted_enquiry.php';
                        $restore_url = $page_param . (strpos($page_param, '?') !== false ? '&' : '?') . 'restore_id=' . $row['deleted_id'];
                        echo "<a href='" . htmlspecialchars($restore_url) . "' class='restore-btn' title='Restore Enquiry'>";
                        echo "<i class='fas fa-undo'></i> Restore";
                        echo "</a>";
                        echo "</td>";
                        echo "</tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr class='empty-message'>";
                    echo "<td colspan='9'>";
                    echo "<i class='fas fa-trash-alt'></i>";
                    echo "<p>No deleted enquiries found</p>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

