<?php
include 'common/header.php';

// Handle Add/Edit/Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        $name = $_POST['category_name'];
        $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
    } elseif (isset($_POST['edit_category'])) {
        $name = $_POST['category_name'];
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE categories SET category_name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
    }
}
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: categories.php");
    exit();
}
?>

<h1 class="text-3xl font-bold mb-6">Manage Categories</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Add/Edit Form -->
    <div class="bg-gray-800 p-6 rounded-lg">
        <?php
        $edit_mode = isset($_GET['edit']);
        $cat_name = '';
        $cat_id = '';
        if ($edit_mode) {
            $id = (int)$_GET['edit'];
            $result = $conn->query("SELECT * FROM categories WHERE id = $id");
            $category = $result->fetch_assoc();
            $cat_name = $category['category_name'];
            $cat_id = $category['id'];
        }
        ?>
        <h2 class="text-xl font-semibold mb-4"><?= $edit_mode ? 'Edit Category' : 'Add New Category' ?></h2>
        <form action="categories.php" method="POST">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="id" value="<?= $cat_id ?>">
            <?php endif; ?>
            <div class="mb-4">
                <label class="block mb-1">Category Name</label>
                <input type="text" name="category_name" value="<?= htmlspecialchars($cat_name) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            </div>
            <?php if ($edit_mode): ?>
                <button type="submit" name="edit_category" class="bg-blue-600 px-4 py-2 rounded">Update Category</button>
                <a href="categories.php" class="text-gray-400 ml-2">Cancel</a>
            <?php else: ?>
                <button type="submit" name="add_category" class="bg-blue-600 px-4 py-2 rounded">Add Category</button>
            <?php endif; ?>
        </form>
    </div>

    <!-- List Categories -->
    <div class="bg-gray-800 p-6 rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Existing Categories</h2>
        <table class="w-full text-left">
             <thead>
                <tr class="border-b border-gray-700">
                    <th class="p-2">Name</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $categories = $conn->query("SELECT * FROM categories ORDER BY category_name");
                while ($cat = $categories->fetch_assoc()) :
                ?>
                <tr class="border-b border-gray-700">
                    <td class="p-2"><?= htmlspecialchars($cat['category_name']) ?></td>
                    <td class="p-2">
                        <a href="categories.php?edit=<?= $cat['id'] ?>" class="text-blue-400 hover:underline mr-4">Edit</a>
                        <a href="categories.php?delete=<?= $cat['id'] ?>" onclick="return confirm('Are you sure?')" class="text-red-400 hover:underline">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'common/bottom.php'; ?>