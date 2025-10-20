<?php
include 'common/header.php';

if (!isset($_GET['action']) || !isset($_GET['id'])) {
    header("Location: movies.php");
    exit();
}

$action = $_GET['action'];
$id = (int)$_GET['id'];

// Handle Delete Action
if ($action === 'delete') {
    $stmt = $conn->prepare("DELETE FROM movies WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: movies.php");
    exit();
}

// Handle Update Action
if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $release_year = $_POST['release_year'];
    $category_id = $_POST['category_id'];
    $watch_link = $_POST['watch_link'];
    $current_poster = $_POST['current_poster'];

    $poster_url = $current_poster;
    if (isset($_FILES['poster_url']) && $_FILES['poster_url']['error'] == 0) {
        $target_dir = "../uploads/";
        $poster_url = time() . '_' . basename($_FILES["poster_url"]["name"]);
        move_uploaded_file($_FILES["poster_url"]["tmp_name"], $target_dir . $poster_url);
    }

    $stmt = $conn->prepare("UPDATE movies SET title=?, poster_url=?, description=?, rating=?, release_year=?, category_id=?, watch_link=? WHERE id=?");
    $stmt->bind_param("sssdisii", $title, $poster_url, $description, $rating, $release_year, $category_id, $watch_link, $id);
    
    if ($stmt->execute()) {
        echo "<div class='bg-green-500 p-3 rounded mb-4'>Movie updated successfully! <a href='movies.php' class='underline'>Go Back</a></div>";
    } else {
        echo "<div class='bg-red-500 p-3 rounded mb-4'>Error updating movie.</div>";
    }
    $stmt->close();
}

// Fetch movie data for editing
if ($action === 'edit') {
    $stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $movie = $result->fetch_assoc();
    $stmt->close();

    if (!$movie) {
        header("Location: movies.php");
        exit();
    }
?>

<h1 class="text-3xl font-bold mb-6">Edit Movie: <?= htmlspecialchars($movie['title']) ?></h1>

<div class="bg-gray-800 p-6 rounded-lg">
    <form action="manage_movie.php?action=edit&id=<?= $id ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="hidden" name="current_poster" value="<?= htmlspecialchars($movie['poster_url']) ?>">
        <div>
            <label class="block mb-1">Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Poster Image (leave blank to keep current)</label>
            <input type="file" name="poster_url" class="w-full bg-gray-700 p-2 rounded">
            <img src="../uploads/<?= htmlspecialchars($movie['poster_url']) ?>" class="w-24 mt-2 rounded">
        </div>
        <div>
            <label class="block mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full bg-gray-700 p-2 rounded" required><?= htmlspecialchars($movie['description']) ?></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1">Rating</label>
                <input type="text" name="rating" value="<?= htmlspecialchars($movie['rating']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            </div>
            <div>
                <label class="block mb-1">Release Year</label>
                <input type="number" name="release_year" value="<?= htmlspecialchars($movie['release_year']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            </div>
        </div>
        <div>
            <label class="block mb-1">Category</label>
            <select name="category_id" class="w-full bg-gray-700 p-2 rounded" required>
                <?php
                $categories = $conn->query("SELECT * FROM categories");
                while ($cat = $categories->fetch_assoc()) {
                    $selected = ($cat['id'] == $movie['category_id']) ? 'selected' : '';
                    echo "<option value='{$cat['id']}' $selected>" . htmlspecialchars($cat['category_name']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label class="block mb-1">Watch Link</label>
            <input type="url" name="watch_link" value="<?= htmlspecialchars($movie['watch_link']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
        </div>
        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">Update Movie</button>
            <a href="movies.php" class="text-gray-400 ml-4">Cancel</a>
        </div>
    </form>
</div>

<?php
}
include 'common/bottom.php';
?>