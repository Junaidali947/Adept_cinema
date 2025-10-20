<?php include 'common/header.php'; ?>

<main>
    <!-- Banners Slider -->
    <section class="mb-8">
        <div class="relative w-full h-48 md:h-64 rounded-lg overflow-hidden">
            <?php
            $banners = $conn->query("SELECT * FROM banners ORDER BY created_at DESC LIMIT 5");
            while ($banner = $banners->fetch_assoc()) :
            ?>
            <a href="movie_details.php?id=<?= $banner['target_movie_id'] ?>">
                <img src="uploads/<?= htmlspecialchars($banner['banner_image_url']) ?>" class="w-full h-full object-cover" alt="Banner">
            </a>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Movie Categories -->
    <?php
    $categories = $conn->query("SELECT * FROM categories ORDER BY category_name ASC");
    while ($category = $categories->fetch_assoc()) :
    ?>
    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-4"><?= htmlspecialchars($category['category_name']) ?></h2>
        <div class="flex overflow-x-auto space-x-4 pb-4 no-scrollbar">
            <?php
            $cat_id = $category['id'];
            $movies = $conn->query("SELECT id, poster_url, title FROM movies WHERE category_id = $cat_id ORDER BY release_year DESC");
            while ($movie = $movies->fetch_assoc()) :
            ?>
            <a href="movie_details.php?id=<?= $movie['id'] ?>" class="flex-shrink-0">
                <div class="w-32 md:w-40">
                    <img src="uploads/<?= htmlspecialchars($movie['poster_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="rounded-lg w-full h-48 md:h-60 object-cover transform hover:scale-105 transition-transform duration-300">
                </div>
            </a>
            <?php endwhile; ?>
        </div>
    </section>
    <?php endwhile; ?>
</main>

<?php include 'common/bottom.php'; ?>