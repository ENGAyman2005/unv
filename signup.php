<?php
require '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);//in form
    $password = $_POST['password'];
    $national_number = trim($_POST['national_number']);
    $university = trim($_POST['university']);
    $faculty = trim($_POST['faculty']);

    if (!preg_match('/^\d{14}$/', $national_number)) {
        die("National ID must be exactly 14 digits.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password, national_number, university, faculty)
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $hashed_password, $national_number, $university, $faculty);

    if ($stmt->execute()) {
        echo "Signup successful! <a href='login.php'>Login now</a>.";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Signup</title>
    <link rel="icon" href="UNV.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .signup-container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            text-align: left;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            padding: 10px;
            background-color: #2e86de;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #1b4f72;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <!-- Replace with your logo file -->
        <img src="UNVrm.png" alt="University Logo" class="logo">

        <h2>Create a New Account</h2>

        <form  method="POST">
            <div>
                <label for="username">Full Name:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="national_number">National ID:</label>
                <input type="text" id="national_number" name="national_number" pattern="\d{14}" title="Must be exactly 14 digits" required>
            </div>

            <div>
                <label for="university">University:</label>
                <input type="text" id="university" name="university" required>
            </div>

            <div>
                <label for="faculty">Faculty:</label>
                <input type="text" id="faculty" name="faculty" required>
            </div>

            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>
