<?php
// view_enquiry.php
// Display enquiries from database with status update functionality

require_once '../db_connection.php';

$standalone_view = !isset($is_dashboard_context);
if ($standalone_view) {
    $view_page_title = 'Enquiries - Root Flower';
    include 'view_header.php';
}

// Handle status update and delete
$update_message = '';
$update_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $enquiry_id = intval($_POST['enquiry_id']);
    $new_status = $_POST['status'];
    
    // Validate status
    $allowed_statuses = ['Pending', 'In Progress', 'Resolved', 'Closed'];
    if (in_array($new_status, $allowed_statuses)) {
        $sql = "UPDATE enquiry SET status = ? WHERE enquiry_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_status, $enquiry_id);
        
        if ($stmt->execute()) {
            $update_message = "Status updated successfully to: " . htmlspecialchars($new_status);
            $update_type = "success";
        } else {
            $update_message = "Error updating status: " . $conn->error;
            $update_type = "error";
        }
        $stmt->close();
    } else {
        $update_message = "Invalid status selected.";
        $update_type = "error";
    }
}

// Handle delete enquiry confirmation and execution
if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] == 'yes' && isset($_GET['id'])) {
    $enquiry_id = intval($_GET['id']);
    
    // Get the enquiry data before deleting
    $sql = "SELECT enquiry_id, first_name, last_name, email, phone_number, enquiry_type, comments, status, created_at 
            FROM enquiry WHERE enquiry_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $enquiry_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $enquiry_data = $result->fetch_assoc();
        $stmt->close();
        
        // Insert into deleted_enquiries table
        $sql = "INSERT INTO deleted_enquiries (original_enquiry_id, first_name, last_name, email, phone_number, enquiry_type, comments, status, original_created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssss", 
            $enquiry_data['enquiry_id'],
            $enquiry_data['first_name'],
            $enquiry_data['last_name'],
            $enquiry_data['email'],
            $enquiry_data['phone_number'],
            $enquiry_data['enquiry_type'],
            $enquiry_data['comments'],
            $enquiry_data['status'],
            $enquiry_data['created_at']
        );
        
        if ($stmt->execute()) {
            $stmt->close();
            
            // Delete from enquiry table
            $sql = "DELETE FROM enquiry WHERE enquiry_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $enquiry_id);
            
            if ($stmt->execute()) {
                // Redirect to remove GET parameters and show success message
                $page_param = '?page=view_enquiry.php';
                if (isset($_GET['page'])) {
                    $page_param = '?page=' . urlencode($_GET['page']);
                }
                header("Location: dashboard.php" . $page_param . "&deleted=success");
                exit;
            } else {
                $update_message = "Error deleting enquiry: " . $conn->error;
                $update_type = "error";
            }
            $stmt->close();
        } else {
            $update_message = "Error moving enquiry to deleted: " . $conn->error;
            $update_type = "error";
            $stmt->close();
        }
    } else {
        $update_message = "Enquiry not found.";
        $update_type = "error";
        $stmt->close();
    }
}

// Show success message if redirected after delete
if (isset($_GET['deleted']) && $_GET['deleted'] == 'success') {
    $update_message = "Enquiry deleted successfully. It has been moved to deleted enquiries.";
    $update_type = "success";
}

// Fetch enquiries from database
$sql = "SELECT enquiry_id, first_name, last_name, email, phone_number, enquiry_type, comments, status, created_at 
        FROM enquiry 
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<div class="enquiry-container">
    <h2>Enquiries</h2>
    
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
                        echo "<td class='action-cell'>";
                        // Maintain page parameter after form submission
                        $page_param = isset($_GET['page']) ? '?page=' . urlencode($_GET['page']) : '?page=view_enquiry.php';
                        
                        echo "<div class='action-buttons'>";
                        // Status update form
                        echo "<form method='POST' action='" . htmlspecialchars($page_param) . "' class='status-form'>";
                        echo "<input type='hidden' name='enquiry_id' value='" . $row['enquiry_id'] . "'>";
                        echo "<select name='status' class='status-select'>";
                        echo "<option value='Pending'" . ($current_status == 'Pending' ? ' selected' : '') . ">Pending</option>";
                        echo "<option value='In Progress'" . ($current_status == 'In Progress' ? ' selected' : '') . ">In Progress</option>";
                        echo "<option value='Resolved'" . ($current_status == 'Resolved' ? ' selected' : '') . ">Resolved</option>";
                        echo "<option value='Closed'" . ($current_status == 'Closed' ? ' selected' : '') . ">Closed</option>";
                        echo "</select>";
                        echo "<button type='submit' name='update_status' class='update-btn' title='Update Status'>";
                        echo "<i class='fas fa-save'></i> Update";
                        echo "</button>";
                        echo "</form>";
                        
                        // Delete button - show confirmation or delete link
                        if (isset($_GET['delete_id']) && $_GET['delete_id'] == $row['enquiry_id']) {
                            // Show confirmation
                            $delete_url = $page_param . (strpos($page_param, '?') !== false ? '&' : '?') . 'confirm_delete=yes&id=' . $row['enquiry_id'];
                            echo "<div class='delete-confirmation'>";
                            echo "<p class='confirm-text'>Delete this enquiry?</p>";
                            echo "<div class='confirm-buttons'>";
                            echo "<a href='" . htmlspecialchars($delete_url) . "' class='confirm-delete-btn'>";
                            echo "<i class='fas fa-check'></i> Yes, Delete";
                            echo "</a>";
                            echo "<a href='" . htmlspecialchars($page_param) . "' class='cancel-delete-btn'>";
                            echo "<i class='fas fa-times'></i> Cancel";
                            echo "</a>";
                            echo "</div>";
                            echo "</div>";
                        } else {
                            // Show delete button
                            $delete_url = $page_param . (strpos($page_param, '?') !== false ? '&' : '?') . 'delete_id=' . $row['enquiry_id'];
                            echo "<a href='" . htmlspecialchars($delete_url) . "' class='delete-btn' title='Delete Enquiry'>";
                            echo "<i class='fas fa-trash-alt'></i> Delete";
                            echo "</a>";
                        }
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr class='empty-message'>";
                    echo "<td colspan='8'>";
                    echo "<i class='fas fa-envelope'></i>";
                    echo "<p>No enquiries found</p>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
if ($standalone_view) {
    include 'view_footer.php';
}
?>
