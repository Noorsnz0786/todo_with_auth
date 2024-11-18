<?php
session_start();
include "db.php"; // Your database connection

// Check if the user is logged in and authorized
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Fetch all todos from the database
$sql = "SELECT * FROM todos";
$result = mysqli_query($conn, $sql);

// Handle delete todo
if (isset($_POST['delete_todo'])) {
    $todo_id = $_POST['todo_id'];
    $delete_sql = "DELETE FROM todos WHERE id = $todo_id";
    mysqli_query($conn, $delete_sql);
    header("Location: managetodos.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Todos</title>
    <link rel="stylesheet" href="css/todo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        input[type="submit"] {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #c82333;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            margin-left: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
        .edit-link {
    display: inline-block;
    padding: 5px 10px;
    background-color: #007BFF; /* Blue background */
    color: white; /* White text */
    text-decoration: none; /* No underline */
    border-radius: 5px; /* Rounded corners */
    transition: background-color 0.3s; /* Smooth transition */
    margin-left: 10px; /* Space between buttons */
}

.edit-link:hover {
    background-color: #0056b3; /* Darker blue on hover */
}

    </style>
</head>

<body>
    <div class="container">
        <h2>Manage Todos</h2>
        <a class="back-button" href="index.php">Back Home</a>

        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['author']); ?></td>
                    <td>
                        <a class="edit-link" href="edit_todo.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <form method="POST" action="">
                            <input type="hidden" name="todo_id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="delete_todo" value="Delete">
                        </form>
                        

                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <?php mysqli_close($conn); ?>
    </div>
</body>

</html>