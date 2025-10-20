<?php include 'common/header.php'; ?>

<main>
    <h2 class="text-2xl font-bold mb-6">All Categories</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <?php
        $categories = $conn->query("SELECT * FROM categories ORDER BY category_name ASC");
        while ($category = $categories->fetch_assoc()) :
        ?>
        <a href="search.php?category=<?= $category['id'] ?>" class="block bg-gray-800 p-6 rounded-lg text-center hover:bg-red-600 transition-colors duration-300">
            <span class="font-semibold text-lg"><?= htmlspecialchars($category['category_name']) ?></span>
        </a>
        <?php endwhile; ?>
    </div>
</main>

<?php include 'common/bottom.php'; ?>