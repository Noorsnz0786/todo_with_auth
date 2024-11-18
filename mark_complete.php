<?php
include "partials/header.php";
include "partials/navigation.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todo_id = $_POST['todo_id'];

    // Update the status of the todo to 'completed'
    $sql = "UPDATE todos SET status = 'completed' WHERE id = '$todo_id'";

    if (mysqli_query($conn, $sql)) {
        // Redirect to todos page after marking complete
        header("Location: todos.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>