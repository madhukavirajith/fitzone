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

// Fetch metrics for the stats cards
$stat_customers = $conn->query("SELECT COUNT(*) AS count FROM customers")->fetch_assoc()['count'];
$stat_appointments = $conn->query("SELECT COUNT(*) AS count FROM appointments")->fetch_assoc()['count'];
$stat_queries = $conn->query("SELECT COUNT(*) AS count FROM queries WHERE admin_response IS NULL OR admin_response = ''")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff/Admin Portal Dashboard | FitZone</title>
  <link rel="icon" type="image/png" href="images/logo.png">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

  <!-- Header Section -->
  <header>
    <div class="logo">
      <img src="images/logo.png" alt="FitZone Logo">
    </div>
    <div style="text-align: right; color: var(--text-white);">
      <h3 style="font-size: 16px; margin: 0; font-family: var(--font-heading); font-weight: 600;">Welcome, <?php echo htmlspecialchars($username); ?></h3>
      <span style="font-size: 11px; color: var(--primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo htmlspecialchars($role); ?> Portal</span>
    </div>
  </header>

  <!-- Main Content Section -->
  <main style="margin-top: 140px;">
    <div class="container">
      
      <!-- Metrics Cards Overview -->
      <div class="stats-grid">
        <div class="stat-card blue">
          <span class="label">Total Members</span>
          <span class="value"><?php echo $stat_customers; ?></span>
        </div>
        <div class="stat-card orange">
          <span class="label">Booked Sessions</span>
          <span class="value"><?php echo $stat_appointments; ?></span>
        </div>
        <div class="stat-card gold">
          <span class="label">Pending Queries</span>
          <span class="value"><?php echo $stat_queries; ?></span>
        </div>
      </div>

      <div class="dashboard-container" style="grid-template-columns: 1.3fr 1fr; gap: 30px; margin-top: 0;">
        <!-- Left: Customer Queries -->
        <section style="margin-bottom: 0;">
          <h2>Customer Queries</h2>
          <?php if ($query_result->num_rows > 0): ?>
            <div style="overflow-x: auto;">
              <table>
                <thead>
                  <tr>
                    <th>Customer</th>
                    <th>Query Details</th>
                    <th>Response Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $query_result->fetch_assoc()): ?>
                    <tr>
                      <td style="min-width: 140px; vertical-align: top;">
                        <strong style="color: var(--text-white); font-size: 14px;"><?php echo htmlspecialchars($row['customer_name'] ?: 'Guest'); ?></strong><br>
                        <small style="color: var(--text-muted); font-size: 11px;"><?php echo htmlspecialchars($row['customer_email'] ?: ''); ?></small>
                      </td>
                      <td style="vertical-align: top;">
                        <span style="font-size: 14px; color: var(--text-white); line-height: 1.5; display: block; margin-bottom: 4px;"><?php echo htmlspecialchars($row['query_text']); ?></span>
                        <small style="color: var(--text-muted); font-size: 10px;"><?php echo $row['submission_time']; ?></small>
                      </td>
                      <td style="vertical-align: top; min-width: 200px;">
                        <?php if (!empty($row['admin_response'])): ?>
                          <div style="background: rgba(0, 240, 255, 0.05); border: 1px solid rgba(0, 240, 255, 0.2); padding: 12px; border-radius: 8px; font-size: 13px; color: var(--secondary);">
                            <span style="font-size: 10px; text-transform: uppercase; color: var(--secondary); font-weight: bold; display: block; margin-bottom: 4px;">Response Sent</span>
                            <?php echo htmlspecialchars($row['admin_response']); ?>
                          </div>
                        <?php else: ?>
                          <span class="status-badge pending" style="margin-bottom: 8px;">Awaiting response</span>
                          <form class="response-form" method="POST" action="" style="margin-top: 4px;">
                            <input type="hidden" name="query_id" value="<?php echo $row['id']; ?>">
                            <div class="form-group" style="margin-bottom: 0;">
                              <textarea name="response" rows="2" placeholder="Write response..." required style="padding: 8px 12px; font-size: 13px; background: #191b26; resize: vertical; min-height: 50px;"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="padding: 6px 14px; font-size: 12px; margin-top: 8px; width: 100%;">Submit Response</button>
                          </form>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <p style="color: var(--text-muted); margin-top: 15px;">No customer queries found.</p>
          <?php endif; ?>
        </section>

        <!-- Right: Customer Appointments -->
        <section style="margin-bottom: 0;">
          <h2>Customer Appointments</h2>
          <?php if ($appointments_result->num_rows > 0): ?>
            <div style="overflow-x: auto;">
              <table>
                <thead>
                  <tr>
                    <th>Customer</th>
                    <th>Class & Schedule</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $appointments_result->fetch_assoc()): ?>
                    <tr>
                      <td style="vertical-align: top;">
                        <strong style="color: var(--text-white); font-size: 14px;"><?php echo htmlspecialchars($row['customer_name'] ?: 'Guest'); ?></strong><br>
                        <small style="color: var(--text-muted); font-size: 11px;"><?php echo htmlspecialchars($row['customer_email'] ?: ''); ?></small>
                      </td>
                      <td style="vertical-align: top;">
                        <span style="color: var(--primary); font-weight: bold; font-size: 14px;"><?php echo htmlspecialchars($row['class_type']); ?></span><br>
                        <div style="margin-top: 4px; line-height: 1.4;">
                          <small style="color: var(--text-white); font-size: 12px; display: block;">Date: <?php echo htmlspecialchars($row['appointment_date']); ?></small>
                          <small style="color: var(--text-muted); font-size: 12px; display: block;">Time: <?php echo htmlspecialchars($row['appointment_time']); ?></small>
                        </div>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <p style="color: var(--text-muted); margin-top: 15px;">No appointments found.</p>
          <?php endif; ?>
        </section>
      </div>

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
