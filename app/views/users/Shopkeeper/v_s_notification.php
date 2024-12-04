<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notification Modal</title>
  <style>
    /* General Reset */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    /* Modal Container */
    .modal-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    /* Modal */
    .modal {
      background: white;
      width: 400px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    /* Modal Header */
    .modal-header {
      background-color: #f9f9f9;
      padding: 10px 20px;
      border-bottom: 1px solid #ddd;
      font-size: 18px;
      font-weight: bold;
    }

    .modal-header .bell-icon {
      margin-right: 10px;
    }

    /* Modal Body */
    .modal-body {
      padding: 15px 20px;
    }

    /* Notification List */
    .notification-list {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .notification-list li {
      display: flex;
      align-items: center;
      font-size: 14px;
      margin-bottom: 10px;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
    }

    .notification-list li .icon {
      margin-right: 10px;
      width: 24px;
      height: 24px;
    }

    .notification-list li .icon img {
      max-width: 100%;
      max-height: 100%;
    }
  </style>
</head>
<body>
  <div class="modal-container">
    <div class="modal">
      <div class="modal-header">
        <span class="modal-title"><i class="bell-icon"><img src="Icon.png" alt="Bell Icon" width="20"></i> Notification</span>
      </div>
      <div class="modal-body">
        <ul class="notification-list">
          <li><span class="icon"><img src="Customer_1.png" alt="User Icon"></span> New posts uploaded successfully</li>
          <li><span class="icon"><img src="Purchase Order_1.png" alt="File Icon"></span> Order status updated successfully</li>
          <li><span class="icon"><img src="Purchase Order_1.png" alt="File Icon"></span> Sudarshani P.H. was assigned to order #1067907</li>
          <li><span class="icon"><img src="Purchase Order_1.png" alt="File Icon"></span> Order cancelled</li>
          <li><span class="icon"><img src="Purchase Order_1.png" alt="Edit Icon"></span> Measurement edit request sent</li>
          <li><span class="icon"><img src="Calendar_1.png" alt="Calendar Icon"></span> Appointment rescheduling request sent</li>
          <li><span class="icon"><img src="Adjust_1.png" alt="Product Icon"></span> New product uploaded successfully</li>
          <li><span class="icon"><img src="Shoping bag_1.png" alt="Fabric Icon"></span> New fabric uploaded successfully</li>
          <li><span class="icon"><img src="untitled design_1.png" alt="Employee Icon"></span> New employee uploaded successfully</li>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>
