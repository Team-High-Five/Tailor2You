<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tailor2You</title>
 </head>
<body>
  <div class="container">
    <!-- Header -->
    <div class="header">
      <div class="header-title">Create a Group</div>
      <div class="close-icon">&times;</div>
    </div>

    <!-- Description -->
    <div class="description">
      # team-chat
    </div>

    <!-- Form -->
    <div class="form-group">
      
    </div>

    <div class="form-group">
      <label for="description">Only admins</label>
      <input type="text" id="description" placeholder="Enter a name or email">
    </div>

    <!-- Toggle Section -->
    <div class="toggle-section">
      <label for="make-private">Automatically add anyone who joins</label>
      <div class="toggle-switch" id="toggle"></div>
    </div>

    <!-- Button -->
    <div class="button-container">
      <button class="create-btn">Done</button>
    </div>
  </div>

  <script>
    // Toggle Switch Functionality
    const toggle = document.getElementById('toggle');
    toggle.addEventListener('click', () => {
      toggle.classList.toggle('active');
    });
  </script>
</body>
</html>
