<?php require_once APPROOT . '/views/users/Tailor/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Shopkeeper/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Tailor/inc/topNavBar.php'; ?>

<div class="main-content">
  <div class="stats">
    <div class="card orders-card">
      <div class="card-icon"><i class="ri-shopping-cart-line"></i></div>
      <h3>Total Orders</h3>
      <div class="card-value">10,293</div>
      <div class="card-trend trend-up">
        <i class="ri-arrow-up-line trend-icon"></i>
        1.3% Up from past week
      </div>
    </div>
    <div class="card sales-card">
      <div class="card-icon"><i class="ri-money-dollar-circle-line"></i></div>
      <h3>Total Sales</h3>
      <div class="card-value">$89,000</div>
      <div class="card-trend trend-down">
        <i class="ri-arrow-down-line trend-icon"></i>
        4.3% Down from yesterday
      </div>
    </div>
    <div class="card appointments-card">
      <div class="card-icon"><i class="ri-calendar-check-line"></i></div>
      <h3>Total Appointments</h3>
      <div class="card-value">2,040</div>
      <div class="card-trend trend-up">
        <i class="ri-arrow-up-line trend-icon"></i>
        1.8% Up from yesterday
      </div>
    </div>
  </div>
</div>

<script>
  // Optional: Add some interactive animations
  document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      card.style.setProperty('--mouse-x', `${x}px`);
      card.style.setProperty('--mouse-y', `${y}px`);
    });
  });
</script>

<?php require_once APPROOT . '/views/users/Tailor/inc/footer.php'; ?>