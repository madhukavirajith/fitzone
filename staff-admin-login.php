<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff & Admin Portal | FitZone</title>
  <link rel="icon" type="image/png" href="images/logo.png">
  <link rel="stylesheet" href="css/styles.css"> 
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">
      <img src="images/logo.png" alt="FitZone Logo">
    </div>
    <nav>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="services.html">Classes & Plans</a></li>
        <li><a href="trainers.html">Trainers</a></li>
        <li><a href="blog.html">Blog</a></li>
        <li><a href="about.html">Contact Us</a></li>
      </ul>
    </nav>
  </header>

  <!-- Main content -->
  <main>
    <div class="form-container single-form">
      <!-- Staff/Admin Login Form -->
      <section class="login-form">
        <h2 style="border-bottom: 2px solid var(--primary); padding-bottom: 12px; margin-bottom: 30px; color: var(--text-white);">Staff/Admin Portal</h2>
        <form action="adminlogin.php" method="POST">
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required placeholder="Enter username">
          </div>

          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required placeholder="Enter password">
          </div>

          <div class="form-group">
            <label for="role">Select Your Role:</label>
            <select id="role" name="role" required>
              <option value="staff">Gym Staff Member</option>
              <option value="admin">Administrator</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px; background: #9b59b6; box-shadow: 0 4px 14px rgba(155, 89, 182, 0.4);">Portal Log In &rarr;</button>
        </form>
        <div style="margin-top: 24px; text-align: center;">
          <a href="customer-signup-login.php" style="color: var(--text-muted); font-size: 14px; text-decoration: underline;">Go back to Customer Login</a>
        </div>
      </section>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    <div class="container">
      <p>&copy; 2026 FitZone Fitness Center | All Rights Reserved</p>
      <div class="social-media">
        <a href="#">Instagram</a>
        <a href="#">YouTube</a>
        <a href="#">Facebook</a>
        <a href="#">Twitter</a>
      </div>
    </div>
  </footer>

</body>
</html>
