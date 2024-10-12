<?php
session_start();
include '../includes/db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    $check_query = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check_query->bind_param("s", $username);
    $check_query->execute();
    $check_result = $check_query->get_result();

    if ($check_result->num_rows > 0) {
        $error = "Username is already taken.";
    } else {
        $query = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
        $query->bind_param("ss", $username, $password);
        if ($query->execute()) {
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'user';
            header("Location: user_dashboard.php");
            exit();
        } else {
            $error = "Registration failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/header.php'; ?>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dream Streamer - Register</title>
</head>
<body class="bg-gray-900 text-white">

    <!-- Centered Container -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 bg-gray-800 rounded-lg shadow-lg">
            
            <!-- Title -->
            <h1 class="text-3xl font-bold text-center text-green-500 mb-6">Dream Streamer</h1>
            
            <!-- Register Form -->
            <h2 class="text-xl font-semibold text-center mb-4">Register</h2>

            <?php if (isset($error)) echo "<p class='text-red-500 text-center mb-4'>$error</p>"; ?>

            <form method="POST" action="register.php" class="space-y-6">
                <!-- Username Input -->
                <div>
                    <input type="text" name="username" placeholder="Username" required 
                           class="w-full px-4 py-2 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Password Input -->
                <div>
                    <input type="password" name="password" placeholder="Password" required 
                           class="w-full px-4 py-2 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="w-full py-2 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600">
                        Register
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <p class="text-center text-sm mt-4">
                Already have an account? 
                <a href="login.php" class="text-green-500 hover:underline">Login here</a>
            </p>
        </div>
    </div>
</body>
</html>
    