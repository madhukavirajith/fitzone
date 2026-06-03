<?php
session_start();
include('connect.php');

// Ensure the user is logged in as a customer
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "customer") {
    header("Location: customer-signup-login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch user details from the "customers" table 
$sql = "SELECT fullname, class, membershipplan FROM customers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  
$stmt->execute();
$result = $stmt->get_result();
$user_details = $result->fetch_assoc();
$stmt->close();

// Fetch customer queries and admin response from the "queries" table
$query_sql = "SELECT query_text, admin_response FROM queries WHERE customer_id = ? ORDER BY submission_time DESC";
$query_stmt = $conn->prepare($query_sql);
$query_stmt->bind_param("i", $user_id);  
$query_stmt->execute();
$query_result = $query_stmt->get_result();

// Fetch customer appointments from the "appointments" table
$app_sql = "SELECT class_type, appointment_date, appointment_time FROM appointments WHERE customer_id = ? ORDER BY appointment_date DESC, appointment_time DESC";
$app_stmt = $conn->prepare($app_sql);
$app_stmt->bind_param("i", $user_id);  
$app_stmt->execute();
$app_result = $app_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Dashboard | FitZone</title>
  <link rel="icon" type="image/png" href="images/logo.png">
  <link rel="stylesheet" href="css/styles.css"> 
  <script src="js/scripts.js" defer></script> 
</head>
<body>

  <!-- Header Section -->
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

  <!-- Main Content Section -->
  <main style="margin-top: 140px;">
    <div class="dashboard-container">
      
      <!-- Left Column: Details and Booking Forms -->
      <div class="left-column" style="display: flex; flex-direction: column; gap: 30px;">
        <!-- Your Details Section -->
        <section class="details-section" style="margin-bottom: 0;">
          <h2>Your Profile</h2>
          <?php if ($user_details): ?>
            <p style="margin-top: 15px;"><strong>Full Name:</strong> <?php echo htmlspecialchars($user_details['fullname']); ?></p>
            <p style="margin-top: 10px;"><strong>Preferred Class:</strong> <?php echo htmlspecialchars($user_details['class']); ?></p>
            <p style="margin-top: 10px;"><strong>Membership Level:</strong> <span style="text-transform: uppercase; color: var(--primary); font-weight: bold;"><?php echo htmlspecialchars($user_details['membershipplan']); ?></span></p>
          <?php else: ?>
            <p>Unable to fetch profile details.</p>
          <?php endif; ?>
          
          <form action="logout.php" method="POST" style="margin-top: 20px;">
            <button type="submit" class="logout-button">Log Out</button>
          </form>
        </section>

        <!-- Appointment Section -->
        <section class="appointment-section" style="margin-bottom: 0;">
          <h2>Book an Appointment</h2>
          <form id="appointmentForm" action="submit_appointment.php" method="POST" style="margin-top: 15px;">
            <div class="form-group">
              <label for="classType">Select Class:</label>
              <select id="classType" name="classType" required>
                <option value="Cardio Blast">Cardio Blast</option>
                <option value="Strength & Conditioning">Strength & Conditioning</option>
                <option value="Yoga & Flexibility">Yoga & Flexibility</option>
                <option value="Core Pilates">Core Pilates</option>
                <option value="Zumba Dance Fitness">Zumba Dance Fitness</option>
              </select>
            </div>

            <div class="form-group" style="margin-top: 15px;">
              <label for="appointmentDate">Select Date:</label>
              <input type="date" id="appointmentDate" name="appointmentDate" required min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group" style="margin-top: 15px;">
              <label for="appointmentTime">Select Time:</label>
              <input type="time" id="appointmentTime" name="appointmentTime" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;">Book Session</button>
          </form>
        </section>

        <!-- Submit Your Queries Section -->
        <section class="query-section" style="margin-bottom: 0;">
          <h2>Submit a Query</h2>
          <form id="queryForm" action="submit_query.php" method="POST" style="margin-top: 15px;">
            <div class="form-group">
              <label for="query">Your Query or Question:</label>
              <textarea id="query" name="query" rows="4" required placeholder="Type your query regarding services or events here..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;">Submit Query</button>
          </form>
        </section>
      </div>

      <!-- Right Column: Lists and Logs -->
      <div class="right-column" style="display: flex; flex-direction: column; gap: 30px;">
        <!-- Booked Appointments Section -->
        <section class="appointments-list-section" style="margin-bottom: 0;">
          <h2>Your Booked Sessions</h2>
          <?php if ($app_result->num_rows > 0): ?>
            <div style="overflow-x: auto;">
              <table>
                <thead>
                  <tr>
                    <th>Class Type</th>
                    <th>Date</th>
                    <th>Time</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $app_result->fetch_assoc()): ?>
                    <tr>
                      <td><strong><?php echo htmlspecialchars($row['class_type']); ?></strong></td>
                      <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                      <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <p style="color: var(--text-muted); margin-top: 15px;">You have no appointments booked yet.</p>
          <?php endif; ?>
        </section>

        <!-- Customer Queries & Admin Response Section -->
        <section class="query-response-section" style="margin-bottom: 0;">
          <h2>Your Queries & Responses</h2>
          <?php if ($query_result->num_rows > 0): ?>
            <div style="overflow-x: auto;">
              <table>
                <thead>
                  <tr>
                    <th>Query</th>
                    <th>Admin Response</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $query_result->fetch_assoc()): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($row['query_text']); ?></td>
                      <td>
                        <?php if ($row['admin_response']): ?>
                          <span style="color: var(--secondary); font-weight: 500;"><?php echo htmlspecialchars($row['admin_response']); ?></span>
                        <?php else: ?>
                          <span class="status-badge pending">Pending response</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <p style="color: var(--text-muted); margin-top: 15px;">No queries submitted yet.</p>
          <?php endif; ?>
        </section>
      </div>

    </div>
  </main>

  <!-- Footer Section -->
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




