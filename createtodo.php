<?php
session_start();

include "db.php"; // Your database connection

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$error = "";

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $author = $_SESSION['username']; // Assuming you have username in the session

    // Insert todo with default status 'pending'
    $sql = "INSERT INTO todos (title, description, start_date, end_date, author, status) 
            VALUES ('$title', '$description', '$start_date', '$end_date', '$author', 'pending')";

    if (mysqli_query($conn, $sql)) {
        header("Location: todos.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Todo</title>
    <link rel="stylesheet" href="css/todo.css">
</head>

<body>
    <div class="container">
        <h2>Create a New Todo</h2>
        <a class="back-button" href="index.php">Back Home</a>

        <?php if ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="title">Title:</label>
            <input type="text" name="title" required><br>

            <label for="description">Description:</label>
            <textarea name="description" required></textarea><br>

            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" required><br>

            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" required><br>

            <input type="submit" value="Add Todo">
        </form>
    </div>
</body>

</html>