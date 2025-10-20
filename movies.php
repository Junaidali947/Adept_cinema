<?php
include 'common/header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_movie'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $release_year = $_POST['release_year'];
    $category_id = $_POST['category_id'];
    $watch_link = $_POST['watch_link'];

    // Handle file upload
    $poster_url = '';
    if (isset($_FILES['poster_url']) && $_FILES['poster_url']['error'] == 0) {
        $target_dir = "../uploads/";
        $poster_url = time() . '_' . basename($_FILES["poster_url"]["name"]);
        $target_file = $target_dir . $poster_url;
        move_uploaded_file($_FILES["poster_url"]["tmp_name"], $target_file);
    }
    
    $stmt = $conn->prepare("INSERT INTO movies (title, poster_url, description, rating, release_year, category_id, watch_link) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdisi", $title, $poster_url, $description, $rating, $release_year, $category_id, $watch_link);
    
    if ($stmt->execute()) {
        echo "<div class='bg-green-500 p-3 rounded mb-4'>Movie added successfully!</div>";
    } else {
        echo "<div class='bg-red-500 p-3 rounded mb-4'>Error adding movie.</div>";
    }
    $stmt->close();
}
?>

<h1 class="text-3xl font-bold mb-6">Manage Movies</h1>

<!-- Add Movie Form -->
<div class="bg-gray-800 p-6 rounded-lg mb-8">
    <h2 class="text-xl font-semibold mb-4">Add New Movie</h2>
    <form action="movies.php" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block mb-1">Title</label>
            <input type="text" name="title" class="w-full bg-gray-700 p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Poster Image</label>
            <input type="file" name="poster_url" class="w-full bg-gray-700 p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full bg-gray-700 p-2 rounded" required></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1">Rating (e.g., 8.5)</label>
                <input type="text" name="rating" class="w-full bg-gray-700 p-2 rounded" required>
            </div>
            <div>
                <label class="block mb-1">Release Year</label>
                <input type="number" name="release_year" class="w-full bg-gray-700 p-2 rounded" required>
            </div>
        </div>
        <div>
            <label class="block mb-1">Category</label>
            <select name="category_id" class="w-full bg-gray-700 p-2 rounded" required>
                <?php
                $categories = $conn->query("SELECT * FROM categories");
                while ($cat = $categories->fetch_assoc()) {
                    echo "<option value='{$cat['id']}'>" . htmlspecialchars($cat['category_name']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label class="block mb-1">Watch Link</label>
            <input type="url" name="watch_link" class="w-full bg-gray-700 p-2 rounded" required>
        </div>
        <div>
            <button type="submit" name="add_movie" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">Add Movie</button>
        </div>
    </form>
</div>

<!-- List of Movies -->
<div class="bg-gray-800 p-6 rounded-lg">
    <h2 class="text-xl font-semibold mb-4">Existing Movies</h2>
    <table class="w-full text-left">
        <thead>
            <tr class="border-b border-gray-700">
                <th class="p-2">Title</th>
                <th class="p-2">Category</th>
                <th class="p-2">Year</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $movies = $conn->query("SELECT m.id, m.title, m.release_year, c.category_name FROM movies m JOIN categories c ON m.category_id = c.id ORDER BY m.created_at DESC");
            while ($movie = $movies->fetch_assoc()) :
            ?>
            <tr class="border-b border-gray-700">
                <td class="p-2"><?= htmlspecialchars($movie['title']) ?></td>
                <td class="p-2"><?= htmlspecialchars($movie['category_name']) ?></td>
                <td class="p-2"><?= htmlspecialchars($movie['release_year']) ?></td>
                <td class="p-2">
                    <a href="manage_movie.php?action=edit&id=<?= $movie['id'] ?>" class="text-blue-400 hover:underline mr-4">Edit</a>
                    <a href="manage_movie.php?action=delete&id=<?= $movie['id'] ?>" onclick="return confirm('Are you sure?')" class="text-red-400 hover:underline">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'common/bottom.php'; ?>