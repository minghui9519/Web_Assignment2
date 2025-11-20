<?php
// view_register.php
// Display workshop registrations from database

require_once '../db_connection.php';

$update_message = '';
$update_type = '';

// Handle update registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_registration'])) {
    $register_id = intval($_POST['register_id']);
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone_number'] ?? '');
    $workshop = trim($_POST['workshop_name'] ?? '');
    $preferredDate = trim($_POST['preferred_date'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    $errors = [];

    if (empty($fullName)) {
        $errors[] = "Full Name is required.";
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

    if (empty($workshop)) {
        $errors[] = "Workshop Type is required.";
    }

    if (empty($preferredDate)) {
        $errors[] = "Preferred Date is required.";
    }

    if (empty($errors)) {
        $sql = "UPDATE register SET full_name = ?, email = ?, phone_number = ?, workshop_name = ?, preferred_date = ?, notes = ? WHERE register_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssssi", $fullName, $email, $phone, $workshop, $preferredDate, $notes, $register_id);
            if ($stmt->execute()) {
                $redirect_url = buildPageUrl();
                header("Location: dashboard.php" . $redirect_url . "&updated=success");
                exit;
            } else {
                $update_message = "Error updating registration: " . $conn->error;
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

// Show success message if redirected after update
if (isset($_GET['updated']) && $_GET['updated'] == 'success') {
    $update_message = "Registration updated successfully!";
    $update_type = "success";
}

// Fetch registrations from database
$sql = "SELECT register_id, full_name, email, phone_number, workshop_name, preferred_date, notes, created_at 
        FROM register 
        ORDER BY created_at DESC";

$result = $conn->query($sql);

// Get registration data for editing if edit_id is set
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $edit_sql = "SELECT register_id, full_name, email, phone_number, workshop_name, preferred_date, notes 
                 FROM register WHERE register_id = ?";
    $edit_stmt = $conn->prepare($edit_sql);
    $edit_stmt->bind_param("i", $edit_id);
    $edit_stmt->execute();
    $edit_result = $edit_stmt->get_result();
    if ($edit_result->num_rows > 0) {
        $edit_data = $edit_result->fetch_assoc();
    }
    $edit_stmt->close();
}

function buildPageUrl($params = []) {
    $query_params = [];
    $query_params['page'] = isset($_GET['page']) ? $_GET['page'] : 'view_register.php';

    $exclude_params = ['edit_id', 'updated'];
    foreach ($_GET as $key => $value) {
        if ($key != 'page' && !in_array($key, $exclude_params)) {
            $query_params[$key] = $value;
        }
    }

    foreach ($params as $key => $value) {
        $query_params[$key] = $value;
    }

    return '?' . http_build_query($query_params);
}
?>

<div class="enquiry-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Workshop Registrations</h2>
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
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Workshop Type</th>
                    <th>Preferred Date</th>
                    <th>Additional Notes</th>
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
                        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['workshop_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['preferred_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['notes'] ?? '') . "</td>";
                        $edit_url = buildPageUrl(['edit_id' => $row['register_id']]);
                        echo "<td class='action-cell'>";
                        echo "<div class='action-buttons'>";
                        echo "<a href='" . htmlspecialchars($edit_url) . "' class='edit-btn' title='Edit Registration'>";
                        echo "<i class='fas fa-edit'></i> Update";
                        echo "</a>";
                        echo "</div>";
                        echo "</td>";
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

<!-- Edit Registration Modal -->
<?php if ($edit_data): ?>
<div id="editModal" class="modal-overlay" style="display: block;">
    <div class="modal-card">
        <div class="card-header header-success">
            <h3>Edit Registration</h3>
            <a href="<?php echo htmlspecialchars(buildPageUrl()); ?>" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; float: right; text-decoration: none;">&times;</a>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo htmlspecialchars(buildPageUrl()); ?>">
                <input type="hidden" name="register_id" value="<?php echo htmlspecialchars($edit_data['register_id']); ?>">
                <div class="form-group">
                    <label for="edit_full_name">Full Name <span class="red-text">*</span></label>
                    <input type="text" id="edit_full_name" name="full_name" value="<?php echo htmlspecialchars($edit_data['full_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="edit_email">Email <span class="red-text">*</span></label>
                    <input type="email" id="edit_email" name="email" value="<?php echo htmlspecialchars($edit_data['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="edit_phone_number">Phone Number <span class="red-text">*</span></label>
                    <input type="text" id="edit_phone_number" name="phone_number" value="<?php echo htmlspecialchars($edit_data['phone_number']); ?>" required pattern="[0-9]{10}" title="Must be exactly 10 digits" maxlength="10">
                </div>
                <div class="form-group">
                    <label for="edit_workshop_name">Workshop Type <span class="red-text">*</span></label>
                    <select id="edit_workshop_name" name="workshop_name" required>
                        <option value="">Select Type</option>
                        <option value="Handtied Bouquet (2 days / 5 classes)" <?php echo ($edit_data['workshop_name'] ?? '') === 'Handtied Bouquet (2 days / 5 classes)' ? 'selected' : ''; ?>>
                            Handtied Bouquet (2 days / 5 classes)
                        </option>
                        <option value="Florist To Be (4 days / 9 classes)" <?php echo ($edit_data['workshop_name'] ?? '') === 'Florist To Be (4 days / 9 classes)' ? 'selected' : ''; ?>>
                            Florist To Be (4 days / 9 classes)
                        </option>
                        <option value="Hobby Class (Specific Dates)" <?php echo ($edit_data['workshop_name'] ?? '') === 'Hobby Class (Specific Dates)' ? 'selected' : ''; ?>>
                            Hobby Class (Specific Dates)
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_preferred_date">Preferred Date <span class="red-text">*</span></label>
                    <input type="date" id="edit_preferred_date" name="preferred_date" value="<?php echo htmlspecialchars($edit_data['preferred_date']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="edit_notes">Additional Notes</label>
                    <textarea id="edit_notes" name="notes" rows="3"><?php echo htmlspecialchars($edit_data['notes'] ?? ''); ?></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" name="update_registration" class="back-btn">Update Registration</button>
                    <a href="<?php echo htmlspecialchars(buildPageUrl()); ?>" class="back-btn error-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
