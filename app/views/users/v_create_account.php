<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- top navigation -->
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>
<div class="create-account-container">
    <div class="create-account-box">
        <div class="create-account-logo">
            <img src="<?php echo URLROOT; ?>/public/img/logo_brown.png" alt="Tailor House Logo" class="logo-img">
        </div>
        <div class="who-are-you">
            <h2>You are a</h2>
            <div class="options">
                <div class="option tailor">
                    <a href="<?php echo URLROOT ?>/Tailors/tailorRegister">
                        <button class="tailor-btn">Tailor</button>
                    </a>
                </div>
                <div class="option shopkeeper">
                    <a href="<?php echo URLROOT ?>/Shopkeepers/shopkeeperRegister">
                        <button class="shopkeeper-btn">Shopkeeper</button>
                    </a>
                </div>
                <div class="option customer">
                    <a href="<?php echo URLROOT ?>/Customers/customerRegister">
                        <button class="customer-btn">Customer</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>