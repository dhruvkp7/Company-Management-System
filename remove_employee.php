<?php
// Database connection
$conn = new mysqli('localhost', 'root', 'mysql', 'IP2');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$employee_ssn = "";
$error = "";

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_ssn = $_POST["employee_ssn"];

    // Check if employee SSN exists
    $sql = "SELECT * FROM EMPLOYEE WHERE SSN = '$employee_ssn'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $error = "Employee SSN does not exist in COMPANY.";
    } else {
        // Fetch employee details
        $row = $result->fetch_assoc();
        $dno = $row['Dno'];
        
        // Check if the employee manages a department
        if ($row['MgrStartDate'] !== null) {
            // Check if there are other employees in the same department
            $sql_count = "SELECT COUNT(*) AS count FROM EMPLOYEE WHERE Dno = '$dno' AND SSN != '$employee_ssn'";
            $result_count = $conn->query($sql_count);
            $count_row = $result_count->fetch_assoc();
            $employee_count = $count_row['count'];

            if ($employee_count == 0) {
                // Remove department if no other employees
                $sql_remove_department = "DELETE FROM DEPARTMENT WHERE Dnumber = '$dno'";
                if ($conn->query($sql_remove_department) === FALSE) {
                    $error = "Error removing department: " . $conn->error;
                }
            } else {
                $error = "Cannot remove employee. The employee manages a department with other employees.";
            }
        }
        
        // Remove project assignments
        $sql_remove_project_assignments = "DELETE FROM WORKS_ON WHERE Essn = '$employee_ssn'";
        if ($conn->query($sql_remove_project_assignments) === FALSE) {
            $error = "Error removing project assignments: " . $conn->error;
        }

        // Remove employee from EMPLOYEE table
        $sql_remove_employee = "DELETE FROM EMPLOYEE WHERE SSN = '$employee_ssn'";
        if ($conn->query($sql_remove_employee) === TRUE) {
            // Redirect to the main page
            header("Location: http://localhost:8080/index.php");
            exit();
        } else {
            $error = "Error removing employee: " . $conn->error;
        }
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Remove Employee</title>
</head>
<body>
    <h1>Remove Employee</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="employee_ssn">Employee SSN:</label>
        <input type="text" id="employee_ssn" name="employee_ssn" required><br><br>

        <button type="submit">Remove Employee</button>
    </form>
    <?php
    // Display error message if any
    if (!empty($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
</body>
</html>
