<div class="employee-modal-container">
    <div class="modal-header">
        <h1>Edit Employee</h1>
        <button class="close-btn">&times;</button>
    </div>

    <div class="modal-content">
        <form id="editEmployeeForm" action="<?php echo URLROOT; ?>/Shopkeepers/editEmployee/<?php echo $data['employee']->employee_id; ?>" method="post" enctype="multipart/form-data">
            <!-- Image Upload Section -->
            <div class="upload-section">
                <div class="post-pic-wrapper" id="image-upload-area">
                    <?php if (empty($data['employee']->image)): ?>
                        <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Employee Picture" id="post-preview">
                    <?php else: ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($data['employee']->image); ?>" alt="Employee Picture" id="post-preview" class="has-image">
                    <?php endif; ?>
                    <div class="overlay">
                        <i class="ri-camera-line"></i>
                        <p>Click to change image</p>
                    </div>
                </div>
                <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
                <span class="error-message" id="image-error"></span>
            </div>

            <!-- Form Fields -->
            <div class="form-row">
                <div class="form-group half">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo $data['employee']->first_name; ?>" required>
                    <span class="error-message" id="first_name-error"></span>
                </div>

                <div class="form-group half">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo $data['employee']->last_name; ?>" required>
                    <span class="error-message" id="last_name-error"></span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" value="<?php echo $data['employee']->phone_number; ?>" required>
                    <span class="error-message" id="phone_number-error"></span>
                </div>

                <div class="form-group half">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $data['employee']->email; ?>" required>
                    <span class="error-message" id="email-error"></span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <label for="home_town">Home Town</label>
                    <input type="text" id="home_town" name="home_town" value="<?php echo $data['employee']->home_town; ?>" required>
                    <span class="error-message" id="home_town-error"></span>
                </div>

                <div class="form-group half">
                    <label for="district">District</label>
                    <select id="district" name="district" required>
                        <option value="">Select District</option>
                        <?php
                        $districts = [
                            'Ampara',
                            'Anuradhapura',
                            'Badulla',
                            'Batticaloa',
                            'Colombo',
                            'Galle',
                            'Gampaha',
                            'Hambantota',
                            'Jaffna',
                            'Kalutara',
                            'Kandy',
                            'Kegalle',
                            'Kilinochchi',
                            'Kurunegala',
                            'Mannar',
                            'Matale',
                            'Matara',
                            'Monaragala',
                            'Mullaitivu',
                            'Nuwara Eliya',
                            'Polonnaruwa',
                            'Puttalam',
                            'Ratnapura',
                            'Trincomalee',
                            'Vavuniya'
                        ];
                        foreach ($districts as $district) {
                            $selected = (isset($data['employee']->district) && $data['employee']->district == $district) ? 'selected' : '';
                            echo "<option value=\"$district\" $selected>$district</option>";
                        }
                        ?>
                    </select>
                    <span class="error-message" id="district-error"></span>
                </div>
            </div>

            <div class="button-rows">
                <button type="submit" class="submit-btn">
                    <i class="ri-save-line"></i> Update Employee
                </button>
               
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cancel button handler
        const cancelBtn = document.getElementById('cancelEditEmployee');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                const modal = this.closest('.modal');
                if (modal) {
                    modal.classList.remove('show');
                    setTimeout(() => {
                        modal.style.display = 'none';
                    }, 300);
                }
            });
        }
    });
</script>