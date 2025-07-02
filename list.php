<?php
require_once 'conn.php'; // Include the database connection file

// Initialize the search query
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Fetch assets from the database based on the search query
if (!empty($searchQuery)) {
    $query = "SELECT * FROM assets WHERE title LIKE :search";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':search', '%' . $searchQuery . '%', PDO::PARAM_STR);
    $stmt->execute();
} else {
    $query = "SELECT * FROM assets";
    $stmt = $pdo->query($query);
}

$assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Resources - TechHub</title>
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
                <a href="./index.html" class="text-gray-300 hover:text-indigo-400">Home</a>
                <a href="./list.php" class="text-gray-300 hover:text-indigo-400">Resources</a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold mb-6 text-gray-100">Available Assets</h1>
        <div class="mt-6 max-w-xl mx-auto mb-20">
            <form method="GET" action="list.php">
                <label for="search" class="sr-only">Search</label>
                <input type="text" id="search" name="search" placeholder="Search resources (e.g., React, Figma)..."
                    value="<?= htmlspecialchars($searchQuery) ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
            </form>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if (!empty($assets)): ?>
                <?php foreach ($assets as $asset): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden card-hover-effect">
                        <img src="<?= htmlspecialchars($asset['image_url']) ?>" alt="<?= htmlspecialchars($asset['title']) ?>" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <span class="inline-block bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2">
                                <?= htmlspecialchars($asset['type']) ?>
                            </span>
                            <h3 class="font-semibold text-lg mb-1 text-gray-900 dark:text-white"><?= htmlspecialchars($asset['title']) ?></h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2"><?= htmlspecialchars($asset['description']) ?></p>
                            <div class="flex justify-between items-center">
                                <?php if ($asset['price'] == 0): ?>
                                    <a href="<?= htmlspecialchars($asset['download_url']) ?>" class="bg-indigo-600 text-white px-3 py-1.5 rounded-md hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-sm font-medium" target="_blank">Download</a>
                                <?php else: ?>
                                    <div class="text-right">
                                        <span class="block text-lg font-semibold text-indigo-600 dark:text-indigo-400">XAF <?= htmlspecialchars($asset['price']) ?></span>
                                        <button class="mt-1 bg-green-600 text-white px-3 py-1.5 rounded-md hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-sm font-medium">Get Access</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-400">No assets found matching your search.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer class="bg-gray-900 text-gray-400 mt-12 py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> TechHub. All rights reserved.</p>
            <div class="mt-2 space-x-4 text-sm">
                <a href="#" class="hover:text-indigo-400">Privacy Policy</a>
                <a href="#" class="hover:text-indigo-400">Terms of Service</a>
            </div>
        </div>
    </footer>
</body>
</html>