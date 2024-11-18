<?php
// Include the header and navigation partials
include "partials/header.php";
include "partials/navigation.php";
?>

<!-- Main container -->
<div class="container">

    <!-- Hero section -->
    <div class="hero">
        <div class="hero-content">
    <h1>Welcome to Our TODO App</h1>
    <p>Securely create and manage your todos with us.</p>
    <p>Stay organized, increase your productivity, and never miss a deadline again! With our intuitive interface, you can easily add, update, and complete your tasks, all while keeping track of your progress.</p>
    <div class="hero-buttons">
        <?php if (!is_user_logged_in()): ?>
            <a class="btn" href="login.php">Login</a>
            <a class="btn" href="register.php">Register</a>
        <?php endif; ?>
    </div>
    <h2>Features:</h2>
    <ul>
        <li>🌟 **User-Friendly Interface:** Easily navigate through your todos with our sleek design.</li>
        <li>🗓️ **Date Management:** Set start and end dates for each task to help you stay on track.</li>
        <li>✅ **Mark as Complete:** Instantly mark tasks as complete and keep your list up to date.</li>
        <li>🔒 **Secure Management:** Your data is safe with us—always.</li>
    </ul>
            <!-- Display buttons for login and registration if the user is not logged in -->
            
        </div>
    </div>

</div>

<!-- Include the footer partial -->
<?php include "partials/footer.php"; ?>