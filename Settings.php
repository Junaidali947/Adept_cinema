<?php
include 'common/header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $app_name = $_POST['app_name'];
    
    $stmt = $conn->prepare("UPDATE settings SET app_name = ? WHERE id = 1");
    $stmt->bind_param("s", $app_name);
    
    if ($stmt->execute()) {
        $message = "<div class='bg-green-500 p-3 rounded mb-4'>Settings updated successfully!</div>";
        // Update the global var for the current page load
        $APP_NAME = $app_name;
    } else {
        $message = "<div class='bg-red-500 p-3 rounded mb-4'>Error updating settings.</div>";
    }
    $stmt->close();
}

// Fetch current settings
$result = $conn->query("SELECT app_name FROM settings WHERE id = 1");
$current_settings = $result->fetch_assoc();
?>

<h1 class="text-3xl font-bold mb-6">App Settings</h1>

<?php if (isset($message)) echo $message; ?>

<div class="bg-gray-800 p-6 rounded-lg">
    <form action="settings.php" method="POST" class="space-y-4">
        <div>
            <label for="app_name" class="block mb-1 font-semibold">Application Name</label>
            <input type="text" id="app_name" name="app_name" class="w-full bg-gray-700 p-2 rounded" value="<?= htmlspecialchars($current_settings['app_name']) ?>" required>
        </div>
        
        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded font-bold">Save Settings</button>
        </div>
    </form>
</div>

<?php include 'common/bottom.php'; ?>