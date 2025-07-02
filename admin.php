<?php
require_once 'conn.php'; // Include the database connection file

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $download_url = $_POST['download_url']; // New field for the download link

    // Insert the asset into the database
    $query = "INSERT INTO assets (title, description, type, price, image_url, download_url) VALUES (:title, :description, :type, :price, :image_url, :download_url)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image_url', $image_url);
    $stmt->bindParam(':download_url', $download_url);

    if ($stmt->execute()) {
        $success_message = "Asset added successfully!";
    } else {
        $error_message = "Failed to add the asset. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Add Asset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #111827;
            color: #e5e7eb;
        }
    </style>
</head>
<body class="text-gray-200">
    <header class="bg-gray-800 shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="index.html" class="text-2xl font-bold text-indigo-400">TechHub</a>
            <div class="flex items-center space-x-4">
                <a href="list.php" class="text-gray-300 hover:text-indigo-400">View Assets</a>
                <a href="#" class="text-gray-300 hover:text-indigo-400">Admin</a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold mb-6 text-gray-100">Add New Asset</h1>

        <?php if (!empty($success_message)): ?>
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                <?= htmlspecialchars($success_message) ?>
            </div>
        <?php elseif (!empty($error_message)): ?>
            <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <form action="admin.php" method="POST" class="bg-gray-800 p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-300">Title</label>
                <input type="text" id="title" name="title" class="w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-300">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white" required></textarea>
            </div>
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-300">Type</label>
                <select id="type" name="type" class="w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white" required>
                    <option value="Free">Free</option>
                    <option value="Premium">Premium</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-300">Price (XAF)</label>
                <input type="number" id="price" name="price" step="0.01" class="w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white" required>
            </div>
            <div class="mb-4">
                <label for="image_url" class="block text-sm font-medium text-gray-300">Image URL</label>
                <input type="url" id="image_url" name="image_url" class="w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white" required>
            </div>
            <div class="mb-4">
                <label for="download_url" class="block text-sm font-medium text-gray-300">Download URL</label>
                <input type="url" id="download_url" name="download_url" class="w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white" required>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Add Asset</button>
        </form>
    </main>

    <footer class="bg-gray-900 text-gray-400 mt-12 py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> TechHub. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>