<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcasspD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <?php foreach ($data['tailors'] as $tailor): ?>
                <div class="profile-card">
                    <div class="profile-card__content">
                        <img class="profile-card__image" src="data:image/jpeg;base64,<?php echo base64_encode($tailor->profile_pic); ?>" alt="Profile">
                        <div class="profile-card__details">
                            <h3 class="profile-card__name"><?php echo $tailor->name; ?></h3>
                            <p class="profile-card__profession"><?php echo $tailor->bio; ?></p>
                        </div>
                    </div>
                    <div class="profile-card__actions">
                        <a href="<?php echo URLROOT ?>/Pages/tailorProfile/<?php echo $tailor->user_id; ?>"><button class="btn btn--primary">View Profile</button></a>
                        <button class="btn btn--secondary"><i class="fas fa-thumbs-up"></i> Like</button>
                        <a href="<?php echo URLROOT ?>/Appointments/makeAppointment/<?php echo $tailor->user_id; ?>"><button class="btn btn--secondary"><i class="fas fa-calendar-alt"></i> Appointment</button></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>