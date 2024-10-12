<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php'; // Include the database connection

// Fetch the search query if it's set
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Modify the query to fetch filtered songs based on the search query
if ($search_query) {
    $query = $conn->prepare("SELECT * FROM songs WHERE title LIKE ? OR artist LIKE ? OR album LIKE ?");
    $search_term = "%" . $search_query . "%"; // Prepare the search term for the LIKE clause
    $query->bind_param("sss", $search_term, $search_term, $search_term);
} else {
    $query = $conn->prepare("SELECT * FROM songs");
}
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/header.php'; ?>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>View Songs</title>
</head>
<body class="bg-gray-900 text-white">

    <!-- Main Container -->
    <div class="flex items-center justify-center min-h-screen p-8">
        <div class="w-full max-w-5xl bg-gray-800 p-8 rounded-lg shadow-lg">

            <!-- Page Title -->
            <h1 class="text-3xl font-bold text-center text-green-500 mb-6">View Songs</h1>

            <!-- Search Form -->
            <form method="GET" action="view_songs.php" class="mb-6">
                <div class="flex justify-center">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" 
                           placeholder="Search by title, artist, or album..." 
                           class="w-full max-w-md p-2 rounded-lg bg-gray-700 border border-gray-600 text-white">
                    <button type="submit" class="ml-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Search</button>
                </div>
            </form>

            <!-- Success/Error Messages -->
            <?php if (isset($_SESSION['success'])) { echo "<p class='text-green-500 text-center mb-4'>{$_SESSION['success']}</p>"; unset($_SESSION['success']); } ?>
            <?php if (isset($_SESSION['error'])) { echo "<p class='text-red-500 text-center mb-4'>{$_SESSION['error']}</p>"; unset($_SESSION['error']); } ?>

            <!-- Song Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse border border-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="border border-gray-600 px-4 py-2">Cover</th>
                            <th class="border border-gray-600 px-4 py-2">Title</th>
                            <th class="border border-gray-600 px-4 py-2">Artist</th>
                            <th class="border border-gray-600 px-4 py-2">Album</th>
                            <th class="border border-gray-600 px-4 py-2">Audio</th>
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                            <th class="border border-gray-600 px-4 py-2">Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800">
                        <?php while ($song = $result->fetch_assoc()) { ?>
                        <tr class="border-t border-gray-700">
                            <td class="border border-gray-600 px-4 py-2">
                                <img src="<?php echo $song['image_path']; ?>" alt="Cover Image" class="w-12 h-12 object-cover rounded-lg">
                            </td>
                            <td class="border border-gray-600 px-4 py-2"><?php echo $song['title']; ?></td>
                            <td class="border border-gray-600 px-4 py-2"><?php echo $song['artist']; ?></td>
                            <td class="border border-gray-600 px-4 py-2"><?php echo $song['album']; ?></td>
                            <td class="border border-gray-600 px-4 py-2">
                                <audio controls class="w-full">
                                    <source src="<?php echo $song['audio_path']; ?>" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </td>
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                            <td class="border border-gray-600 px-4 py-2 text-center">
                                <a href="edit_song.php?id=<?php echo $song['id']; ?>" class="text-blue-400 hover:underline">Edit</a>
                                <a href="delete_song.php?id=<?php echo $song['id']; ?>" class="text-red-400 hover:underline ml-2" onclick="return confirm('Are you sure you want to delete this song?')">Delete</a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Back to Dashboard Link -->
            <div class="mt-6 text-center">
                <a href="<?php echo ($_SESSION['role'] == 'admin') ? 'dashboard.php' : 'user_dashboard.php'; ?>" 
                   class="text-green-500 hover:underline">Back to Dashboard</a>
            </div>
        </div>
    </div>

</body>
</html>
