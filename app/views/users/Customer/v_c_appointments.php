<?php require_once APPROOT . '/views/users/Customer/inc/Header.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/sideBar.php'; ?>
<?php require_once APPROOT . '/views/users/Customer/inc/topNavBar.php'; ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT; ?>/public/css/customer/Customer_Appointments_styles.css'>

<div class="cusmain">
    <div class="cusappointment-container">
        <!-- cusappointment 1 -->
        <div class="cusappointment">
            <div class="calendar">
                <div class="month">September</div>
                <div class="date">22</div>
                <div class="day">Sunday</div>
            </div>
            <div class="details">
                <h3>Appointment #1067907</h3>
                <p>22/09/2024 - 4:00 p.m.</p>
                <div class="tailor-info">
                    <img src="tail1.jpeg" alt="Tailor">
                    <span>Tailor - Pieris M.P</span>
                </div>
            </div>
            <div class="actions">
                
                <button class="status pending">Pending</button>               
                <button class="cancel">Cancel</button>
                <a href="#" class="action-link">Request For Rescheduling</a>
            </div>
        </div>

        <!-- cusappointment 2 -->
        <div class="cusappointment">
            <div class="calendar">
                <div class="month">September</div>
                <div class="date">30</div>
                <div class="day">Monday</div>
            </div>
            <div class="details">
                <h3>Appointment #1067468</h3>
                <p>22/09/2024 - 4:00 p.m.</p>
                <div class="tailor-info">
                    <img src="tail2.jpeg" alt="Tailor">
                    <span>Tailor - Bandara M.P</span>
                </div>
            </div>
            <div class="actions">
                
                <button class="status accepted">Accepted</button>               
                <button class="cancel">Cancel</button>
                <a href="#" class="action-link">Request For Rescheduling</a>
            </div>
        </div>
    </div>


