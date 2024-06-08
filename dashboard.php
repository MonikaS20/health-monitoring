<?php
session_start();
include_once "db.php"; // Include the database connection file

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}



// Fetch health data from the database
$sql = "SELECT * FROM health_data";
$result = $conn->query($sql);

// Check if there are any records
if ($result->num_rows > 0) {
    // Store data in an array
    $healthData = array();
    while ($row = $result->fetch_assoc()) {
        $healthData[] = $row;
    }
} else {
    $healthData = array(); // If no records found, initialize an empty array
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Monitoring System - Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header">
                    <h2 class="text-center">Welcome, <?php echo $_SESSION['username']; ?>!</h2>
                </div>
                <div class="card-body">
                    <h3 class="mb-4">Health Data</h3>
                    <?php if (!empty($healthData)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Weight</th>
                                    <th>Blood Pressure</th>
                                    <th>Steps</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($healthData as $data): ?>
                                <tr>
                                    <td><?php echo $data['date']; ?></td>
                                    <td><?php echo $data['weight']; ?></td>
                                    <td><?php echo $data['blood_pressure']; ?></td>
                                    <td><?php echo $data['steps']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <p>No health data available.</p>
                    <?php endif; ?>
                    <hr>
                    <h3 class="mb-4">Add Patient</h3>
                    <form action="add_patient.php" method="POST">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age:</label>
                            <input type="number" class="form-control" id="age" name="age" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Add Patient</button>
                    </form>
                    <hr>
                    <a href="logout.php" class="btn btn-danger btn-block">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
