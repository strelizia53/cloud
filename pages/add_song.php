<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include '../includes/db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $album = $_POST['album'];

    // Handle image file upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = "../assets/images/" . $image;
    move_uploaded_file($image_tmp, $image_folder);

    // Handle audio file upload
    $audio = $_FILES['audio']['name'];
    $audio_tmp = $_FILES['audio']['tmp_name'];
    $audio_folder = "../assets/audio/" . $audio;
    move_uploaded_file($audio_tmp, $audio_folder);

    // Insert the song into the database
    $query = $conn->prepare("INSERT INTO songs (title, artist, album, image_path, audio_path, uploaded_by) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("sssssi", $title, $artist, $album, $image_folder, $audio_folder, $_SESSION['user_id']);
    
    if ($query->execute()) {
        $success = "Song added successfully!";
    } else {
        $error = "Failed to add song.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/header.php'; ?>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Add a New Song</title>
</head>
<body class="bg-gray-900 text-white">

    <!-- Main Container -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 bg-gray-800 rounded-lg shadow-lg">

            <!-- Page Title -->
            <h1 class="text-3xl font-bold text-center text-green-500 mb-6">Add a New Song</h1>

            <!-- Success/Error Message -->
            <?php if (isset($success)) echo "<p class='text-green-500 text-center mb-4'>$success</p>"; ?>
            <?php if (isset($error)) echo "<p class='text-red-500 text-center mb-4'>$error</p>"; ?>

            <!-- Add Song Form -->
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Song Title Input -->
                <div>
                    <input type="text" name="title" placeholder="Song Title" required
                           class="w-full px-4 py-2 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Artist Input -->
                <div>
                    <input type="text" name="artist" placeholder="Artist" required
                           class="w-full px-4 py-2 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Album Input -->
                <div>
                    <input type="text" name="album" placeholder="Album (Optional)"
                           class="w-full px-4 py-2 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block mb-2">Upload Song Cover Image:</label>
                    <input type="file" name="image" accept="image/*" required
                           class="w-full px-4 py-2 text-gray-500 bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Audio Upload -->
                <div>
                    <label class="block mb-2">Upload Audio File:</label>
                    <input type="file" name="audio" accept="audio/*" required
                           class="w-full px-4 py-2 text-gray-500 bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="w-full py-2 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600">
                        Add Song
                    </button>
                </div>
            </form>

            <!-- Back to Dashboard Link -->
            <p class="text-center text-sm mt-4">
                <a href="dashboard.php" class="text-green-500 hover:underline">Back to Dashboard</a>
            </p>
        </div>
    </div>
</body>
</html>
