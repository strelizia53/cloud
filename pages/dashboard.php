<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
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
    <title>Admin Dashboard</title>
</head>
<body class="bg-gray-900 text-white">

    <!-- Admin Dashboard Container -->
    <div class="flex flex-col items-center justify-center min-h-screen p-8">
        
        <!-- Title -->
        <h1 class="text-4xl font-bold text-green-500 mb-8">Admin Dashboard</h1>

        <!-- Welcome Message -->
        <p class="text-xl mb-6">Welcome, <span class="font-semibold"><?php echo $_SESSION['username']; ?></span> (Admin)</p>

        <!-- Action Links -->
        <div class="space-y-4">
            <a href="add_song.php" class="block text-center w-48 py-2 bg-green-500 rounded-lg text-white hover:bg-green-600">
                Add a New Song
            </a>
            
            <a href="view_songs.php" class="block text-center w-48 py-2 bg-green-500 rounded-lg text-white hover:bg-green-600">
                View All Songs
            </a>
            
            <a href="../logout.php" class="block text-center w-48 py-2 bg-red-500 rounded-lg text-white hover:bg-red-600">
                Logout
            </a>
        </div>
    </div>

</body>
</html>
    