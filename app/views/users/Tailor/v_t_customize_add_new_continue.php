<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>
<div class="main-content">
    <div class="top-row">
        <div class="category-section">
            <h2>Category</h2>
            <p>Shirt</p>
        </div>
        <div class="subcategory-section">
            <h2>Sub Category</h2>
            <p>Long Sleeve</p>
        </div>
    </div>
    
    <div class="photo-section">
        <div class="photo-container">
            <img src="placeholder-image.jpg" alt="Product Photo">
            <p class="change-photo">Change Photo</p>
        </div>
    </div>

    <div class="option-section">
        <div class="top-row">
        <div class="option-group">
            <h3>Button Type</h3>
            <div class="option-photo">
               <div> <button class="upload-photo">Upload Photo</button>
                <input type="text" placeholder="Enter Name" class="name-input"></div>
               <div> <button class="upload-photo">Upload Photo</button>
                <input type="text" placeholder="Enter Name" class="name-input"></div>
               <div> <button class="upload-photo">Upload Photo</button>
                <input type="text" placeholder="Enter Name" class="name-input"></div>
            </div>
        </div>
        <div class="option-group">
            <h3>Collar Type</h3>
            <div class="option-photo">
                <div> <button class="upload-photo">Upload Photo</button>
                    <input type="text" placeholder="Enter Name" class="name-input"></div>
                   <div> <button class="upload-photo">Upload Photo</button>
                    <input type="text" placeholder="Enter Name" class="name-input"></div>
                   <div> <button class="upload-photo">Upload Photo</button>
                    <input type="text" placeholder="Enter Name" class="name-input"></div>
            </div>
        </div>
        <div class="option-group">
            <h3>Pocket Type</h3>
            <div class="option-photo">
                <div> <button class="upload-photo">Upload Photo</button>
                    <input type="text" placeholder="Enter Name" class="name-input"></div>
                   <div> <button class="upload-photo">Upload Photo</button>
                    <input type="text" placeholder="Enter Name" class="name-input"></div>
                   <div> <button class="upload-photo">Upload Photo</button>
                    <input type="text" placeholder="Enter Name" class="name-input"></div>
            </div>
        </div>
    </div>
</div>
    

    <div class="fabric-section">
        <h2>Fabric</h2>
        <table>
            <tr>
                <th>Fabric</th>
                <th>Available</th>
                <th>Act</th>
            </tr>
            <tr>
                <td>Linen</td>
                <td>
                    <span class="color-dot" style="background-color: black;"></span>
                    <span class="color-dot" style="background-color: grey;"></span>
                    <span class="color-dot" style="background-color: pink;"></span>
                </td>
                <td><button>Edit</button> <button>Delete</button></td>
            </tr>
            <tr>
                <td>Silk</td>
                <td>
                    <span class="color-dot" style="background-color: black;"></span>
                    <span class="color-dot" style="background-color: red;"></span>
                    <span class="color-dot" style="background-color: blue;"></span>
                    <span class="color-dot" style="background-color: yellow;"></span>
                </td>
                <td><button>Edit</button> <button>Delete</button></td>
            </tr>
            <tr>
                <td>Cotton</td>
                <td>
                    <span class="color-dot" style="background-color: maroon;"></span>
                    <span class="color-dot" style="background-color: navy;"></span>
                    <span class="color-dot" style="background-color: purple;"></span>
                </td>
                <td><button>Edit</button> <button>Delete</button></td>
            </tr>
        </table>
        <button class="add-new">+ Add New</button>
    </div>
</div>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>