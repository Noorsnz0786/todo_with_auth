<?php

session_start();
include "db.php"; // Your database connection

// Check if the user is logged in and authorized
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$todo_id = $_GET['id'];
$error = "";

// Fetch todo details to edit
$sql = "SELECT * FROM todos WHERE id = $todo_id";
$result = mysqli_query($conn, $sql);
$todo = mysqli_fetch_assoc($result);

// Handle the form submission for updating the todo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

    if (empty($title) || empty($description) || empty($start_date) || empty($end_date)) {
        $error = "All fields are required.";
    } else {
        $update_sql = "UPDATE todos SET title = '$title', description = '$description', start_date = '$start_date', end_date = '$end_date' WHERE id = $todo_id";

        if (mysqli_query($conn, $update_sql)) {
            header("Location: managetodos.php"); // Redirect after updating
            exit;
        } else {
            $error = "Error updating todo: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Todo</title>
    <link rel="stylesheet" href="css/todo.css">
    <a  class="back-button" href="index.php">Back Home</a>
</head>

<body>
    <div class="container">
        <h2>Edit Todo</h2>

        <?php if ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo $todo['title']; ?>" required><br>

            <label for="description">Description:</label>
            <textarea name="description" required><?php echo $todo['description']; ?></textarea><br>

            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" value="<?php echo $todo['start_date']; ?>" required><br>

            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" value="<?php echo $todo['end_date']; ?>" required><br>

            <input type="submit" value="Update Todo">
        </form>
    </div>
</body>

</html>