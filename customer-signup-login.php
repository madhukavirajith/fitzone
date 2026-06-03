<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Join FitZone | Customer Sign Up & Login</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">
      <img src="images/logo.webp" alt="FitZone Logo">
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
    <div class="form-container">
      
      <!-- Customer Sign-Up Form -->
      <section class="signup-form">
        <h2>Create an Account</h2>
        <form action="register.php" method="POST">
          <div class="form-group">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" required placeholder="Enter your full name">
          </div>

          <div class="form-group">
            <label for="signup-email">Email Address:</label>
            <input type="email" id="signup-email" name="email" required placeholder="name@email.com">
          </div>

          <div class="form-group">
            <label for="signup-password">Password:</label>
            <input type="password" id="signup-password" name="password" required placeholder="Create a secure password">
          </div>

          <div class="form-group">
            <label for="class">Select Preferred Class:</label>
            <select id="class" name="class" required>
              <option value="Cardio Blast">Cardio Blast</option>
              <option value="Strength & Conditioning">Strength & Conditioning</option>
              <option value="Yoga & Flexibility">Yoga & Flexibility</option>
              <option value="Core Pilates">Core Pilates</option>
              <option value="Zumba Dance Fitness">Zumba Dance Fitness</option>
            </select>
          </div>

          <div class="form-group">
            <label for="membershipplan">Select Membership Plan:</label>
            <select id="membershipplan" name="membershipplan" required>
              <option value="Basic">Basic Plan (2,000 LKR/mo)</option>
              <option value="Premium">Premium Plan (5,000 LKR/mo)</option>
              <option value="VIP">VIP Plan (10,000 LKR/mo)</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary" style="width: 100%;">Sign Up</button>
        </form>
      </section>

      <!-- Customer Login Form -->
      <section class="login-form">
        <h2>Customer Login</h2>
        <form action="login.php" method="POST">
          <div class="form-group">
            <label for="login-email">Email Address:</label>
            <input type="email" id="login-email" name="email" required placeholder="name@email.com">
          </div>

          <div class="form-group">
            <label for="login-password">Password:</label>
            <input type="password" id="login-password" name="password" required placeholder="Enter your password">
          </div>

          <button type="submit" class="btn btn-primary" style="width: 100%;">Log In</button>
        </form>
        <div style="margin-top: 30px; text-align: center;">
          <p style="color: var(--text-muted); font-size: 14px;">Are you a staff member or administrator?</p>
          <a href="staff-admin-login.php" style="color: var(--primary); font-weight: 600; font-size: 14px; text-decoration: underline; display: inline-block; margin-top: 8px;">Go to Staff Login &rarr;</a>
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
