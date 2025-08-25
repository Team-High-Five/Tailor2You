<!-- filepath: c:\xampp\htdocs\Tailor2You\app\views\pages\inc\footer.php -->
<footer class="footer">
    <div class="footer-container">
        <!-- About Us Section -->
        <div class="footer-section aboutUs">
            <h3>About Tailor2You</h3>
            <p>
                At Tailor2You, we're dedicated to providing personalized fashion services right at your convenience. Whether you're looking for custom-made outfits, alterations, or quick fixes, our expert tailors are here to bring your vision to life.
            </p>
            <p class="mission-statement">
                Our mission is to combine traditional craftsmanship with modern technology to deliver perfectly tailored clothing that makes you look and feel your best.
            </p>
        </div>

        <!-- Quick Links Section -->
        <div class="footer-section quicklinks">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="<?php echo URLROOT; ?>/pages"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="<?php echo URLROOT; ?>/pages/mensPage"><i class="fas fa-male"></i> Men's Collection</a></li>
                <li><a href="<?php echo URLROOT; ?>/pages/womensPage"><i class="fas fa-female"></i> Women's Collection</a></li>
                <li><a href="<?php echo URLROOT; ?>/pages/about"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li><a href="<?php echo URLROOT; ?>/pages/contact"><i class="fas fa-envelope"></i> Contact</a></li>
            </ul>
        </div>

        <!-- Contact Us Section -->
        <div class="footer-section contact">
            <h3>Contact Us</h3>
            <p>
                <i class="fas fa-envelope"></i> <a href="mailto:tailor2you@gmail.com">tailor2you@gmail.com</a><br>
                <i class="fas fa-phone"></i> <a href="tel:+94767665560">+94 767 665 560</a><br>
                <i class="fas fa-map-marker-alt"></i> Colombo, Sri Lanka
            </p>
            <div class="social-links">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="team-section">
        <h3>Meet Our Development Team</h3>
        <div class="team-members">
            <div class="team-member">
                <div class="team-img-container">
                    <img src="<?php echo URLROOT; ?>/public/img/team/bavindu.jpg" alt="Team Member 1">
                    <div class="overlay">
                        <div class="member-social">
                            <a href="#"><i class="fab fa-github"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <h4>Bavindu De Silva</h4>
                <p>Lead Developer</p>
            </div>

            <div class="team-member">
                <div class="team-img-container">
                    <img src="<?php echo URLROOT; ?>/public/img/team/tharini.jpg" alt="Team Member 2">
                    <div class="overlay">
                        <div class="member-social">
                            <a href="#"><i class="fab fa-github"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <h4>Tharini</h4>
                <p>UI/UX Designer</p>
            </div>

            <div class="team-member">
                <div class="team-img-container">
                    <img src="<?php echo URLROOT; ?>/public/img/team/yudara.jpg" alt="Team Member 3">
                    <div class="overlay">
                        <div class="member-social">
                            <a href="#"><i class="fab fa-github"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <h4>Noji Yudara </h4>
                <p>Backend Developer</p>
            </div>

            <div class="team-member">
                <div class="team-img-container">
                    <img src="<?php echo URLROOT; ?>/public/img/team/rangika.jpg" alt="Team Member 4">
                    <div class="overlay">
                        <div class="member-social">
                            <a href="#"><i class="fab fa-github"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <h4>Sarah Williams</h4>
                <p>QA Engineer</p>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-content">
            <p class="footer-rights">
                &copy; <?php echo date('Y'); ?> Tailor2You. All rights reserved.
            </p>
            <p class="footer-legal">
                <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
            </p>
        </div>
    </div>
</footer>


<!-- Update to a modern Font Awesome kit -->
<script src="https://kit.fontawesome.com/3010d94d2f.js" crossorigin="anonymous"></script>
</body>

</html>