<?php
// Load appropriate header files based on user type
if ($_SESSION['user_type'] === 'tailor') {
    $data['title'] = 'Messages | Tailor Dashboard';
    require_once APPROOT . '/views/users/Tailor/inc/Header.php';
    require_once APPROOT . '/views/users/Tailor/inc/SideBar.php';
    require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php';
} elseif ($_SESSION['user_type'] === 'customer') {
    $data['title'] = 'Messages | Customer Dashboard';
    require_once APPROOT . '/views/users/Customer/inc/Header.php';
    require_once APPROOT . '/views/users/Customer/inc/sideBar.php';
    require_once APPROOT . '/views/users/Customer/inc/topNavBar.php';
} elseif ($_SESSION['user_type'] === 'shopkeeper') {
    $data['title'] = 'Messages | Shopkeeper Dashboard';
    require_once APPROOT . '/views/users/ShopKeeper/inc/Header.php';
    require_once APPROOT . '/views/users/ShopKeeper/inc/SideBar.php';
    require_once APPROOT . '/views/users/ShopKeeper/inc/topNavBar.php';
} elseif ($_SESSION['user_type'] === 'admin') {
    $data['title'] = 'Messages | Admin Dashboard';
    require_once APPROOT . '/views/inc/admin/adminheader.php';
    require_once APPROOT . '/views/inc/admin/adminsidebar.php';
}
?>


<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Messages</h1>
        <p class="page-subtitle">Manage your conversations with other users</p>

    </div>

    <div class="chat-interface">
        <!-- Conversation List Sidebar -->
        <div class="card chat-sidebar">

            <div class="card-body p-0">
                <button class="btn btn-primary" id="newConversationBtn"> + New Conversation</button>
                <ul class="conversation-list">
                    <?php if (!empty($data['conversations']) && is_array($data['conversations'])): ?>
                        <?php foreach ($data['conversations'] as $conversation): ?>
                            <li class="conversation-item">
                                <a href="<?php echo URLROOT; ?>/Chat/index/<?php echo $conversation->other_user_id; ?>">
                                    <div class="user-icon">
                                        <span><?php echo strtoupper(substr($conversation->receiver_name, 0, 1)); ?></span>
                                    </div>
                                    <div class="user-details">
                                        <span class="user-name"><?php echo $conversation->receiver_name; ?></span>
                                        <span class="last-message"><?php echo $conversation->last_message; ?></span>
                                    </div>
                                    <div class="conversation-meta">
                                        <span
                                            class="message-time"><?php echo date('h:i A', strtotime($conversation->last_message_date)); ?></span>
                                        <?php if (!empty($conversation->unread_count)): ?>
                                            <span class="unread-count"><?php echo $conversation->unread_count; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-data-message">
                            <i class="fas fa-comments-alt"></i>
                            <p>No conversations yet</p>
                            <a href="#contactModal" class="btn btn-outline-primary btn-sm">Start a conversation</a>
                        </div>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Chat Box -->
        <div class="card chat-box">
            <?php if (!empty($data['receiver_id'])): ?>
                <div class="chat-header">
                    <span class="user-name">
                        <?php echo isset($data['receiver']) && is_object($data['receiver']) ? $data['receiver']->first_name . ' ' . $data['receiver']->last_name : 'Unknown User'; ?>
                    </span>
                </div>
                <div class="chat-messages">
                    <?php if (!empty($data['messages']) && is_array($data['messages'])): ?>
                        <?php foreach ($data['messages'] as $message): ?>
                            <div class="message <?php echo $message->sender_id == $_SESSION['user_id'] ? 'sent' : 'received'; ?>">
                                <div class="message-content">
                                    <p><?php echo htmlspecialchars($message->text); ?></p>
                                </div>
                                <span class="message-time"><?php echo date('h:i A', strtotime($message->created_at)); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No messages available.</p>
                    <?php endif; ?>
                </div>
                <div class="chat-input">
                    <form action="<?php echo URLROOT; ?>/Chat/sendMessage" method="POST" class="message-form">
                        <input type="hidden" name="receiver_id" value="<?php echo $data['receiver_id']; ?>">
                        <input type="text" name="message" class="form-control" placeholder="Type your message here..."
                            required>
                        <button type="submit" class="send-button">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="no-conversation-selected">
                    <p>Select a conversation to start chatting.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>

<!-- Modal for Contact List -->
<div id="contactModal" class="modal">
    <div class="chat-modal-content">
        <a href="#" class="close">&times;</a>
        <div class="contact-container">
            <div class="sidebar-header">
                Contact List
            </div>
            <ul class="contact-list">
                <?php if (!empty($data['users']) && is_array($data['users'])): ?>
                    <?php foreach ($data['users'] as $user): ?>
                        <li class="contact-item">
                            <a href="<?php echo URLROOT; ?>/Chat/index/<?php echo $user->user_id; ?>">
                                <div class="user-icon">
                                    <span><?php echo strtoupper(substr($user->first_name, 0, 1)) . strtoupper(substr($user->last_name, 0, 1)); ?></span>
                                </div>
                                <div class="user-details">
                                    <span class="user-name">
                                        <?php echo $user->first_name . ' ' . $user->last_name; ?>
                                        <small class="user-type">(<?php echo ucfirst($user->user_type); ?>)</small>
                                    </span>
                                    <span class="user-info">User ID: <?php echo $user->user_id; ?></span>
                                    <span class="user-info">Phone: <?php echo isset($user->phone_number) ? $user->phone_number : 'N/A'; ?></span>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-contacts">No contacts available.</p>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<script>
    // JavaScript to handle modal opening and closing
    document.getElementById('newConversationBtn').onclick = function () {
        document.getElementById('contactModal').style.display = 'block';
    }

    document.querySelector('.close').onclick = function () {
        document.getElementById('contactModal').style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == document.getElementById('contactModal')) {
            document.getElementById('contactModal').style.display = 'none';
        }
    }
</script>
<?php
// Include appropriate footer based on user type
if ($_SESSION['user_type'] === 'tailor') {
    require_once APPROOT . '/views/users/Tailor/inc/footer.php';
} elseif ($_SESSION['user_type'] === 'customer') {
    require_once APPROOT . '/views/users/Customer/inc/footer.php';
} elseif ($_SESSION['user_type'] === 'shopkeeper') {
    require_once APPROOT . '/views/users/ShopKeeper/inc/footer.php';
} elseif ($_SESSION['user_type'] === 'admin') {
    require_once APPROOT . '/views/inc/admin/adminfooter.php';
}
?>