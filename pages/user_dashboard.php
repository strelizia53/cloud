<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/header.php'; ?>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>User Dashboard</title>
</head>
<body class="bg-gray-900 text-white">

    <!-- Main Container -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 bg-gray-800 rounded-lg shadow-lg">
            
            <!-- Page Title -->
            <h1 class="text-3xl font-bold text-center text-green-500 mb-6">User Dashboard</h1>
            
            <!-- Welcome Message -->
            <p class="text-xl text-center mb-6">Welcome, <span class="font-semibold"><?php echo $_SESSION['username']; ?></span>!</p>

            <!-- Action Links -->
            <div class="space-y-4">
                <a href="view_songs.php" class="block text-center w-full py-2 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600">
                    Browse Songs
                </a>
                <a href="../logout.php" class="block text-center w-full py-2 bg-red-500 text-white font-bold rounded-lg hover:bg-red-600">
                    Logout
                </a>
            </div>
        </div>
    </div>

</body>
</html>
