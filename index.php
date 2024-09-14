<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Employee Management System</title>
   <style>
      body {
                
	 background-size: cover;
         background-position: center;
         color: white;
         font-family: Arial, sans-serif;
         text-align: center;
      }
      .container {
         margin: 0 auto;
         width: 80%;
         padding: 20px;
         border: 5px solid #ADD8E6;
         border-radius: 10px;
         background-color: rgba(0, 0, 0, 0.5);
      }
      h1, h2, h3 {
         color: white;
      }
      header {
         background-color: #ADD8E6;
         padding: 20px 0;
         text-align: center;
      }
      input[type="text"], select, button {
         padding: 10px;
         margin: 5px;
         border-radius: 5px;
         border: 1px solid #ADD8E6;
         background-color: black;
         color: white;
         font-size: 16px;
      }
      button {
         cursor: pointer;
      }
      p.error {
         color: red;
      }
   </style>
</head>


<body>
<header>    
    <h1>Employee Management System</h1>
   </header>
   <img src='gang.jpg' alt='Image' width = 200><br>

    <div class="container">
    
    <h3>By: Dhruv Palakkal, Majed Ahmad, and Raihan Nurrahman</h3>
    <h2>Add a new Employee</h2>
    <form action="add_employee.php" method="POST">
        <label for="Fname">First Name:</label>
        <input type="text" id="Fname" name="Fname" required><br><br>

        <label for="Minit">Middle Initial:</label>
        <input type="text" id="Minit" name="Minit"><br><br>

        <label for="Lname">Last Name:</label>
        <input type="text" id="Lname" name="Lname" required><br><br>

        <label for="Ssn">SSN:</label>
        <input type="text" id="Ssn" name="Ssn" required><br><br>

        <label for="Bdate">Birth Date:</label>
        <input type="date" id="Bdate" name="Bdate" required><br><br>

        <label for="Address">Address:</label>
        <input type="text" id="Address" name="Address" required><br><br>

        <label for="Sex">Sex:</label>
        <input type="text" id="Sex" name="Sex" required><br><br>

        <label for="Salary">Salary:</label>
        <input type="number" id="Salary" name="Salary" required><br><br>

        <label for="Super_ssn">Supervisor SSN:</label>
        <input type="text" id="Super_ssn" name="Super_ssn" required><br><br>

        <label for="Dno">Department Number (Dno):</label>
        <input type="text" id="Dno" name="Dno" required><br><br>

        <button type="submit">Add Employee</button>
    </form>

    <h2>Add a new Department</h2>
    <form method="post" action="add_department.php">
        <label for="department_name">Department Name:</label>
        <input type="text" id="department_name" name="department_name" required><br><br>

        <label for="department_number">Department Number (Dno):</label>
        <input type="text" id="department_number" name="department_number" required><br><br>

        <label for="manager_ssn">Manager SSN:</label>
        <input type="text" id="manager_ssn" name="manager_ssn" required><br><br>

        <button type="submit">Add Department</button>
    </form>

    <h2>Add new working project for an employee</h2>
    <form action="add_project.php" method="POST">
        <label for="employee_ssn_project">Employee SSN:</label>
        <input type="text" id="employee_ssn_project" name="employee_ssn" required><br><br>

        <label for="project_name">Project Name:</label>
        <select id="project_name" name="project_name" required>
            <?php
            $conn = mysqli_connect('localhost', 'root', 'mysql', 'IP2');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT Pname FROM PROJECT";
            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $pname = $row['Pname'];
                    echo "<option value='$pname'>$pname</option>";
                }
            }
            mysqli_close($conn);
            ?>
        </select><br><br>

        <button type="submit">Add Project</button>
    </form>

    <h2>Remove an Employee</h2>
    <form action="remove_employee.php" method="POST">
        <label for="employee_ssn_remove">Employee SSN:</label>
        <input type="text" id="employee_ssn_remove" name="employee_ssn" required><br><br>

        <button type="submit">Remove Employee</button>
    </form>
</body>
</html>
