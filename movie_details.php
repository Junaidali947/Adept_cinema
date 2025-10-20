<?php
include 'common/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$movie_id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='text-center'>Movie not found.</p>";
    include 'common/bottom.php';
    exit();
}
$movie = $result->fetch_assoc();
$stmt->close();
?>

<main>
    <div class="relative h-64 md:h-80 rounded-lg overflow-hidden">
        <img src="uploads/<?= htmlspecialchars($movie['poster_url']) ?>" class="w-full h-full object-cover" alt="<?= htmlspecialchars($movie['title']) ?>">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
    </div>
    
    <div class="p-4">
        <h1 class="text-3xl font-bold mb-2"><?= htmlspecialchars($movie['title']) ?></h1>
        <div class="flex items-center space-x-4 mb-4 text-gray-400">
            <span>⭐ <?= htmlspecialchars($movie['rating']) ?></span>
            <span><?= htmlspecialchars($movie['release_year']) ?></span>
        </div>
        
        <a href="<?= htmlspecialchars($movie['watch_link']) ?>" target="_blank" class="block w-full bg-red-600 text-white text-center font-bold py-3 rounded-lg hover:bg-red-700 transition-colors duration-300">
            <i class="fas fa-play"></i> Watch Now
        </a>

        <div class="mt-6">
            <h2 class="text-xl font-semibold mb-2">Description</h2>
            <p class="text-gray-300 leading-relaxed"><?= nl2br(htmlspecialchars($movie['description'])) ?></p>
        </div>
    </div>
</main>

<?php include 'common/bottom.php'; ?>