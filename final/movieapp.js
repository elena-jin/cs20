const API_KEY = "e29ab65d466d17e8f19c3c63ab155aaa";
const API_BASE = "https://api.themoviedb.org/3";

window.onload = () => {
        loadGenres();
        loadYearList();
        loadLanguageList();
};

function loadGenres() {
        fetch(`${API_BASE}/genre/movie/list?api_key=${API_KEY}`)
                .then(res => res.json())
                .then(data => {
                let genreSelect = document.getElementById("genreSelect");
                data.genres.forEach(g => {
                        let opt = document.createElement("option");
                        opt.value = g.id;
                        opt.textContent = g.name;
                        genreSelect.appendChild(opt);
                });
        })
        .catch(err => console.log("Error loading genres:", err));
}

function loadYearList() {
        let yearSelect = document.getElementById("yearSelect");
        for (let y = 2025; y >= 1950; y--) {
                let opt = document.createElement("option");
                opt.value = y;
                opt.textContent = y;
                yearSelect.appendChild(opt);
        }
}

function loadLanguageList() {
        const languages = {
                en: "English",
                zh: "Chinese",
                ja: "Japanese",
                ko: "Korean",
                fr: "French"
        };
        let langSelect = document.getElementById("languageSelect");

        for (let code in languages) {
                let opt = document.createElement("option");
                opt.value = code;
                opt.textContent = languages[code];
                langSelect.appendChild(opt);
        }
}

function searchMovies() {
        const query = document.getElementById("searchInput").value;
        if (!query) return;

        fetch(`${API_BASE}/search/movie?api_key=${API_KEY}&query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => displayMovies(data.results))
                .catch(err => console.log("Search error:", err));
}

function applyFilters() {
        let genre = document.getElementById("genreSelect").value;
        let year = document.getElementById("yearSelect").value;
        let lang = document.getElementById("languageSelect").value;

        let url = `${API_BASE}/discover/movie?api_key=${API_KEY}`;

        if (genre) url += `&with_genres=${genre}`;
        if (year) url += `&primary_release_year=${year}`;
        if (lang) url += `&with_original_language=${lang}`;

        fetch(url)
                .then(res => res.json())
                .then(data => displayMovies(data.results))
                .catch(err => console.log("Filter error:", err));
}

function displayMovies(movies) {
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

                card.onclick = () => loadMovieDetail(m.id);

                container.appendChild(card);
        });
}

function loadMovieDetail(id) {
        fetch(`${API_BASE}/movie/${id}?api_key=${API_KEY}`)
                .then(res => res.json())
                .then(data => showModal(data))
                .catch(err => console.log(err));
}

function showModal(movie) {
        const modal = document.getElementById("movieModal");
        const body = document.getElementById("modalBody");

        let poster = movie.poster_path
                ? `https://image.tmdb.org/t/p/w500${movie.poster_path}`
                : "https://via.placeholder.com/300x450?text=No+Image";

        body.innerHTML = `
                <img src="${poster}">
                <h2>${movie.title}</h2>
                <p><strong>Release:</strong> ${movie.release_date || "N/A"}</p>
                <p><strong>Runtime:</strong> ${movie.runtime || "?"} min</p>
                <p><strong>Rating:</strong> ${movie.vote_average}</p>
                <p><strong>Overview:</strong><br>${movie.overview || "No description"}</p>
        `;

        modal.style.display = "flex";
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


