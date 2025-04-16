<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/shopkeeper/styles.css">

<div class="popup-overlay">
    <div class="popup-content">
        <!-- Fix the close button by using a more direct approach -->
        <button class="close-popup" onclick="window.location.href='<?php echo URLROOT; ?>/Shopkeepers/displayCustomizeItems'">&times;</button>
        <h1>Customization Options Management</h1>
        
        <!-- Tabs for different option types -->
        <div class="tabs">
            <button class="tab-link active" onclick="openTab(event, 'categories-tab')">Categories</button>
            <button class="tab-link" onclick="openTab(event, 'subcategories-tab')">Sub Categories</button>
            <button class="tab-link" onclick="openTab(event, 'buttons-tab')">Button Types</button>
            <button class="tab-link" onclick="openTab(event, 'collars-tab')">Collar Types</button>
            <button class="tab-link" onclick="openTab(event, 'pockets-tab')">Pocket Types</button>
            <!-- Removed Fabrics tab button -->
        </div>
        
        <!-- Categories Tab -->
        <div id="categories-tab" class="tab-content active">
            <div class="management-section">
                <h2>Manage Categories</h2>
                <table class="management-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['categories'] ?? [] as $category): ?>
                        <tr>
                            <td><?php echo $category->category_id; ?></td>
                            <td><?php echo htmlspecialchars($category->name); ?></td>
                            <td class="actions">
                                <button class="edit-btn" onclick="editCategory(<?php echo $category->category_id; ?>, '<?php echo htmlspecialchars($category->name); ?>')">Edit</button>
                                <button class="delete-btn" onclick="deleteCategory(<?php echo $category->category_id; ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="add-form">
                    <h3>Add New Option</h3>
                    <form id="add-category-form" action="<?php echo URLROOT; ?>/customize/addCategory" method="POST">
                        <div class="form-group">
                            <label for="category-name">Category Name:</label>
                            <input type="text" id="category-name" name="name" maxlength="50" required>
                        </div>
                        <button type="submit" class="btn-submit">Add Option</button>
                    </form>
                </div>
                
                <!-- Edit Category Modal -->
                <div id="edit-category-modal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('edit-category-modal')">&times;</span>
                        <h3>Edit Category</h3>
                        <form id="edit-category-form" action="<?php echo URLROOT; ?>/customize/updateCategory" method="POST">
                            <input type="hidden" id="edit-category-id" name="category_id">
                            <div class="form-group">
                                <label for="edit-category-name">Category Name:</label>
                                <input type="text" id="edit-category-name" name="name" maxlength="50" required>
                            </div>
                            <button type="submit" class="btn-submit">Update Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Subcategories Tab -->
        <div id="subcategories-tab" class="tab-content">
            <div class="management-section">
                <h2>Manage Sub Categories</h2>
                <table class="management-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($data['allSubcategories'])): ?>
                            <?php foreach($data['allSubcategories'] as $subcategory): ?>
                            <tr>
                                <td><?php echo $subcategory->subcategory_id; ?></td>
                                <td><?php echo htmlspecialchars($subcategory->name); ?></td>
                                <td><?php echo htmlspecialchars($subcategory->category_name); ?></td>
                                <td class="actions">
                                    <button class="edit-btn" onclick="editSubcategory(<?php echo $subcategory->subcategory_id; ?>, '<?php echo htmlspecialchars($subcategory->name); ?>', <?php echo $subcategory->category_id; ?>)">Edit</button>
                                    <button class="delete-btn" onclick="deleteSubcategory(<?php echo $subcategory->subcategory_id; ?>)">Delete</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                
                <div class="add-form">
                    <h3>Add New Sub Category</h3>
                    <form id="add-subcategory-form" action="<?php echo URLROOT; ?>/customize/addSubcategory" method="POST">
                        <div class="form-group">
                            <label for="subcategory-category">Parent Category:</label>
                            <select id="subcategory-category" name="category_id" required>
                                <option value="">-- Select Category --</option>
                                <?php foreach($data['categories'] ?? [] as $category): ?>
                                    <option value="<?php echo $category->category_id; ?>"><?php echo htmlspecialchars($category->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subcategory-name">Sub Category Name:</label>
                            <input type="text" id="subcategory-name" name="name" maxlength="50" required>
                        </div>
                        <button type="submit" class="btn-submit">Add Sub Category</button>
                    </form>
                </div>
                
                <!-- Edit Subcategory Modal -->
                <div id="edit-subcategory-modal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('edit-subcategory-modal')">&times;</span>
                        <h3>Edit Sub Category</h3>
                        <form id="edit-subcategory-form" action="<?php echo URLROOT; ?>/customize/updateSubcategory" method="POST">
                            <input type="hidden" id="edit-subcategory-id" name="subcategory_id">
                            <div class="form-group">
                                <label for="edit-subcategory-category">Parent Category:</label>
                                <select id="edit-subcategory-category" name="category_id" required>
                                    <?php foreach($data['categories'] ?? [] as $category): ?>
                                        <option value="<?php echo $category->category_id; ?>"><?php echo htmlspecialchars($category->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit-subcategory-name">Sub Category Name:</label>
                                <input type="text" id="edit-subcategory-name" name="name" maxlength="50" required>
                            </div>
                            <button type="submit" class="btn-submit">Update Sub Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Button Types Tab -->
        <div id="buttons-tab" class="tab-content">
            <div class="management-section">
                <h2>Manage Button Types</h2>
                <div class="option-grid">
                    <?php foreach($data['buttonTypes'] ?? [] as $button): ?>
                    <div class="option-card">
                        <div class="option-image">
                            <img src="<?php echo URLROOT . $button->image_path; ?>" alt="<?php echo htmlspecialchars($button->name); ?>">
                        </div>
                        <div class="option-details">
                            <h4><?php echo htmlspecialchars($button->name); ?></h4>
                            <div class="option-actions">
                                <button class="edit-btn" onclick="editButtonType(<?php echo $button->button_id; ?>, '<?php echo htmlspecialchars($button->name); ?>')">Edit</button>
                                <button class="delete-btn" onclick="deleteButtonType(<?php echo $button->button_id; ?>)">Delete</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="add-form">
                    <h3>Add New Button Type</h3>
                    <form id="add-button-form" action="<?php echo URLROOT; ?>/customize/addButtonType" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="button-name">Button Type Name:</label>
                            <input type="text" id="button-name" name="name" maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label for="button-image">Button Image:</label>
                            <input type="file" id="button-image" name="image" required>
                        </div>
                        <button type="submit" class="btn-submit">Add Button Type</button>
                    </form>
                </div>
                
                <!-- Edit Button Type Modal -->
                <div id="edit-button-modal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('edit-button-modal')">&times;</span>
                        <h3>Edit Button Type</h3>
                        <form id="edit-button-form" action="<?php echo URLROOT; ?>/customize/updateButtonType" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="edit-button-id" name="button_id">
                            <div class="form-group">
                                <label for="edit-button-name">Button Type Name:</label>
                                <input type="text" id="edit-button-name" name="name" maxlength="50" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-button-image">Button Image (leave empty to keep current):</label>
                                <input type="file" id="edit-button-image" name="image">
                            </div>
                            <button type="submit" class="btn-submit">Update Button Type</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Collar Types Tab -->
        <div id="collars-tab" class="tab-content">
            <div class="management-section">
                <h2>Manage Collar Types</h2>
                <div class="option-grid">
                    <?php foreach($data['collarTypes'] ?? [] as $collar): ?>
                    <div class="option-card">
                        <div class="option-image">
                            <img src="<?php echo URLROOT . $collar->image_path; ?>" alt="<?php echo htmlspecialchars($collar->name); ?>">
                        </div>
                        <div class="option-details">
                            <h4><?php echo htmlspecialchars($collar->name); ?></h4>
                            <div class="option-actions">
                                <button class="edit-btn" onclick="editCollarType(<?php echo $collar->collar_id; ?>, '<?php echo htmlspecialchars($collar->name); ?>')">Edit</button>
                                <button class="delete-btn" onclick="deleteCollarType(<?php echo $collar->collar_id; ?>)">Delete</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="add-form">
                    <h3>Add New Collar Type</h3>
                    <form id="add-collar-form" action="<?php echo URLROOT; ?>/customize/addCollarType" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="collar-name">Collar Type Name:</label>
                            <input type="text" id="collar-name" name="name" maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label for="collar-image">Collar Image:</label>
                            <input type="file" id="collar-image" name="image" required>
                        </div>
                        <button type="submit" class="btn-submit">Add Collar Type</button>
                    </form>
                </div>
                
                <!-- Edit Collar Type Modal -->
                <div id="edit-collar-modal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('edit-collar-modal')">&times;</span>
                        <h3>Edit Collar Type</h3>
                        <form id="edit-collar-form" action="<?php echo URLROOT; ?>/customize/updateCollarType" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="edit-collar-id" name="collar_id">
                            <div class="form-group">
                                <label for="edit-collar-name">Collar Type Name:</label>
                                <input type="text" id="edit-collar-name" name="name" maxlength="50" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-collar-image">Collar Image (leave empty to keep current):</label>
                                <input type="file" id="edit-collar-image" name="image">
                            </div>
                            <button type="submit" class="btn-submit">Update Collar Type</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pocket Types Tab -->
        <div id="pockets-tab" class="tab-content">
            <div class="management-section">
                <h2>Manage Pocket Types</h2>
                <div class="option-grid">
                    <?php foreach($data['pocketTypes'] ?? [] as $pocket): ?>
                    <div class="option-card">
                        <div class="option-image">
                            <img src="<?php echo URLROOT . $pocket->image_path; ?>" alt="<?php echo htmlspecialchars($pocket->name); ?>">
                        </div>
                        <div class="option-details">
                            <h4><?php echo htmlspecialchars($pocket->name); ?></h4>
                            <div class="option-actions">
                                <button class="edit-btn" onclick="editPocketType(<?php echo $pocket->pocket_id; ?>, '<?php echo htmlspecialchars($pocket->name); ?>')">Edit</button>
                                <button class="delete-btn" onclick="deletePocketType(<?php echo $pocket->pocket_id; ?>)">Delete</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="add-form">
                    <h3>Add New Pocket Type</h3>
                    <form id="add-pocket-form" action="<?php echo URLROOT; ?>/customize/addPocketType" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="pocket-name">Pocket Type Name:</label>
                            <input type="text" id="pocket-name" name="name" maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label for="pocket-image">Pocket Image:</label>
                            <input type="file" id="pocket-image" name="image" required>
                        </div>
                        <button type="submit" class="btn-submit">Add Pocket Type</button>
                    </form>
                </div>
                
                <!-- Edit Pocket Type Modal -->
                <div id="edit-pocket-modal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('edit-pocket-modal')">&times;</span>
                        <h3>Edit Pocket Type</h3>
                        <form id="edit-pocket-form" action="<?php echo URLROOT; ?>/customize/updatePocketType" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="edit-pocket-id" name="pocket_id">
                            <div class="form-group">
                                <label for="edit-pocket-name">Pocket Type Name:</label>
                                <input type="text" id="edit-pocket-name" name="name" maxlength="50" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-pocket-image">Pocket Image (leave empty to keep current):</label>
                                <input type="file" id="edit-pocket-image" name="image">
                            </div>
                            <button type="submit" class="btn-submit">Update Pocket Type</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Removed Fabrics Tab content -->
    </div>
</div>

<script>
    // Tab switching functionality
    function openTab(evt, tabName) {
        // Hide all tab content
        const tabContents = document.getElementsByClassName("tab-content");
        for (let i = 0; i < tabContents.length; i++) {
            tabContents[i].style.display = "none";
        }
        
        // Remove active class from all tab links
        const tabLinks = document.getElementsByClassName("tab-link");
        for (let i = 0; i < tabLinks.length; i++) {
            tabLinks[i].className = tabLinks[i].className.replace(" active", "");
        }
        
        // Show the selected tab and add active class to the button
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    
    // Modal functions
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }
    
    // Category CRUD
    function editCategory(id, name) {
        document.getElementById('edit-category-id').value = id;
        document.getElementById('edit-category-name').value = name;
        document.getElementById('edit-category-modal').style.display = "block";
    }
    
    function deleteCategory(id) {
        if (confirm('Are you sure you want to delete this category? This will also delete all associated subcategories.')) {
            fetch(`<?php echo URLROOT; ?>/customize/deleteCategory/${id}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }
    }
    
    // Subcategory CRUD
    function editSubcategory(id, name, categoryId) {
        document.getElementById('edit-subcategory-id').value = id;
        document.getElementById('edit-subcategory-name').value = name;
        document.getElementById('edit-subcategory-category').value = categoryId;
        document.getElementById('edit-subcategory-modal').style.display = "block";
    }
    
    function deleteSubcategory(id) {
        if (confirm('Are you sure you want to delete this subcategory?')) {
            fetch(`<?php echo URLROOT; ?>/customize/deleteSubcategory/${id}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }
    }
    
    // Button Type CRUD
    function editButtonType(id, name) {
        document.getElementById('edit-button-id').value = id;
        document.getElementById('edit-button-name').value = name;
        document.getElementById('edit-button-modal').style.display = "block";
    }
    
    function deleteButtonType(id) {
        if (confirm('Are you sure you want to delete this button type?')) {
            fetch(`<?php echo URLROOT; ?>/customize/deleteButtonType/${id}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }
    }
    
    // Collar Type CRUD
    function editCollarType(id, name) {
        document.getElementById('edit-collar-id').value = id;
        document.getElementById('edit-collar-name').value = name;
        document.getElementById('edit-collar-modal').style.display = "block";
    }
    
    function deleteCollarType(id) {
        if (confirm('Are you sure you want to delete this collar type?')) {
            fetch(`<?php echo URLROOT; ?>/customize/deleteCollarType/${id}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }
    }
    
    // Pocket Type CRUD
    function editPocketType(id, name) {
        document.getElementById('edit-pocket-id').value = id;
        document.getElementById('edit-pocket-name').value = name;
        document.getElementById('edit-pocket-modal').style.display = "block";
    }
    
    function deletePocketType(id) {
        if (confirm('Are you sure you want to delete this pocket type?')) {
            fetch(`<?php echo URLROOT; ?>/customize/deletePocketType/${id}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }
    }
    
    // Removed Fabric CRUD functions
    
    // Color CRUD
    function editColor(id, name, hexCode) {
        alert('Edit functionality for colors needs to be implemented');
    }
    
    function deleteColor(id) {
        if (confirm('Are you sure you want to delete this color?')) {
            fetch(`<?php echo URLROOT; ?>/customize/deleteColor/${id}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }
    }
    
    // Initialize the first tab
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementsByClassName('tab-link')[0].click();
    });
    
    // Function to go back to customize_item_list
    function goBackToList() {
        console.log("Close button clicked"); // Debug log
        window.location.href = '<?php echo URLROOT; ?>Shopkeepers/displayCustomizeItems';
    }
    
    // Remove the event listener that might be causing issues
    /*
    document.querySelector('.close-popup').addEventListener('click', function() {
        goBackToList();
    });
    */
</script>