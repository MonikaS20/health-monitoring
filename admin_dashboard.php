<?php
session_start();
include_once "db.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

$sql = "SELECT * FROM patients";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $patients = array();
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
} else {
    $patients = array();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $blood_group = $_POST['blood_group'];
    $blood_pressure = $_POST['blood_pressure'];
    $weight = $_POST['weight'];
    $steps = $_POST['steps'];
    $admin_username = $_POST['admin_username'];

    // Insert patient details into database
    $sql = "INSERT INTO patients (name, age, gender, blood_group, blood_pressure, weight, steps, username) 
    VALUES ('$name', '$age', '$gender', '$blood_group', '$blood_pressure', '$weight', '$steps', '$admin_username')";
    if ($conn->query($sql) === TRUE) {
    echo "New patient added successfully!";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header">
                    <h2 class="text-center">Admin Dashboard</h2>
                </div>
                <div class="card-body">

                <h3 class="mb-4">Add New Patient</h3>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
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
                        <div class="form-group">
                            <label for="blood_group">Blood Group:</label>
                            <input type="text" class="form-control" id="blood_group" name="blood_group">
                        </div>
                        <div class="form-group">
                            <label for="blood_pressure">Blood Pressure:</label>
                            <input type="text" class="form-control" id="blood_pressure" name="blood_pressure">
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight:</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight">
                        </div>
                        <div class="form-group">
                            <label for="steps">Steps:</label>
                            <input type="number" class="form-control" id="steps" name="steps">
                        </div>
                        <div class="form-group">
                            <label for="admin_username">Patients Username:</label>
                            <select class="form-control" id="admin_username" name="admin_username" required>
                                <?php foreach ($patients as $user): ?>
                                    <option value="<?php echo $user['username']; ?>"><?php echo $user['username']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Add Patient</button>
                    </form>
                    <hr>
                    <h3 class="mb-4">Patient Details</h3>
                    <?php if (!empty($patients)): ?>
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
                                <?php foreach ($patients as $patient): ?>
                                    <tr>
                                        <td><?php echo $patient['name']; ?></td>
                                        <td><?php echo $patient['age']; ?></td>
                                        <td><?php echo $patient['gender']; ?></td>
                                        <td><?php echo $patient['blood_group']; ?></td>
                                        <td><?php echo $patient['blood_pressure']; ?></td>
                                        <td><?php echo $patient['weight']; ?></td>
                                        <td><?php echo $patient['steps']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>No patients found.</p>
                    <?php endif; ?>
                    <a href="logout.php" class="btn btn-danger btn-block">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
