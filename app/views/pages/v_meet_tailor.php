<?php require_once APPROOT . '/views/pages/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="slider">
   <div class="list">
       <div class="item">
            <img src="<?php echo URLROOT; ?>/public/img/home/chooseTailor.jpg">
            <div class="overlay"></div>

            <div class="content">
                <div class="title">Choose Your Tailor,<br> Right Now</div>
                <div class="des">
                We leave no detail to chance,<br>
                Advanced measurement tools ensure accuracy down to the millimeter.
                Fabric quality, pattern alignment, and stitching are rigorously checked to ensure every piece exceeds expectations.
                Every order is a complete package, tailored to perfection and delivered with care.
                </div>
                
            </div>
        </div>
    </div>
    <!-- Group thumbnails and arrows -->
    <div class="slider-controls">
        <div class="thumbnail">
            <div class="item active">
                <img src="<?php echo URLROOT; ?>/public/img/home/hero1.png">
            </div>
            <div class="item">
                <img src="<?php echo URLROOT; ?>/public/img/home/hero3.jpg">
            </div>
        </div>
        <div class="arrows">
            <button id="prev">&lt;</button>
            <button id="next">&gt;</button>
        </div>
    </div>
    <!-- time running -->
    <div class="time"></div>
</div>

  <!-- Filter Bar -->
  <div class="filter-bar">
    <div>
      <span style="font-weight: bold;">Filter By</span>
      <span>Gender</span>
      <span>Category</span>
      <span>Location</span>
    </div>
    <div class="reset-filter">Reset Filter</div>
  </div>

  <!-- Profile Cards -->
  <div class="profile-container">
    <div class="profile-card">
      <img src="girls1.jpg" alt="Profile Picture">
      <div class="details">
        <h3>Saduni Perera</h3>
        <p>Professional in Fashion Design</p>
      </div>
      <div class="actions">
        <button class="view-btn">View Profile</button>
        <button class="follow-btn">Follow</button>
        <button class="follow-btn">Appointment</button>
      </div>
    </div>

    <div class="profile-card">
      <img src="girls2.jpg" alt="Profile Picture">
      <div class="details">
        <h3>Kumudu Liyanage</h3>
        <p>Professional in Fashion Design</p>
      </div>
      <div class="actions">
        <button class="view-btn">View Profile</button>
        <button class="follow-btn">Follow</button>
        <button class="follow-btn">Appointment</button>
      </div>
    </div>

    <div class="profile-card">
      <img src="RayanCooray.jpeg" alt="Profile Picture">
      <div class="details">
        <h3>Rayan Cooray</h3>
        <p>Professional in Fashion Design</p>
      </div>
      <div class="actions">
        <button class="view-btn">View Profile</button>
        <button class="follow-btn">Follow</button>
        <button class="follow-btn">Appointment</button>
      </div>
    </div>
  </div>

  <!-- Pagination -->
  <div class="pagination">
    <div class="dot active"></div>
    <div class="dot"></div>
    <div class="dot"></div>
  </div>


