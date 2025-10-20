<?php
include 'common/header.php';

// Handle Add/Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_banner'])) {
    $target_movie_id = $_POST['target_movie_id'];
    
    $banner_image_url = '';
    if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] == 0) {
        $target_dir = "../uploads/";
        $banner_image_url = 'banner_' . time() . '_' . basename($_FILES["banner_image"]["name"]);
        move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_dir . $banner_image_url);
    }

    $stmt = $conn->prepare("INSERT INTO banners (banner_image_url, target_movie_id) VALUES (?, ?)");
    $stmt->bind_param("si", $banner_image_url, $target_movie_id);
    $stmt->execute();
}
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM banners WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: banners.php");
    exit();
}
?>

<h1 class="text-3xl font-bold mb-6">Manage Banners</h1>

<!-- Add Banner Form -->
<div class="bg-gray-800 p-6 rounded-lg mb-8">
    <h2 class="text-xl font-semibold mb-4">Add New Banner</h2>
    <form action="banners.php" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block mb-1">Banner Image (Recommended: 1280x720)</label>
            <input type="file" name="banner_image" class="w-full bg-gray-700 p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Links to Movie</label>
            <select name="target_movie_id" class="w-full bg-gray-700 p-2 rounded" required>
                <option value="">Select a Movie</option>
                 <?php
                $movies = $conn->query("SELECT id, title FROM movies ORDER BY title");
                while ($movie = $movies->fetch_assoc()) {
                    echo "<option value='{$movie['id']}'>" . htmlspecialchars($movie['title']) . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="add_banner" class="bg-blue-600 px-4 py-2 rounded">Add Banner</button>
    </form>
</div>

<!-- List Banners -->
<div class="bg-gray-800 p-6 rounded-lg">
    <h2 class="text-xl font-semibold mb-4">Existing Banners</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <?php
        $banners = $conn->query("SELECT * FROM banners ORDER BY created_at DESC");
        while ($banner = $banners->fetch_assoc()) :
        ?>
        <div class="relative">
            <img src="../uploads/<?= htmlspecialchars($banner['banner_image_url']) ?>" class="w-full h-32 object-cover rounded">
            <a href="banners.php?delete=<?= $banner['id'] ?>" onclick="return confirm('Are you sure?')" class="absolute top-2 right-2 bg-red-600 text-white rounded-full h-6 w-6 flex items-center justify-center">&times;</a>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'common/bottom.php'; ?>