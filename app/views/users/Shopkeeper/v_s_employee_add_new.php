<div class="employee-modal-container">
    <div class="modal-header">
        <h1>Add New Employee</h1>
        <button class="close-btn">&times;</button>
    </div>

    <div class="modal-content">
        <form id="addEmployeeForm" action="<?php echo URLROOT; ?>/Shopkeepers/addNewEmployee" method="post" enctype="multipart/form-data">
            <!-- Image Upload Section -->
            <div class="upload-section">
                <div class="post-pic-wrapper" id="image-upload-area">
                    <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Employee Picture" id="post-preview">
                    <div class="overlay">
                        <i class="ri-camera-line"></i>
                        <p>Click to upload image</p>
                    </div>
                </div>
                <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
                <span class="error-message" id="image-error"></span>
            </div>

            <!-- Form Fields -->
            <div class="form-row">
                <div class="form-group half">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="Enter First Name" required>
                    <span class="error-message" id="first_name-error"></span>
                </div>

                <div class="form-group half">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name" required>
                    <span class="error-message" id="last_name-error"></span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="Enter Phone Number" required>
                    <span class="error-message" id="phone_number-error"></span>
                </div>

                <div class="form-group half">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" required>
                    <span class="error-message" id="email-error"></span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <label for="home_town">Home Town</label>
                    <input type="text" id="home_town" name="home_town" placeholder="Enter Home Town" required>
                    <span class="error-message" id="home_town-error"></span>
                </div>

                <div class="form-group half">
                    <label for="district">District</label>
                    <select id="district" name="district" required>
                        <option value="">Select District</option>
                        <option value="Ampara">Ampara</option>
                        <option value="Anuradhapura">Anuradhapura</option>
                        <option value="Badulla">Badulla</option>
                        <option value="Batticaloa">Batticaloa</option>
                        <option value="Colombo">Colombo</option>
                        <option value="Galle">Galle</option>
                        <option value="Gampaha">Gampaha</option>
                        <option value="Hambantota">Hambantota</option>
                        <option value="Jaffna">Jaffna</option>
                        <option value="Kalutara">Kalutara</option>
                        <option value="Kandy">Kandy</option>
                        <option value="Kegalle">Kegalle</option>
                        <option value="Kilinochchi">Kilinochchi</option>
                        <option value="Kurunegala">Kurunegala</option>
                        <option value="Mannar">Mannar</option>
                        <option value="Matale">Matale</option>
                        <option value="Matara">Matara</option>
                        <option value="Monaragala">Monaragala</option>
                        <option value="Mullaitivu">Mullaitivu</option>
                        <option value="Nuwara Eliya">Nuwara Eliya</option>
                        <option value="Polonnaruwa">Polonnaruwa</option>
                        <option value="Puttalam">Puttalam</option>
                        <option value="Ratnapura">Ratnapura</option>
                        <option value="Trincomalee">Trincomalee</option>
                        <option value="Vavuniya">Vavuniya</option>
                    </select>
                    <span class="error-message" id="district-error"></span>
                </div>
            </div>

            <div class="button-rows">
                <button type="submit" class="submit-btn">
                    <i class="ri-user-add-line"></i> Add Employee
                </button>
              
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cancel button handler
        const cancelBtn = document.getElementById('cancelAddEmployee');
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