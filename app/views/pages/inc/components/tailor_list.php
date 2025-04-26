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
            <?php foreach ($data['sellers'] as $tailor): ?>
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

                        <?php if (isLoggedIn()): ?>
                            <form action="<?php echo URLROOT; ?>/Pages/likeTailor/<?php echo $tailor->user_id; ?>" method="post" style="display:inline;">
                                <button type="submit" class="btn btn--secondary <?php echo ($tailor->hasLiked) ? 'liked' : ''; ?>">
                                    <i class="fas fa-thumbs-up"></i> Like
                                    <span class="like-count">(<?php echo $tailor->likeCount; ?>)</span>
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="<?php echo URLROOT; ?>/users/login" class="btn btn--loged-out">
                                <i class="fas fa-thumbs-up"></i> Like
                                <span class="like-count">(<?php echo $tailor->likeCount; ?>)</span>
                            </a>
                        <?php endif; ?>

                        <a href="<?php echo URLROOT ?>/Appointments/makeAppointment/<?php echo $tailor->user_id; ?>"><button class="btn btn--secondary"><i class="fas fa-calendar-alt"></i> Appointment</button></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<style>
    .btn {
        padding: -10px 20px;
        background-color: var(--accent-color);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
    }

    .btn.liked,
    .btn.liked:hover {
        background-color: #4CAF50;
        color: white;
    }

    .like-count {
        font-size: 0.9em;
        margin-left: 3px;
    }
</style>