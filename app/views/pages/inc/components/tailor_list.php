<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcasspD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section>
    <div class="tailor-section">
        <div class="tailor-section__header">
            <h1 class="tailor-section__title">Meet Tailors</h1>
        </div>
        <div class="filter-controls">
            <div class="filter-controls__wrapper">
                <div class="filter-controls__options">
                    <!-- Search Bar -->
                    <input type="text" id="search-bar" class="filter-controls__search" placeholder="Search by name...">
                    <span class="filter-controls__label" style="font-weight: bold;">Filter By</span>
                    <div class="custom-dropdown" id="gender-dropdown">
                        <div class="custom-dropdown__selected">All Genders</div>
                        <ul class="custom-dropdown__options">
                            <li class="custom-dropdown__option" data-value="">All Genders</li>
                            <li class="custom-dropdown__option" data-value="Gents">Gents</li>
                            <li class="custom-dropdown__option" data-value="Ladies">Ladies</li>
                        </ul>
                    </div>

                    <div class="custom-dropdown" id="category-dropdown">
                        <div class="custom-dropdown__selected">All Categories</div>
                        <ul class="custom-dropdown__options">
                            <li class="custom-dropdown__option" data-value="">All Categories</li>
                            <li class="custom-dropdown__option" data-value="tailor">Tailor</li>
                            <li class="custom-dropdown__option" data-value="shopkeeper">Shopkeeper</li>
                        </ul>
                    </div>

                    <div class="custom-dropdown" id="location-dropdown">
                        <div class="custom-dropdown__selected">All Locations</div>
                        <ul class="custom-dropdown__options">
                            <li class="custom-dropdown__option" data-value="">All Locations</li>
                            <li class="custom-dropdown__option" data-value="colombo">Colombo</li>
                            <li class="custom-dropdown__option" data-value="kandy">Kandy</li>
                            <li class="custom-dropdown__option" data-value="galle">Galle</li>
                            <li class="custom-dropdown__option" data-value="jaffna">Jaffna</li>
                        </ul>
                    </div>
                    <div class="filter-controls__reset" id="reset-filters">Reset Filter</div>
                </div>
            </div>
        </div>

        <!-- Profile Cards -->
        <div class="profile-container">
            <?php foreach ($data['sellers'] as $tailor): ?>
                <div class="profile-card"
                    data-location="<?php echo strtolower($tailor->home_town); ?>"
                    data-gender="<?php echo strtolower($tailor->gender); ?>"
                    data-category="<?php echo strtolower($tailor->user_type); ?>">
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
                            <form action="<?php echo URLROOT; ?>/Pages/likeTailor/<?php echo $tailor->user_id; ?>" method="post" style="display:inline;">
                                <button type="submit" class="btn btn--secondary">
                                    <i class="fas fa-thumbs-up"></i> Like
                                    <span class="like-count">(<?php echo $tailor->likeCount; ?>)</span>
                                </button>
                            </form>
                        <?php endif; ?>

                        <a href="<?php echo URLROOT ?>/Appointments/makeAppointment/<?php echo $tailor->user_id; ?>"><button class="btn btn--secondary"><i class="fas fa-calendar-alt"></i> Appointment</button></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/tailor-list.js"></script>
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

    /* Ensure parent containers do not interfere */
    .tailor-section {
        position: relative;
        /* Create a stacking context for the section */
        z-index: 0;
        /* Ensure it does not interfere with dropdowns */
    }

    .filter-controls {
        position: relative;
        /* Create a stacking context for the dropdowns */
        z-index: 10;
        /* Ensure it is above the profile cards */
    }

    .profile-container {
        position: relative;
        /* Create a stacking context for the profile cards */
        z-index: 1;
        /* Ensure it is below the dropdowns */
    }    /* Custom Scrollbar for Tailor Section */
    .tailor-section {
      /* existing styles... */
      background: var(--gradient-background);
      min-height: 100vh;
      padding: 2rem;
      color: var(--text-light);
    
      /* Enable vertical scrolling if needed */
      overflow-y: auto;
      max-height: 100vh;
      scrollbar-width: thin; /* Firefox */
      scrollbar-color: var(--accent-color) var(--card-gradient); /* Firefox */
    }
    
    /* Webkit browsers (Chrome, Edge, Safari) */
    .tailor-section::-webkit-scrollbar {
      width: 10px;
      background: var(--card-gradient);
      border-radius: 8px;
    }
    
    .tailor-section::-webkit-scrollbar-thumb {
      background: var(--accent-color);
      border-radius: 8px;
      border: 2px solid var(--card-gradient);
    }
    
    .tailor-section::-webkit-scrollbar-thumb:hover {
      background: var(--accent-hover);
    }
</style>