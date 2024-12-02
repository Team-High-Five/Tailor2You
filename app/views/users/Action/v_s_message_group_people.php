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
      Channels are where your team communicates. They're best when organized around a topic - # marketing, for example.
    </div>

    <!-- Form -->
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" id="name" placeholder="# e.g plan-budget">
    </div>

    <div class="form-group">
      <label for="description">Description (optional)</label>
      <input type="text" id="description" placeholder="What's this channel about?">
    </div>

    <!-- Toggle Section -->
    <div class="toggle-section">
      <label for="make-private">Make private</label>
      <div class="toggle-switch" id="toggle"></div>
    </div>

    <!-- Button -->
    <div class="button-container">
      <button class="create-btn">Create</button>
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
