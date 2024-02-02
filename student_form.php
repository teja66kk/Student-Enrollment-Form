<!DOCTYPE html>
<html>
<head>
    <title>Student Enrollment Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        button:disabled {
            background-color: #aaaaaa;
            cursor: not-allowed;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$roll_no = isset($_POST['roll_no']) ? $_POST['roll_no'] : '';
$full_name = '';
$class = '';
$birth_date = '';
$address = '';
$enrollment_date = '';
$isNewRecord = true; // Flag to check if it's a new record

// Check if Roll No exists in the database
$sql = "SELECT * FROM student_table WHERE roll_no='$roll_no'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $isNewRecord = false; // It's an existing record
    $row = $result->fetch_assoc();
    $full_name = $row['full_name'];
    $class = $row['class'];
    $birth_date = $row['birth_date'];
    $address = $row['address'];
    $enrollment_date = $row['enrollment_date'];
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        // Save logic
        $sql = "INSERT INTO student_table (roll_no, full_name, class, birth_date, address, enrollment_date) VALUES ('$roll_no', '$full_name', '$class', '$birth_date', '$address', '$enrollment_date')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        // Update logic
        $sql = "UPDATE student_table SET full_name='$full_name', class='$class', birth_date='$birth_date', address='$address', enrollment_date='$enrollment_date' WHERE roll_no='$roll_no'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif (isset($_POST['reset'])) {
        // Reset logic
        header('Location: student_form.php');
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Enrollment Form</title>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="roll_no">Roll No:</label>
        <input type="text" id="roll_no" name="roll_no" value="<?php echo $roll_no; ?>" required <?php echo (!$isNewRecord) ? 'disabled' : ''; ?>>
        <br>
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo $full_name; ?>" required <?php echo (!$isNewRecord) ? 'disabled' : ''; ?>>
        <br>
        <label for="class">Class:</label>
        <input type="text" id="class" name="class" value="<?php echo $class; ?>" required <?php echo (!$isNewRecord) ? 'disabled' : ''; ?>>
        <br>
        <label for="birth_date">Birth Date:</label>
        <input type="date" id="birth_date" name="birth_date" value="<?php echo $birth_date; ?>" required <?php echo (!$isNewRecord) ? 'disabled' : ''; ?>>
        <br>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo $address; ?>" required <?php echo (!$isNewRecord) ? 'disabled' : ''; ?>>
        <br>
        <label for="enrollment_date">Enrollment Date:</label>
        <input type="date" id="enrollment_date" name="enrollment_date" value="<?php echo $enrollment_date; ?>" required <?php echo (!$isNewRecord) ? 'disabled' : ''; ?>>
        <br>
        <button type="submit" name="save" <?php echo ($isNewRecord) ? '' : 'disabled'; ?>>Save</button>
        <button type="submit" name="update" <?php echo (!$isNewRecord) ? '' : 'disabled'; ?>>Update</button>
        <button type="submit" name="reset">Reset</button>
    </form>
</body>
</html>

</body>
</html>
