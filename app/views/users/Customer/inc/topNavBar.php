<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<div class="Section-content">
  <div class="header">
    <h1 class="main-title"><?php echo $data['title']; ?></h1>
<<<<<<< Updated upstream
    <div class="actions">
      <div class="search-bar">
        <input type="text" placeholder="Type to search">
        <button><i><img src="<?php echo URLROOT; ?>/public/img/Search.png"></i></button>
      </div>
      <button style="width: 20px; height: 20px; background-color: transparent; border: none;">
  <i>
    <img src="<?php echo URLROOT; ?>/public/img/Icon.png" style="width: 15px; height: 15px;">
  </i>
</button>

<button style="width: 20px; height: 20px; background-color: transparent; border: none;">
  <i>
    <img src="<?php echo URLROOT; ?>/public/img/cart1.png" style="width: 15px; height: 15px;">
  </i>
</button>

      <div class="dropdown">
        <button class="tailor-drop-down "><i><img src="<?php echo URLROOT; ?>/public/img/Icon-1.png"></i></button>
        <div class="dropdown-content">
          <a href="<?php echo URLROOT; ?>/Users/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
=======
    <div class="navbar-right-section">
      <div class="actions">
        <div class="search-bar">
          <input type="text" placeholder="Type to search">
          <button><i><img src="<?php echo URLROOT; ?>/public/img/Search.png"></i></button>
        </div>
        <a href="<?php echo URLROOT ?>/Action/index"><button class="icon-button"><i class="fas fa-envelope"></i></button></a>
        <button class="icon-button"><i class="fas fa-bell"></i></button>
        <div class="dropdown">
          <button class="tailor-drop-down"><i class="fas fa-sign-out-alt"></i></button>
          <div class="dropdown-content">
            <a href="<?php echo URLROOT; ?>/Users/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </div>
>>>>>>> Stashed changes
        </div>
      </div>
      <a href="<?php echo URLROOT ?>/Customers/profileUpdate">
        <div class="user-info">
          <span>
            <?php if (isset($_SESSION['user_first_name'])): ?>
              <?php echo $_SESSION['user_first_name']; ?>
            <?php else: ?>
              Guest
            <?php endif; ?>
          </span>
          <?php if (!empty($_SESSION['user_profile_pic'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['user_profile_pic']); ?>" alt="User Avatar">
          <?php else: ?>
            <img src="<?php echo URLROOT; ?>/public/img/Avatar.png" alt="User Avatar">
          <?php endif; ?>
        </div>
      </a>
    </div>
  </div>
