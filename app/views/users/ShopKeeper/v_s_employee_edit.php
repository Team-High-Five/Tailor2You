<div class="add-new-fabric-container">
    <div class="add-new-fabric-content">
        <div class="modal-header">
            <h1>Edit Employee</h1>
            <a href="<?php echo URLROOT ?>/Shopkeepers/displayEmployees"><button class="close-btn">&times;</button></a>
        </div>
        <div class="employee-form-container">
            <form id="editEmployeeForm" action="<?php echo URLROOT; ?>/Shopkeepers/editEmployee/<?php echo $data['employee']->employee_id; ?>" method="post" enctype="multipart/form-data">
                <div class="post-pic-wrapper">
                    <?php if (empty($data['employee']->image)): ?>
                        <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Employee Picture" id="post-preview">
                    <?php else: ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($data['employee']->image); ?>" alt="Employee Image" id="post-preview">
                    <?php endif; ?>
                </div>
                <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
                <span class="error-message" id="image-error"></span>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo $data['employee']->first_name; ?>" required>
                    <span class="error-message" id="first_name-error"></span>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo $data['employee']->last_name; ?>" required>
                    <span class="error-message" id="last_name-error"></span>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" value="<?php echo $data['employee']->phone_number; ?>" required>
                    <span class="error-message" id="phone_number-error"></span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" value="<?php echo $data['employee']->email; ?>" required>
                    <span class="error-message" id="email-error"></span>
                </div>
                <div class="form-group">
                    <label for="home_town">Home Town</label>
                    <input type="text" id="home_town" name="home_town" value="<?php echo $data['employee']->home_town; ?>" required>
                    <span class="error-message" id="home_town-error"></span>
                </div>
                <div class="form-group">
                    <label for="district">District</label>
                    <select id="district" name="district" required>
                        <option value="">Select District</option>
                        <?php
                        $districts = [
                            'Ampara', 'Anuradhapura', 'Badulla', 'Batticaloa', 'Colombo', 
                            'Galle', 'Gampaha', 'Hambantota', 'Jaffna', 'Kalutara', 
                            'Kandy', 'Kegalle', 'Kilinochchi', 'Kurunegala', 'Mannar', 
                            'Matale', 'Matara', 'Monaragala', 'Mullaitivu', 'Nuwara Eliya', 
                            'Polonnaruwa', 'Puttalam', 'Ratnapura', 'Trincomalee', 'Vavuniya'
                        ];
                        foreach ($districts as $district) {
                            $selected = (isset($data['employee']->district) && $data['employee']->district == $district) ? 'selected' : '';
                            echo "<option value=\"$district\" $selected>$district</option>";
                        }
                        ?>
                    </select>
                    <span class="error-message" id="district-error"></span>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
</div>