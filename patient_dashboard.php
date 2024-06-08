<?php
session_start();
include_once "db.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'patient') {
    header("Location: index.html");
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM patients WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $patient = $result->fetch_assoc();
} else {
    $patient = array();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header">
                    <h2 class="text-center">Patient Dashboard</h2>
                </div>
                <div class="card-body">
                    <h3 class="mb-4">Your Details</h3>
                    <?php if (!empty($patient)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Blood Group</th>
                                    <th>Blood Pressure</th>
                                    <th>Weight</th>
                                    <th>Steps</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $patient['name']; ?></td>
                                        <td><?php echo $patient['age']; ?></td>
                                        <td><?php echo $patient['gender']; ?></td>
                                        <td><?php echo $patient['blood_group']; ?></td>
                                        <td><?php echo $patient['blood_pressure']; ?></td>
                                        <td><?php echo $patient['weight']; ?></td>
                                        <td><?php echo $patient['steps']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>No patient details found.</p>
                    <?php endif; ?>
                    <a href="logout.php" class="btn btn-danger btn-block">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
