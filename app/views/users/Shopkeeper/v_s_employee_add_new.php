<div class="add-new-fabric-container">
    <div class="add-new-fabric-content">
        <div class="modal-header">
            <h1>Add New Employee</h1>
            <button class="close-btn" onclick="document.getElementById('employeeModal').style.display='none'">&times;</button>
        </div>
        <div class="fabric-form-container">
            <form id="addEmployeeForm" action="<?php echo URLROOT; ?>/Shopkeepers/addNewEmployee" method="post" enctype="multipart/form-data">
                <div class="post-pic-wrapper">
                    <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Employee Picture" id="post-preview">
                </div>
                <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
                <span class="error-message" id="image-error"></span>

                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="Enter First Name" required>
                    <span class="error-message" id="first_name-error"></span>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name" required>
                    <span class="error-message" id="last_name-error"></span>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="Enter Phone Number" required>
                    <span class="error-message" id="phone_number-error"></span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter Email" required>
                    <span class="error-message" id="email-error"></span>
                </div>
                <div class="form-group">
                    <label for="home_town">Home Town</label>
                    <input type="text" id="home_town" name="home_town" placeholder="Enter Home Town" required>
                    <span class="error-message" id="home_town-error"></span>
                </div>
                <div class="form-group">
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
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
</div>
