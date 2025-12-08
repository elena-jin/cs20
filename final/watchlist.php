<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Watchlist</title>
    <link rel="stylesheet" href="moviestyle.css">
</head>
<body>
    <div class="banner">
        <h1>My Watchlist</h1> <br>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search movies...">
            <button onclick="searchMovies()">Search</button>
        </div>
    </div>

    <?php
    $host = 'localhost';
    $dbname = 'users_db';
    $username = 'your_username';
    $password = 'your_password';
    //fill these

    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn) {
        die("<p>Connection failed: " . mysqli_connect_error() . "</p>");
    }

    session_start();
    $userId = $_SESSION['user_id'] ?? null;
    ?>

    <div id="moviesContainer" class="movies-container">
        <?php
        if ($userId) {
            $stmt = mysqli_prepare($conn, "
                SELECT tmdb_id, title, poster_path, release_date 
                FROM user_watchlist 
                WHERE user_id = ? AND on_watchlist = 1
                ORDER BY added_date DESC
            ");
            
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                while ($movie = mysqli_fetch_assoc($result)) {
                    $poster = !empty($movie['poster_path']) 
                        ? "https://image.tmdb.org/t/p/w500" . $movie['poster_path']
                        : "https://via.placeholder.com/300x450?text=No+Image";
                    
                    $year = !empty($movie['release_date']) 
                        ? substr($movie['release_date'], 0, 4) 
                        : "";
                    
                    $tmdbId = htmlspecialchars($movie['tmdb_id']);
                    $movieId = 'tmdb_' . $tmdbId;
                    $title = htmlspecialchars($movie['title']);
                    ?>
                    <div class='movie-card' onclick="location.href='movies.php?tmdb_id=<?php echo $tmdbId; ?>&movieId=<?php echo $movieId; ?>'">
                        <img src='<?php echo $poster; ?>' alt='<?php echo $title; ?>'>
                        <p><?php echo $title; ?></p>
                        <p style='opacity:0.7'><?php echo $year; ?></p>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No movies in your watchlist yet. Start adding some!</p>";
            }
            
            mysqli_stmt_close($stmt);
        } else {
            echo "<p>Please <a href='login.php'>log in</a> to view your watchlist.</p>";
        }

        mysqli_close($conn);
        ?>
    </div>

    <div id="movieModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="modalCloseBtn">&times;</span>
            <div id="modalBody"></div>
        </div>
    </div>

    <script>
    const API_KEY = "e29ab65d466d17e8f19c3c63ab155aaa";
    const API_BASE = "https://api.themoviedb.org/3";

    function searchMovies() {
        const query = document.getElementById("searchInput").value;
        if (!query) return;

        fetch(`${API_BASE}/search/movie?api_key=${API_KEY}&query=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => displaySearchResults(data.results))
            .catch(err => console.log("Search error:", err));
    }

    function displaySearchResults(movies) {
        const container = document.getElementById("moviesContainer");
        container.innerHTML = "";

        if (!movies || movies.length === 0) {
            container.innerHTML = "<p>No movies found.</p>";
            return;
        }

        movies.forEach(m => {
            let card = document.createElement("div");
            card.classList.add("movie-card");

            let poster = m.poster_path
                ? `https://image.tmdb.org/t/p/w500${m.poster_path}`
                : "https://via.placeholder.com/300x450?text=No+Image";

            card.innerHTML = `
                <img src="${poster}">
                <p>${m.title}</p>
                <p style="opacity:0.7">${m.release_date ? m.release_date.slice(0, 4) : ""}</p>
            `;

            card.onclick = () => {
                const tmdbId = m.id;
                const movieId = 'tmdb_' + tmdbId;
                window.location.href = `movies.php?tmdb_id=${encodeURIComponent(tmdbId)}&movieId=${encodeURIComponent(movieId)}`;
            };

            container.appendChild(card);
        });
    }

    document.getElementById("modalCloseBtn").onclick = () => {
        document.getElementById("movieModal").style.display = "none";
    };

    window.onclick = function(e) {
        const modal = document.getElementById("movieModal");
        if (e.target === modal) {
            modal.style.display = "none";
        }
    };
    </script>
</body>
</html>
