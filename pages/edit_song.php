<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include '../includes/db.php'; // Include database connection

// Get the song ID from the query string
if (isset($_GET['id'])) {
    $song_id = $_GET['id'];

    // Fetch song details from the database
    $query = $conn->prepare("SELECT * FROM songs WHERE id = ?");
    $query->bind_param("i", $song_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $song = $result->fetch_assoc();
    } else {
        echo "Song not found!";
        exit();
    }
} else {
    echo "No song ID provided!";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $album = $_POST['album'];
    $song_id = $_POST['song_id'];

    // Check if a new image has been uploaded
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_folder = "../assets/images/" . $image;
        move_uploaded_file($image_tmp, $image_folder);
        $image_path = $image_folder;
    } else {
        $image_path = $song['image_path']; // Keep the existing image
    }

    // Check if a new audio file has been uploaded
    if ($_FILES['audio']['name']) {
        $audio = $_FILES['audio']['name'];
        $audio_tmp = $_FILES['audio']['tmp_name'];
        $audio_folder = "../assets/audio/" . $audio;
        move_uploaded_file($audio_tmp, $audio_folder);
        $audio_path = $audio_folder;
    } else {
        $audio_path = $song['audio_path']; // Keep the existing audio
    }

    // Update the song details in the database
    $query = $conn->prepare("UPDATE songs SET title = ?, artist = ?, album = ?, image_path = ?, audio_path = ? WHERE id = ?");
    $query->bind_param("sssssi", $title, $artist, $album, $image_path, $audio_path, $song_id);
    
    if ($query->execute()) {
        $success = "Song updated successfully!";
    } else {
        $error = "Failed to update song.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include '../includes/header.php'; ?>
</head>
<body>
    <h2>Edit Song</h2>
    <?php if (isset($success)) echo "<p>$success</p>"; ?>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="song_id" value="<?php echo $song['id']; ?>">

        <input type="text" name="title" value="<?php echo $song['title']; ?>" placeholder="Song Title" required>
        <input type="text" name="artist" value="<?php echo $song['artist']; ?>" placeholder="Artist" required>
        <input type="text" name="album" value="<?php echo $song['album']; ?>" placeholder="Album">

        <label>Current Cover Image:</label>
        <img src="<?php echo $song['image_path']; ?>" alt="Current Cover" width="100">
        <label>Upload New Cover Image (optional):</label>
        <input type="file" name="image" accept="image/*">

        <label>Current Audio File:</label>
        <audio controls>
            <source src="<?php echo $song['audio_path']; ?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
        <label>Upload New Audio File (optional):</label>
        <input type="file" name="audio" accept="audio/*">

        <button type="submit">Update Song</button>
    </form>
    
    <br>
    <a href="view_songs.php">Back to Song List</a>
</body>
</html>
