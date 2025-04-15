<div class="popup-overlay">
    <div class="popup-content">
        <button class="close-popup">&times;</button>
        
        <div class="top-row">
            <div class="category-section">
                <h2>Category</h2>
                <select id="category-select" name="category_id">
                    <?php foreach($data['categories'] ?? [] as $category): ?>
                        <option value="<?php echo $category->category_id; ?>"><?php echo htmlspecialchars($category->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="subcategory-section">
                <h2>Sub Category</h2>
                <select id="subcategory-select" name="subcategory_id">
                    <?php foreach($data['subcategories'] ?? [] as $subcategory): ?>
                        <option value="<?php echo $subcategory->subcategory_id; ?>"><?php echo htmlspecialchars($subcategory->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="photo-section">
            <div class="photo-container">
                <img src="<?php echo URLROOT . ($data['productImage']->image_path ?? '/public/img/add_image.png'); ?>" alt="Product Image" id="profile-preview">
                <input type="file" id="product-image-upload" style="display: none;">
                <p class="change-photo" onclick="document.getElementById('product-image-upload').click();">Change Photo</p>
            </div>
        </div>
        <div class="option-section">
            <div class="top-row">
                <div class="option-group">
                    <h3>Button Type</h3>
                    <div class="option-photo">
                        <?php foreach($data['buttonTypes'] ?? [] as $button): ?>
                        <div>
                            <div class="button-preview">
                                <img src="<?php echo URLROOT . $button->image_path; ?>" alt="<?php echo htmlspecialchars($button->name); ?>" class="option-image">
                            </div>
                            <p><?php echo htmlspecialchars($button->name); ?></p>
                        </div>
                        <?php endforeach; ?>
                        <div>
                            <button class="upload-photo" data-option-type="button">Add New</button>
                            <input type="text" placeholder="Enter Name" class="name-input">
                        </div>
                    </div>
                </div>
                <div class="option-group">
                    <h3>Collar Type</h3>
                    <div class="option-photo">
                        <?php foreach($data['collarTypes'] ?? [] as $collar): ?>
                        <div>
                            <div class="collar-preview">
                                <img src="<?php echo URLROOT . $collar->image_path; ?>" alt="<?php echo htmlspecialchars($collar->name); ?>" class="option-image">
                            </div>
                            <p><?php echo htmlspecialchars($collar->name); ?></p>
                        </div>
                        <?php endforeach; ?>
                        <div>
                            <button class="upload-photo" data-option-type="collar">Add New</button>
                            <input type="text" placeholder="Enter Name" class="name-input">
                        </div>
                    </div>
                </div>
                <div class="option-group">
                    <h3>Pocket Type</h3>
                    <div class="option-photo">
                        <?php foreach($data['pocketTypes'] ?? [] as $pocket): ?>
                        <div>
                            <div class="pocket-preview">
                                <img src="<?php echo URLROOT . $pocket->image_path; ?>" alt="<?php echo htmlspecialchars($pocket->name); ?>" class="option-image">
                            </div>
                            <p><?php echo htmlspecialchars($pocket->name); ?></p>
                        </div>
                        <?php endforeach; ?>
                        <div>
                            <button class="upload-photo" data-option-type="pocket">Add New</button>
                            <input type="text" placeholder="Enter Name" class="name-input">
                        </div>
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
                <?php if(isset($data['fabrics'])): ?>
                    <?php foreach($data['fabrics'] as $fabric): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fabric['name']); ?></td>
                        <td>
                            <?php foreach($fabric['colors'] as $color): ?>
                                <span class="color-dot" style="background-color: <?php echo htmlspecialchars($color['hex_code']); ?>;" title="<?php echo htmlspecialchars($color['color_name']); ?>"></span>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <button class="action-btn edit-btn" data-id="<?php echo $fabric['id']; ?>">✎</button>
                            <button class="action-btn delete-btn" data-id="<?php echo $fabric['id']; ?>">🗑</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <!-- ... existing hardcoded fabric rows ... -->
                <?php endif; ?>
            </table>
            <div class="popup-footer">
                <button class="add-new">Submit</button>
                <button class="btn-cancel">Reset</button>
            </div>
        </div>
    </div>
</div>

<style>
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    
    .popup-content {
        background-color: white;
        width: 95%;
        height: 95%;
        max-width: 1400px;
        padding: 20px;
        position: relative;
        overflow: auto;
    }
    
    .close-popup {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        z-index: 1001;
    }
    
    .popup-footer {
        display: flex;
        justify-content: flex-end;
        padding: 15px 0;
        gap: 10px;
    }
</style>

<script>
    // Category change event handler
    document.getElementById('category-select')?.addEventListener('change', function() {
        const categoryId = this.value;
        fetch(`<?php echo URLROOT; ?>/customize/getSubcategories/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                const subcategorySelect = document.getElementById('subcategory-select');
                subcategorySelect.innerHTML = '';
                
                data.forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory.subcategory_id;
                    option.textContent = subcategory.name;
                    subcategorySelect.appendChild(option);
                });
                
                updateProductImage();
            });
    });
    
    // Subcategory change event handler
    document.getElementById('subcategory-select')?.addEventListener('change', function() {
        updateProductImage();
    });
    
    // Update product image based on category and subcategory
    function updateProductImage() {
        const categoryId = document.getElementById('category-select').value;
        const subcategoryId = document.getElementById('subcategory-select').value;
        
        fetch(`<?php echo URLROOT; ?>/customize/getProductImage/${categoryId}/${subcategoryId}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.image_path) {
                    document.getElementById('profile-preview').src = '<?php echo URLROOT; ?>' + data.image_path;
                }
            });
    }
    
    // Handle product image upload
    document.getElementById('product-image-upload').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const formData = new FormData();
            formData.append('image', this.files[0]);
            formData.append('category_id', document.getElementById('category-select').value);
            formData.append('subcategory_id', document.getElementById('subcategory-select').value);
            
            fetch('<?php echo URLROOT; ?>/customize/uploadProductImage', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('profile-preview').src = '<?php echo URLROOT; ?>' + data.image_path;
                } else {
                    alert('Error uploading image: ' + data.message);
                }
            });
        }
    });
    
    // Handle option uploads (button, collar, pocket)
    document.querySelectorAll('.upload-photo').forEach(button => {
        button.addEventListener('click', function() {
            const optionType = this.getAttribute('data-option-type');
            const nameInput = this.nextElementSibling;
            const name = nameInput.value.trim();
            
            if (!name) {
                alert('Please enter a name for the new option');
                return;
            }
            
            // Create file input dynamically
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.style.display = 'none';
            document.body.appendChild(fileInput);
            
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const formData = new FormData();
                    formData.append('image', this.files[0]);
                    formData.append('name', name);
                    formData.append('option_type', optionType);
                    
                    fetch(`<?php echo URLROOT; ?>/customize/addOption`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Option added successfully!');
                            location.reload();
                        } else {
                            alert('Error adding option: ' + data.message);
                        }
                    });
                }
                document.body.removeChild(fileInput);
            });
            
            fileInput.click();
        });
    });
    
    // Delete fabric
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this fabric?')) {
                const fabricId = this.getAttribute('data-id');
                
                fetch(`<?php echo URLROOT; ?>/customize/deleteFabric/${fabricId}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('tr').remove();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        });
    });
    
    // Close popup
    document.querySelector('.close-popup').addEventListener('click', function() {
        document.querySelector('.popup-overlay').style.display = 'none';
    });
</script>