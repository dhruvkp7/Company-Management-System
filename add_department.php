<?php
// Database connection
$conn = new mysqli('localhost', 'root', 'mysql', 'IP2');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$department_name = $manager_ssn = "";
$error = "";

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $department_name = $_POST["department_name"];
    $manager_ssn = $_POST["manager_ssn"];
    $desired_value_for_dnumber = $_POST['department_number'];

    // Check if manager SSN exists
    $sql = "SELECT * FROM EMPLOYEE WHERE SSN = '$manager_ssn'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $error = "Manager SSN does not exist in COMPANY.";
    }

    // If no error, insert the new department into the database
    if (empty($error)) {
        $sql = "INSERT INTO DEPARTMENT (Dnumber, Dname, Mgr_ssn, Mgr_start_date) VALUES ('$desired_value_for_dnumber' , '$department_name', '$manager_ssn', CURDATE())";
        if ($conn->query($sql) === TRUE) {
            // Redirect to the main page
            header("Location: http://localhost:8080/index.php");
            exit();
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Department</title>
</head>
<body>
    <h1>Add New Department</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="department_name">Department Name:</label>
        <input type="text" id="department_name" name="department_name" required><br><br>
        
        <label for="manager_ssn">Manager SSN:</label>
        <input type="text" id="manager_ssn" name="manager_ssn" required><br><br>

        <button type="submit">Add Department</button>
    </form>

    
    <?php
    // Display error message if any
    if (!empty($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
</body>
</html>
