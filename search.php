<?php include 'common/header.php'; ?>

<main>
    <form action="search.php" method="GET" class="mb-8">
        <div class="relative">
            <input type="text" name="query" placeholder="Search for movies..." class="w-full bg-gray-800 border border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-red-600" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
            <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
                <i class="fas fa-search text-gray-400"></i>
            </button>
        </div>
    </form>

    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">
        <?php
        if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
            $search_query = "%" . trim($_GET['query']) . "%";
            $stmt = $conn->prepare("SELECT id, title, poster_url FROM movies WHERE title LIKE ?");
            $stmt->bind_param("s", $search_query);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($movie = $result->fetch_assoc()) {
        ?>
                    <a href="movie_details.php?id=<?= $movie['id'] ?>">
                        <img src="uploads/<?= htmlspecialchars($movie['poster_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="rounded-lg w-full h-40 md:h-60 object-cover transform hover:scale-105 transition-transform duration-300">
                    </a>
        <?php
                }
            } else {
                echo "<p class='col-span-full text-center'>No movies found for your search.</p>";
            }
            $stmt->close();
        } else {
            echo "<p class='col-span-full text-center'>Enter a search term to find movies.</p>";
        }
        ?>
    </div>
</main>

<?php include 'common/bottom.php'; ?>