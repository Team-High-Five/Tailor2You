<?php require_once APPROOT . '/views/users/Shopkeeper/inc/Header.php'; ?>

<div class="edit-post-container">
    <div class="edit-post-content centered-card">
        <div class="modal-header">
            <h1>Edit Post</h1>
            <button class="close-btn">&times;</button>
        </div>
        <div class="post-form-container">
            <form id="editPostForm" action="<?php echo URLROOT; ?>/shopkeepers/editPost/<?php echo $data['post_id']; ?>" method="post" enctype="multipart/form-data">
                <div class="post-pic-wrapper">
                    <?php if (!empty($data['image'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($data['image']); ?>" alt="Post Image" id="post-preview">
                    <?php else: ?>
                        <img src="<?php echo URLROOT; ?>/public/img/add-image.png" alt="Post Image" id="post-preview">
                    <?php endif; ?>
                </div>
                <input type="file" id="upload-photo" name="image" accept="image/*" style="display: none;">
                <span class="error-message" id="image-error"></span>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="<?php echo $data['title']; ?>" required>
                    <span class="error-message" id="title-error"></span>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="5" required><?php echo $data['description']; ?></textarea>
                    <span class="error-message" id="description-error"></span>
                </div>
                <button type="submit" class="submit-btn">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<style>
    .centered-card {
        margin: 0 auto;
        max-width: 600px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        position: relative;
    }
    .edit-post-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .close-btn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
    }
</style>

<?php require_once APPROOT . '/views/users/Shopkeeper/inc/footer.php'; ?>
