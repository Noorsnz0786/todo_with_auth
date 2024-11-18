<?php
include "partials/header.php";
include "partials/navigation.php";

if (is_user_logged_in()) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if password and confirm_password match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        if (user_exists($conn, $username)) {
            $error = "Username already exists. Please choose another.";
        } else {
            // Check if email already exists
            $emailCheckQuery = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $emailCheckQuery);

            if (mysqli_num_rows($result) > 0) {
                $error = "Email already exists. Please use another email.";
            } else {
                // Hash the password
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Insert the user into the database
                $sql = "INSERT INTO users (fullName, username, password, email) VALUES ('$fullName', '$username', '$passwordHash', '$email')";

                if (mysqli_query($conn, $sql)) {
                    // Registration successful
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $username;
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Something went wrong, data not inserted. Error: " . mysqli_error($conn);
                }
            }
        }
    }
}
?>

<div class="container">
    <div class="form-container">
        <form method="POST" action="">
            <h2>Create your Account</h2>

            <?php if ($error): ?>
                <p style="color:red">
                    <?php echo $error; ?>
                </p>
            <?php endif; ?>

            <label for="fullName">Full Name:</label>
            <input value="<?php echo isset($fullName) ? $fullName : ''; ?>" placeholder="Enter your full name"
                type="text" name="fullName" required>

            <label for="username">Username:</label>
            <input value="<?php echo isset($username) ? $username : ''; ?>" placeholder="Enter your username"
                type="text" name="username" required>

            <label for="email">Email:</label>
            <input value="<?php echo isset($email) ? $email : ''; ?>" placeholder="Enter your email" type="email"
                name="email" required>

            <label for="password">Password:</label>
            <input placeholder="Enter your password" type="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input placeholder="Confirm your password" type="password" name="confirm_password" required>

            <input type="submit" value="Register">
        </form>
    </div>
</div>

<?php include "partials/footer.php"; ?>

<?php
mysqli_close($conn);
?>