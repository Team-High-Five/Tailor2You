<div class="Section-content">
  <div class="header">
    <h1 class="main-title"><?php echo $data['title']; ?></h1>
    <div class="actions">
      <div class="search-bar">
        <input type="text" placeholder="Type to search">
        <button><i><img src="../<?php APPROOT ?>/public/img/Search.png"></i></button>
      </div>
      <button><i><img src="../<?php APPROOT ?>/public/img/Icon.png"></i></button>
      <button><i><img src="../<?php APPROOT ?>/public/img/Icon-1.png"></i></button>
      <div class="user-info">
        <span>
          <?php if (isset($_SESSION['tailor_first_name'])): ?>
            <?php echo $_SESSION['tailor_first_name']; ?>
          <?php else: ?>
            Guest
          <?php endif; ?>
        </span>
        <img src="../<?php APPROOT ?>/public/img/Avatar.png" alt="User Avatar">
      </div>
    </div>
  </div>