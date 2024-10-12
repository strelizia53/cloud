<?php
session_start();
include '../includes/db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/header.php'; ?>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dream Streamer - Login</title>
</head>
<body class="bg-gray-900 text-white">

    <!-- Centered Container -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 bg-gray-800 rounded-lg shadow-lg">
            
            <!-- Title -->
            <h1 class="text-3xl font-bold text-center text-green-500 mb-6">Dream Streamer</h1>
            
            <!-- Login Form -->
            <h2 class="text-xl font-semibold text-center mb-4">Login</h2>

            <?php if (isset($error)) echo "<p class='text-red-500 text-center mb-4'>$error</p>"; ?>

            <form method="POST" action="login.php" class="space-y-6">
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
                        Login
                    </button>
                </div>
            </form>

            <!-- Registration Link -->
            <p class="text-center text-sm mt-4">
                Don't have an account? 
                <a href="register.php" class="text-green-500 hover:underline">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>
