<?php
session_start();
include "db.php"; // Your database connection

// Fetch all todos from the database
$sql = "SELECT * FROM todos";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Todos</title>
    <link rel="stylesheet" href="css/todo.css">
    <style>
        .todo {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
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

        .complete-button {
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .complete-button:hover {
            background-color: #218838;
        }

        .completed {
            background-color: #d4edda;
            /* Light green background */
            text-decoration: line-through;
            /* Strike-through text */
        }
    </style>
    <script>
        function toggleButton(form) {
            var button = form.querySelector('.complete-button');
            if (button.innerHTML === "Mark as Complete") {
                button.innerHTML = "Completed 😊"; // Change button text to Completed with emoji
            } else {
                button.innerHTML = "Mark as Complete"; // Revert back to original text
            }
            return true; // Allow the form to be submitted
        }
    </script>
</head>

<body>
    <div class="container">
        <h2>All Todos</h2>
        <a class="back-button" href="index.php">Back Home</a>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="todo <?php echo $row['status'] === 'completed' ? 'completed' : ''; ?>">
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <p><strong>Start Date:</strong> <?php echo $row['start_date']; ?></p>
                <p><strong>End Date:</strong> <?php echo $row['end_date']; ?></p>
                <p><strong>Author:</strong> <?php echo $row['author']; ?></p>

                <!-- Form for marking the todo as complete -->
                <form method="POST" action="mark_complete.php" onsubmit="return toggleButton(this)">
                    <input type="hidden" name="todo_id" value="<?php echo $row['id']; ?>">
                    <button class="complete-button" type="submit">
                        <?php echo $row['status'] === 'completed' ? 'Completed 😊' : 'Mark as Complete'; ?>
                    </button>
                </form>
            </div>
        <?php endwhile; ?>

        <?php mysqli_close($conn); ?>
    </div>
</body>

</html>