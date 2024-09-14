<?php
    // Database connection
    $conn = new mysqli('localhost', 'root', 'mysql', 'IP2');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize variables
    $Fname = $Minit = $Lname = $Ssn = $Bdate = $Address = $Sex = $Salary = $Super_ssn = $Dno = "";
    $error = "";

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Assign form values to variables
        $Fname = $_POST["Fname"];
        $Minit = $_POST["Minit"];
        $Lname = $_POST["Lname"];
        $Ssn = $_POST["Ssn"];
        $Bdate = $_POST["Bdate"];
        $Address = $_POST["Address"];
        $Sex = $_POST["Sex"];
        $Salary = $_POST["Salary"];
        $Super_ssn = $_POST["Super_ssn"];
        $Dno = $_POST["Dno"];

        // Check if department number exists
        $sql = "SELECT * FROM DEPARTMENT WHERE Dnumber = '$Dno'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $error = "Department Number does not exist in COMPANY.";
        } else {
            // Check if the length of Super_ssn is valid
            if (strlen($Super_ssn) > 9) {
                $error = "Super_ssn exceeds the maximum length of 9 characters.";
            } else {
                // Insert the new employee into the database
                $sql = "INSERT INTO EMPLOYEE (Fname, Minit, Lname, SSN, Bdate, Address, Sex, Salary, Super_ssn, Dno) VALUES ('$Fname', '$Minit', '$Lname', '$Ssn', '$Bdate', '$Address', '$Sex', '$Salary', '$Super_ssn', '$Dno')";

                if ($conn->query($sql) === TRUE) {
                    // Redirect to the main page if insertion is successful
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }

    // Close database connection
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
</head>
<body>

<h2>Add New Employee</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <!-- Your form fields -->
</form>

<?php
    // Display error message if any
    if (!empty($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
?>

</body>
</html>
