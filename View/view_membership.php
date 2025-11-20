<?php
// view_membership.php
// Display membership accounts from database with CRUD functionality

require_once '../db_connection.php';

// Handle CRUD operations
$update_message = '';
$update_type = '';

// Handle create membership
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_membership'])) {
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $membershipType = trim($_POST['membershipType'] ?? '');
    $startDate = trim($_POST['startDate'] ?? '');
    $comments = trim($_POST['comments'] ?? '');
    
    // Validate inputs
    $errors = [];
    
    if (empty($firstName)) {
        $errors[] = "First Name is required.";
    } elseif (!preg_match("/^[A-Za-z' ]+$/", $firstName)) {
        $errors[] = "First Name must contain only letters and spacing only.";
    }
    
    if (empty($lastName)) {
        $errors[] = "Last Name is required.";
    } elseif (!preg_match("/^[A-Za-z' ]+$/", $lastName)) {
        $errors[] = "Last Name must contain only letters and spacing only.";
    }
    
    if (empty($email)) {
        $errors[] = "Email Address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email format.";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone Number is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone Number must be exactly 10 digits.";
    }
    
    if (empty($membershipType)) {
        $errors[] = "Membership Type is required.";
    } elseif (!in_array($membershipType, ['Basic', 'Premium', 'VIP'])) {
        $errors[] = "Invalid Membership Type.";
    }
    
    if (empty($startDate)) {
        $errors[] = "Start Date is required.";
    }
    
    if (empty($errors)) {
        $sql = "INSERT INTO membership (first_name, last_name, email, phone_number, membership_type, start_date, comments)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssssss", $firstName, $lastName, $email, $phone, $membershipType, $startDate, $comments);
            
            if ($stmt->execute()) {
                $page_param = buildPageUrl();
                header("Location: dashboard.php" . $page_param . "&created=success");
                exit;
            } else {
                $update_message = "Error creating membership: " . $conn->error;
                $update_type = "error";
            }
            $stmt->close();
        } else {
            $update_message = "Database prepare error: " . $conn->error;
            $update_type = "error";
        }
    } else {
        $update_message = "Validation errors: " . implode(" ", $errors);
        $update_type = "error";
    }
}

// Handle update membership
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_membership'])) {
    $membership_id = intval($_POST['membership_id']);
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $membershipType = trim($_POST['membershipType'] ?? '');
    $startDate = trim($_POST['startDate'] ?? '');
    $comments = trim($_POST['comments'] ?? '');
    
    // Validate inputs
    $errors = [];
    
    if (empty($firstName)) {
        $errors[] = "First Name is required.";
    } elseif (!preg_match("/^[A-Za-z' ]+$/", $firstName)) {
        $errors[] = "First Name must contain only letters and spacing only.";
    }
    
    if (empty($lastName)) {
        $errors[] = "Last Name is required.";
    } elseif (!preg_match("/^[A-Za-z' ]+$/", $lastName)) {
        $errors[] = "Last Name must contain only letters and spacing only.";
    }
    
    if (empty($email)) {
        $errors[] = "Email Address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email format.";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone Number is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone Number must be exactly 10 digits.";
    }
    
    if (empty($membershipType)) {
        $errors[] = "Membership Type is required.";
    } elseif (!in_array($membershipType, ['Basic', 'Premium', 'VIP'])) {
        $errors[] = "Invalid Membership Type.";
    }
    
    if (empty($startDate)) {
        $errors[] = "Start Date is required.";
    }
    
    if (empty($errors)) {
        $sql = "UPDATE membership SET first_name = ?, last_name = ?, email = ?, phone_number = ?, membership_type = ?, start_date = ?, comments = ? WHERE membership_id = ?";
        
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssssssi", $firstName, $lastName, $email, $phone, $membershipType, $startDate, $comments, $membership_id);
            
            if ($stmt->execute()) {
                $page_param = buildPageUrl();
                header("Location: dashboard.php" . $page_param . "&updated=success");
                exit;
            } else {
                $update_message = "Error updating membership: " . $conn->error;
                $update_type = "error";
            }
            $stmt->close();
        } else {
            $update_message = "Database prepare error: " . $conn->error;
            $update_type = "error";
        }
    } else {
        $update_message = "Validation errors: " . implode(" ", $errors);
        $update_type = "error";
    }
}

// Handle delete membership confirmation and execution
if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] == 'yes' && isset($_GET['id'])) {
    $membership_id = intval($_GET['id']);
    
    $sql = "DELETE FROM membership WHERE membership_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $membership_id);
    
    if ($stmt->execute()) {
        $page_param = '?page=view_membership.php';
        if (isset($_GET['page'])) {
            $page_param = '?page=' . urlencode($_GET['page']);
        }
        header("Location: dashboard.php" . $page_param . "&deleted=success");
        exit;
    } else {
        $update_message = "Error deleting membership: " . $conn->error;
        $update_type = "error";
    }
    $stmt->close();
}

// Show success message if redirected after delete
if (isset($_GET['deleted']) && $_GET['deleted'] == 'success') {
    $update_message = "Membership deleted successfully.";
    $update_type = "success";
}

// Show success message if redirected after create
if (isset($_GET['created']) && $_GET['created'] == 'success') {
    $update_message = "Membership created successfully!";
    $update_type = "success";
}

// Show success message if redirected after update
if (isset($_GET['updated']) && $_GET['updated'] == 'success') {
    $update_message = "Membership updated successfully!";
    $update_type = "success";
}

// Fetch memberships from database
$sql = "SELECT membership_id, first_name, last_name, email, phone_number, membership_type, start_date, comments, created_at 
        FROM membership 
        ORDER BY created_at DESC";

$result = $conn->query($sql);

// Get membership data for editing if edit_id is set
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $edit_sql = "SELECT membership_id, first_name, last_name, email, phone_number, membership_type, start_date, comments 
                 FROM membership WHERE membership_id = ?";
    $edit_stmt = $conn->prepare($edit_sql);
    $edit_stmt->bind_param("i", $edit_id);
    $edit_stmt->execute();
    $edit_result = $edit_stmt->get_result();
    if ($edit_result->num_rows > 0) {
        $edit_data = $edit_result->fetch_assoc();
    }
    $edit_stmt->close();
}

// Helper function to build page URL with parameters
function buildPageUrl($params = []) {
    $query_params = [];
    
    // Always include page parameter
    $query_params['page'] = isset($_GET['page']) ? $_GET['page'] : 'view_membership.php';
    
    // Preserve existing GET parameters except the ones we're modifying
    $exclude_params = ['create', 'edit_id', 'delete_id', 'confirm_delete', 'id', 'deleted'];
    foreach ($_GET as $key => $value) {
        if ($key != 'page' && !in_array($key, $exclude_params)) {
            $query_params[$key] = $value;
        }
    }
    
    // Add new parameters (overwrite existing ones)
    foreach ($params as $key => $value) {
        $query_params[$key] = $value;
    }
    
    // Build URL
    return '?' . http_build_query($query_params);
}
?>

<div class="enquiry-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Membership Accounts</h2>
        <a href="<?php echo htmlspecialchars(buildPageUrl(['create' => '1'])); ?>" class="create-btn" title="Create New Membership">
            <i class="fas fa-plus"></i> Create New Membership
        </a>
    </div>
    
    <?php if ($update_message): ?>
    <div class="status-message <?php echo $update_type; ?>">
        <i class="fas <?php echo $update_type == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
        <?php echo htmlspecialchars($update_message); ?>
    </div>
    <?php endif; ?>
    
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
                    <th>Actions</th>
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
                        echo "<td class='action-cell'>";
                        
                        $page_param = isset($_GET['page']) ? '?page=' . urlencode($_GET['page']) : '?page=view_membership.php';
                        
                        echo "<div class='action-buttons'>";
                        
                        // Edit button
                        $edit_url = $page_param . (strpos($page_param, '?') !== false ? '&' : '?') . 'edit_id=' . $row['membership_id'];
                        echo "<a href='" . htmlspecialchars($edit_url) . "' class='edit-btn' title='Edit Membership'>";
                        echo "<i class='fas fa-edit'></i> Update";
                        echo "</a>";
                        
                        // Delete button - show confirmation or delete link
                        if (isset($_GET['delete_id']) && $_GET['delete_id'] == $row['membership_id']) {
                            // Show confirmation
                            $delete_url = $page_param . (strpos($page_param, '?') !== false ? '&' : '?') . 'confirm_delete=yes&id=' . $row['membership_id'];
                            echo "<div class='delete-confirmation'>";
                            echo "<p class='confirm-text'>Delete this membership?</p>";
                            echo "<div class='confirm-buttons'>";
                            echo "<a href='" . htmlspecialchars($delete_url) . "' class='confirm-delete-btn'>";
                            echo "<i class='fas fa-check'></i> Yes";
                            echo "</a>";
                            echo "<a href='" . htmlspecialchars($page_param) . "' class='cancel-delete-btn'>";
                            echo "<i class='fas fa-times'></i> Cancel";
                            echo "</a>";
                            echo "</div>";
                            echo "</div>";
                        } else {
                            // Show delete button
                            $delete_url = $page_param . (strpos($page_param, '?') !== false ? '&' : '?') . 'delete_id=' . $row['membership_id'];
                            echo "<a href='" . htmlspecialchars($delete_url) . "' class='delete-btn' title='Delete Membership'>";
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
                    echo "<td colspan='9'>";
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

<!-- Create Membership Modal -->
<?php if (isset($_GET['create']) && $_GET['create'] == '1'): ?>
<div id="createModal" class="modal-overlay" style="display: flex;">
    <div class="modal-card">
        <div class="card-header header-success">
            <h3>Create New Membership</h3>
            <a href="<?php echo htmlspecialchars(buildPageUrl()); ?>" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; float: right; text-decoration: none;">&times;</a>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo htmlspecialchars(buildPageUrl()); ?>" id="createForm">
                <div class="form-group">
                    <label for="create_firstName">First Name <span class="red-text">*</span></label>
                    <input type="text" id="create_firstName" name="firstName" required pattern="[A-Za-z' ]+" title="Only letters and spaces allowed">
                </div>
                <div class="form-group">
                    <label for="create_lastName">Last Name <span class="red-text">*</span></label>
                    <input type="text" id="create_lastName" name="lastName" required pattern="[A-Za-z' ]+" title="Only letters and spaces allowed">
                </div>
                <div class="form-group">
                    <label for="create_email">Email <span class="red-text">*</span></label>
                    <input type="email" id="create_email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="create_phone">Phone Number <span class="red-text">*</span></label>
                    <input type="text" id="create_phone" name="phone" required pattern="[0-9]{10}" title="Must be exactly 10 digits" maxlength="10">
                </div>
                <div class="form-group">
                    <label for="create_membershipType">Membership Type <span class="red-text">*</span></label>
                    <select id="create_membershipType" name="membershipType" required>
                        <option value="">Select Type</option>
                        <option value="Basic">Basic</option>
                        <option value="Premium">Premium</option>
                        <option value="VIP">VIP</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="create_startDate">Start Date <span class="red-text">*</span></label>
                    <input type="date" id="create_startDate" name="startDate" required>
                </div>
                <div class="form-group">
                    <label for="create_comments">Comments</label>
                    <textarea id="create_comments" name="comments" rows="3"></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" name="create_membership" class="back-btn">Create Membership</button>
                    <a href="<?php echo htmlspecialchars(buildPageUrl()); ?>" class="back-btn error-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Edit Membership Modal -->
<?php if ($edit_data): ?>
<div id="editModal" class="modal-overlay" style="display: block;">
    <div class="modal-card">
        <div class="card-header header-success">
            <h3>Edit Membership</h3>
            <a href="<?php echo htmlspecialchars(buildPageUrl()); ?>" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; float: right; text-decoration: none;">&times;</a>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo htmlspecialchars(buildPageUrl()); ?>">
                <input type="hidden" name="membership_id" value="<?php echo htmlspecialchars($edit_data['membership_id']); ?>">
                <div class="form-group">
                    <label for="edit_firstName">First Name <span class="red-text">*</span></label>
                    <input type="text" id="edit_firstName" name="firstName" value="<?php echo htmlspecialchars($edit_data['first_name']); ?>" required pattern="[A-Za-z' ]+" title="Only letters and spaces allowed">
                </div>
                <div class="form-group">
                    <label for="edit_lastName">Last Name <span class="red-text">*</span></label>
                    <input type="text" id="edit_lastName" name="lastName" value="<?php echo htmlspecialchars($edit_data['last_name']); ?>" required pattern="[A-Za-z' ]+" title="Only letters and spaces allowed">
                </div>
                <div class="form-group">
                    <label for="edit_email">Email <span class="red-text">*</span></label>
                    <input type="email" id="edit_email" name="email" value="<?php echo htmlspecialchars($edit_data['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="edit_phone">Phone Number <span class="red-text">*</span></label>
                    <input type="text" id="edit_phone" name="phone" value="<?php echo htmlspecialchars($edit_data['phone_number']); ?>" required pattern="[0-9]{10}" title="Must be exactly 10 digits" maxlength="10">
                </div>
                <div class="form-group">
                    <label for="edit_membershipType">Membership Type <span class="red-text">*</span></label>
                    <select id="edit_membershipType" name="membershipType" required>
                        <option value="">Select Type</option>
                        <option value="Basic" <?php echo $edit_data['membership_type'] == 'Basic' ? 'selected' : ''; ?>>Basic</option>
                        <option value="Premium" <?php echo $edit_data['membership_type'] == 'Premium' ? 'selected' : ''; ?>>Premium</option>
                        <option value="VIP" <?php echo $edit_data['membership_type'] == 'VIP' ? 'selected' : ''; ?>>VIP</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_startDate">Start Date <span class="red-text">*</span></label>
                    <input type="date" id="edit_startDate" name="startDate" value="<?php echo htmlspecialchars($edit_data['start_date']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="edit_comments">Comments</label>
                    <textarea id="edit_comments" name="comments" rows="3"><?php echo htmlspecialchars($edit_data['comments'] ?? ''); ?></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" name="update_membership" class="back-btn">Update Membership</button>
                    <a href="<?php echo htmlspecialchars(buildPageUrl()); ?>" class="back-btn error-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
