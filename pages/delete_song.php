<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include '../includes/db.php'; // Include the database connection

if (isset($_GET['id'])) {
    $song_id = $_GET['id'];

    // Fetch the song details to get the file paths
    $query = $conn->prepare("SELECT * FROM songs WHERE id = ?");
    $query->bind_param("i", $song_id);
    $query->execute();
    $result = $query->get_result();
    
    if ($result->num_rows > 0) {
        $song = $result->fetch_assoc();

        // Delete the song from the database
        $delete_query = $conn->prepare("DELETE FROM songs WHERE id = ?");
        $delete_query->bind_param("i", $song_id);
        if ($delete_query->execute()) {
            // Optionally delete the image and audio files from the server
            if (file_exists($song['image_path'])) {
                unlink($song['image_path']); // Delete the image file
            }

            if (file_exists($song['audio_path'])) {
                unlink($song['audio_path']); // Delete the audio file
            }

            $_SESSION['success'] = "Song deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete song.";
        }
    } else {
        $_SESSION['error'] = "Song not found.";
    }
} else {
    $_SESSION['error'] = "No song ID provided.";
}

header("Location: view_songs.php"); // Redirect back to the song list
exit();
