<?php
class M_Cart {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Add item to cart
    public function addToCart($userId, $designId, $fabricId, $colorId, $quantity = 1) {
        // Check if item already exists in cart
        $this->db->query('SELECT * FROM cart_items WHERE user_id = :user_id AND design_id = :design_id AND fabric_id = :fabric_id AND color_id = :color_id');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':design_id', $designId);
        $this->db->bind(':fabric_id', $fabricId);
        $this->db->bind(':color_id', $colorId);
        $existingItem = $this->db->single();
        
        if ($existingItem) {
            // Update quantity
            $this->db->query('UPDATE cart_items SET quantity = quantity + :quantity WHERE id = :id');
            $this->db->bind(':quantity', $quantity);
            $this->db->bind(':id', $existingItem->id);
            return $this->db->execute();
        } else {
            // Add new item
            $this->db->query('INSERT INTO cart_items (user_id, design_id, fabric_id, color_id, quantity) VALUES (:user_id, :design_id, :fabric_id, :color_id, :quantity)');
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':design_id', $designId);
            $this->db->bind(':fabric_id', $fabricId);
            $this->db->bind(':color_id', $colorId);
            $this->db->bind(':quantity', $quantity);
            return $this->db->execute();
        }
    }

    // Get user's cart items with product details
    public function getCartItems($userId) {
        $this->db->query('
            SELECT ci.*, d.name as design_name, d.main_image as design_image, 
                  d.base_price, f.fabric_name, c.color_name,
                  u.user_id as tailor_id, CONCAT(u.first_name, " ", u.last_name) as tailor_name
            FROM cart_items ci
            JOIN designs d ON ci.design_id = d.design_id
            JOIN fabrics f ON ci.fabric_id = f.fabric_id
            JOIN colors c ON ci.color_id = c.color_id
            JOIN users u ON d.user_id = u.user_id
            WHERE ci.user_id = :user_id
            ORDER BY ci.added_at DESC
        ');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    // Remove item from cart
    public function removeFromCart($cartItemId, $userId) {
        $this->db->query('DELETE FROM cart_items WHERE id = :id AND user_id = :user_id');
        $this->db->bind(':id', $cartItemId);
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }

    // Clear all items from cart
    public function clearCart($userId) {
        $this->db->query('DELETE FROM cart_items WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }

    // Get cart count for navbar badge
    public function getCartCount($userId) {
        $this->db->query('SELECT SUM(quantity) as count FROM cart_items WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        return $result->count ?? 0;
    }
}