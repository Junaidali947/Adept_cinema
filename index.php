<?php
include 'common/header.php';

// Fetch stats
$total_movies = $conn->query("SELECT COUNT(*) as count FROM movies")->fetch_assoc()['count'];
$total_categories = $conn->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc()['count'];
$total_banners = $conn->query("SELECT COUNT(*) as count FROM banners")->fetch_assoc()['count'];
?>

<h1 class="text-3xl font-bold mb-6">Dashboard</h1>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gray-800 p-6 rounded-lg">
        <h2 class="text-lg font-semibold text-gray-400">Total Movies</h2>
        <p class="text-4xl font-bold mt-2"><?= $total_movies ?></p>
    </div>
    <div class="bg-gray-800 p-6 rounded-lg">
        <h2 class="text-lg font-semibold text-gray-400">Total Categories</h2>
        <p class="text-4xl font-bold mt-2"><?= $total_categories ?></p>
    </div>
    <div class="bg-gray-800 p-6 rounded-lg">
        <h2 class="text-lg font-semibold text-gray-400">Total Banners</h2>
        <p class="text-4xl font-bold mt-2"><?= $total_banners ?></p>
    </div>
</div>

<!-- Quick Actions -->
<div class="flex space-x-4">
    <a href="movies.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
        <i class="fas fa-plus mr-2"></i>Add New Movie
    </a>
    <a href="categories.php" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
        <i class="fas fa-plus mr-2"></i>Add New Category
    </a>
</div>

<?php include 'common/bottom.php'; ?>