<?php
session_start();
include('connect.php');

// Ensure the user is logged in as staff or admin
if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] !== "staff" && $_SESSION["role"] !== "admin")) {
    header("Location: staff-admin-login.php");
    exit();
}

$username = $_SESSION["username"];
$role = $_SESSION["role"];

// Handle the response submission for queries (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['response'])) {
    $query_id = intval($_POST['query_id']);
    $response = $_POST['response'];
    
    $stmt = $conn->prepare("UPDATE queries SET admin_response = ? WHERE id = ?");
    $stmt->bind_param("si", $response, $query_id);
    
    if ($stmt->execute() === TRUE) {
        echo "<script>alert('Response updated successfully!'); window.location.href='admindash.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating response: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Fetch queries from the "queries" table, joining with customers to get the customer's name
$query_sql = "SELECT q.*, c.fullname AS customer_name, c.email AS customer_email FROM queries q LEFT JOIN customers c ON q.customer_id = c.id ORDER BY q.submission_time DESC";
$query_result = $conn->query($query_sql);

// Fetch appointments from the "appointments" table, joining with customers to get the customer's name
$appointment_sql = "SELECT a.*, c.fullname AS customer_name, c.email AS customer_email FROM appointments a LEFT JOIN customers c ON a.customer_id = c.id ORDER BY a.appointment_date DESC, a.appointment_time DESC";
$appointments_result = $conn->query($appointment_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff/Admin Dashboard | FitZone</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

  <!-- Header Section -->
  <header>
    <div class="logo">
      <img src="images/logo.webp" alt="FitZone Logo">
    </div>
    <div style="text-align: right; color: var(--text-white);">
      <h3 style="font-size: 16px; margin: 0;">Welcome, <?php echo htmlspecialchars($username); ?></h3>
      <span style="font-size: 12px; color: var(--primary); font-weight: bold; text-transform: uppercase;"><?php echo htmlspecialchars($role); ?> Portal</span>
    </div>
  </header>

  <!-- Main Content Section -->
  <main style="margin-top: 140px;">
    <div class="container">
      
      <div class="dashboard-container" style="grid-template-columns: 1.2fr 1fr;">
      <!-- Customer Queries Section -->
      <section>
        <h3>Customer Queries</h3>

        <?php if ($query_result->num_rows > 0): ?>
          <table>
            <thead>
              <tr>
                <th>Query ID</th>
                <th>Customer</th>
                <th>Query Text</th>
                <th>Submission Time</th>
                <th>Response</th>
                <th>Respond</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $query_result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo $row['id']; ?></td>
                  <td>
                    <strong><?php echo htmlspecialchars($row['customer_name'] ?: 'Guest'); ?></strong><br>
                    <small style="color: #7f8c8d;"><?php echo htmlspecialchars($row['customer_email'] ?: ''); ?></small>
                  </td>
                  <td><?php echo htmlspecialchars($row['query_text']); ?></td>
                  <td><?php echo $row['submission_time']; ?></td>
                  <td><?php echo $row['admin_response'] ? htmlspecialchars($row['admin_response']) : 'No response yet'; ?></td>
                  <td>
                    <?php if (empty($row['admin_response'])): ?>
                      <form class="response-form" method="POST" action="">
                        <input type="hidden" name="query_id" value="<?php echo $row['id']; ?>">
                        <textarea name="response" rows="4" placeholder="Write your response..." required></textarea>
                        <button type="submit">Submit Response</button>
                      </form>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p>No queries found.</p>
        <?php endif; ?>
      </section>

      <!-- Customer Appointments Section -->
      <section>
        <h3>Customer Appointments</h3>

        <?php if ($appointments_result->num_rows > 0): ?>
          <table>
            <thead>
              <tr>
                <th>Appointment ID</th>
                <th>Customer</th>
                <th>Class Type</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $appointments_result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo $row['id']; ?></td>
                  <td>
                    <strong><?php echo htmlspecialchars($row['customer_name'] ?: 'Guest'); ?></strong><br>
                    <small style="color: #7f8c8d;"><?php echo htmlspecialchars($row['customer_email'] ?: ''); ?></small>
                  </td>
                  <td><?php echo htmlspecialchars($row['class_type']); ?></td>
                  <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                  <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p>No appointments found.</p>
        <?php endif; ?>
      </section>
      <!-- Action Footer -->
      <div style="max-width: 400px; margin: 40px auto 0 auto; text-align: center;">
        <form action="logout.php" method="POST">
          <button type="submit" class="logout-button">Log Out from Portal</button>
        </form>
      </div>

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





