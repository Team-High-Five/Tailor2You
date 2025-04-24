<?php
class FileUploader
{
    public static function uploadImage($file, $targetDir, $prefix = '')
    {
        // Check if file exists and has no errors
        if (!isset($file) || empty($file) || $file['error'] !== UPLOAD_ERR_OK) {
            error_log('File upload error: ' . ($file['error'] ?? 'No file'));
            return false;
        }

        // Validate file is an image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            error_log('Invalid file type: ' . $file['type']);
            return false;
        }

        // Create directory path using filesystem paths, not URLs
        $uploadDir = dirname(dirname(__DIR__)) . '/public/img/uploads/' . $targetDir . '/';

        // Debug
        error_log("Upload directory path: " . $uploadDir);

        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                error_log('Failed to create directory: ' . $uploadDir);
                return false;
            }
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $prefix . uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $filename;

        // Move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $filename;
        } else {
            error_log('Failed to move uploaded file: ' . $targetPath);
            return false;
        }
    }
}
