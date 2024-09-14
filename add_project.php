<?php
// Database connection
$conn = new mysqli('localhost', 'root', 'mysql', 'IP2');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch existing project names
function getProjectNames($conn) {
    $sql = "SELECT Pname FROM PROJECT";
    $result = $conn->query($sql);
    $projectNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $projectNames[] = $row['Pname'];
        }
    }
    return $projectNames;
}

// Initialize variables
$employee_ssn = $project_name = "";
$error = "";

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_ssn = $_POST["employee_ssn"];
    $project_name = $_POST["project_name"];

    // Check if employee SSN exists
    $sql = "SELECT * FROM EMPLOYEE WHERE SSN = '$employee_ssn'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $error = "Employee SSN does not exist in COMPANY.";
    }

    // Check if project name exists
    $projectNames = getProjectNames($conn);
    if (!in_array($project_name, $projectNames)) {
        $error = "Project Name does not exist in COMPANY.";
    }

    // If no error, insert the new project assignment into the database
    if (empty($error)) {
        // Retrieve the department number of the employee
        $sql = "SELECT Dno FROM EMPLOYEE WHERE SSN = '$employee_ssn'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $dno = $row['Dno'];

        // Insert the new project assignment
        $sql = "INSERT INTO WORKS_ON (Essn, Pno, Hours) VALUES ('$employee_ssn', (SELECT Pnumber FROM PROJECT WHERE Pname = '$project_name' AND Dnum = '$dno'), 0)";
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
    <title>Add New Project</title>
</head>
<body>
    <h1>Add New Project for Employee</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="employee_ssn">Employee SSN:</label>
        <input type="text" id="employee_ssn" name="employee_ssn" required><br><br>
        
        <label for="project_name">Project Name:</label>
        <select id="project_name" name="project_name" required>
            <?php
            // Populate project names dropdown
            $projectNames = getProjectNames($conn);
            foreach ($projectNames as $pname) {
                echo "<option value=\"$pname\">$pname</option>";
            }
            ?>
        </select><br><br>

        <button type="submit">Add Project</button>
    </form>
    <?php
    // Display error message if any
    if (!empty($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
</body>
</html>
