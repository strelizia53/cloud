### **Dream Streamer**

```markdown
# Music Player Application 🎶

This is a PHP-based music player web application with user authentication and role-based access control (admin and user roles). Users can register, log in, and view a list of songs, while admins can manage songs (create, update, and delete songs). The application includes file upload functionality for song audio and cover images, along with a search feature to filter songs.

## Features 🚀
- User Registration and Login system
- Role-based dashboards for **admin** and **user**
- Add, edit, and delete songs (Admin only)
- View and play songs (All users)
- Search functionality to filter songs by title, artist, or album
- File uploads for audio and cover images
- Spotify-inspired black theme with green accents
- Built using **PHP**, **MySQL**, **HTML**, **CSS**, and **Tailwind CSS**

## Setup Instructions 🛠️

### Prerequisites
- **XAMPP** or **MAMP**: To run a local PHP and MySQL server
- **PHP 7.x** or higher
- **MySQL 5.x** or higher

### Step 1: Clone the Repository
```bash
git clone https://github.com/yourusername/music_player_app.git
```

### Step 2: Set Up the Database
1. Open phpMyAdmin (usually `http://localhost/phpmyadmin`).
2. Create a new database called `music_player_db`.
3. Run the following SQL commands to create the necessary tables:

```sql
CREATE DATABASE music_player_db;

USE music_player_db;

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create songs table
CREATE TABLE songs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    artist VARCHAR(255) NOT NULL,
    album VARCHAR(255),
    image_path VARCHAR(255),
    audio_path VARCHAR(255),
    uploaded_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id)
);
```

### Step 3: Configure the Database Connection
1. Open the `includes/db.php` file.
2. Update the MySQL credentials as per your local setup:

```php
$servername = "localhost";  // Keep localhost for local server
$username = "root";         // Default XAMPP/MAMP username
$password = "";             // Leave empty for no password (default in XAMPP/MAMP)
$dbname = "music_player_db"; // Name of the database you created
```

### Step 4: Run the Application
1. Place the project folder in the **htdocs** directory (for XAMPP) or the **MAMP** equivalent.
2. Open your browser and go to `http://localhost/music_player_app/`.
3. You will be directed to the login or registration page.

### Step 5: Optional: Insert Sample Data
You can manually insert sample users or songs via the MySQL database.

#### Sample Admin User:
```sql
INSERT INTO users (username, password, role) VALUES ('admin', '$2y$10$abc123', 'admin');
```
- Password: `admin123` (make sure to hash it using PHP's `password_hash()` function).

## Usage Instructions 📖

### For Admin Users:
1. **Login**: Log in using the admin credentials.
2. **Dashboard**: Navigate to the admin dashboard.
3. **Add Songs**: You can add new songs by filling out the form and uploading audio files and cover images.
4. **Edit/Delete**: You can also edit or delete songs as needed.
5. **View Songs**: Search, view, and play songs in the song list.

### For Regular Users:
1. **Register**: Create an account by registering.
2. **Login**: Log in using the created account.
3. **View Songs**: Browse the list of available songs, use the search feature, and play songs directly from the interface.

## Features to be Added (Future Improvements) 🌟
- **User playlists**: Allow users to create and manage playlists.
- **Favorite songs**: Let users mark songs as favorites.
- **Pagination**: Implement pagination for long song lists.
- **Song duration**: Show the duration of each song in the list.
- **Profile management**: Add user profile update features.

## Troubleshooting 🐞

### Common Issues
- **Database connection errors**: Ensure that `db.php` has the correct MySQL credentials.
- **File upload errors**: Ensure that the `assets/images` and `assets/audio` directories have proper write permissions.
- **Maximum file upload size**: Adjust `upload_max_filesize` and `post_max_size` in the `php.ini` file if you're dealing with large audio files.

### Debugging Tips
- **Enable error reporting in PHP**:
```php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

## License 📜
This project is licensed under the MIT License.

## Contact & Contribution 🤝
Feel free to contribute to this project by forking the repository, making enhancements, or reporting bugs. For any questions, contact me at [your.email@example.com].
```

---

### **Explanation of Sections:**
1. **Features**: A list of what the application does.
2. **Project Structure**: Describes the directory layout and important files.
3. **Setup Instructions**: Step-by-step guide on how to install and run the project locally.
4. **Usage Instructions**: Explains how to use the app for both admins and regular users.
5. **Future Improvements**: A section for enhancements and features you plan to add in the future.
6. **Troubleshooting**: Common issues and how to resolve them.
7. **License & Contributions**: Information on licensing and how others can contribute.

Feel free to customize the **README** based on your project’s actual features and requirements. Let me know if you'd like further modifications or additional sections! 🎶👾