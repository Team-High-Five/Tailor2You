<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section>
    <div class="tailor-section">
        <div class="tailor-section__header">
            <h1 class="tailor-section__title">Meet Tailors</h1>
        </div>
        <div class="filter-controls">
            <div class="filter-controls__wrapper">
                <div class="filter-controls__options">
                    <span class="filter-controls__label" style="font-weight: bold;">Filter By</span>
                    <span class="filter-controls__label">Gender</span>
                    <span class="filter-controls__label">Category</span>
                    <span class="filter-controls__label">Location</span>
                </div>
                <div class="filter-controls__reset">Reset Filter</div>
            </div>
        </div>
        <!-- Profile Cards -->
        <div class="profile-container">
            <div class="profile-card">
                <div class="profile-card__content">
                    <img class="profile-card__image" src="<?php echo URLROOT; ?>/public/img/home/lady1.jpg" alt="Profile">
                    <div class="profile-card__details">
                        <h3 class="profile-card__name">Saduni Perera</h3>
                        <p class="profile-card__profession">Professional in Fashion Design</p>
                    </div>
                </div>
                <div class="profile-card__actions">
                    <a href="<?php echo URLROOT ?>/Pages/tailorProfile"><button class="btn btn--primary">View Profile</button></a>
                    <button class="btn btn--secondary"><i class="fas fa-thumbs-up"></i> Like</button>
                    <button class="btn btn--secondary">Appointment</button>
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-card__content">
                    <img class="profile-card__image" src="<?php echo URLROOT; ?>/public/img/home/men1.jpg" alt="Profile">
                    <div class="profile-card__details">
                        <h3 class="profile-card__name">Rangika Herath</h3>
                        <p class="profile-card__profession">Professional in Fashion Design</p>
                    </div>
                </div>
                <div class="profile-card__actions">
                    <button class="btn btn--primary">View Profile</button>
                    <button class="btn btn--secondary"><i class="fas fa-thumbs-up"></i> Like</button>
                    <button class="btn btn--secondary">Appointment</button>
                </div>
            </div>
            <div class="profile-card">
                <div class="profile-card__content">
                    <img class="profile-card__image" src="<?php echo URLROOT; ?>/public/img/home/girls2.jpg" alt="Profile">
                    <div class="profile-card__details">
                        <h3 class="profile-card__name">Noji Yudara</h3>
                        <p class="profile-card__profession">Professional in Women Clothes</p>
                    </div>
                </div>
                <div class="profile-card__actions">
                    <button class="btn btn--primary">View Profile</button>
                    <button class="btn btn--secondary"><i class="fas fa-thumbs-up"></i> Like</button>
                    <button class="btn btn--secondary">Appointment</button>
                </div>
            </div>

        </div>
    </div>
</section>