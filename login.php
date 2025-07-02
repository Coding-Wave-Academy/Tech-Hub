<?php
session_start();

// Secure session settings
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false, // Use true if HTTPS is enabled
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }

    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Replace with database authentication in production
    $adminUsername = 'admin';
    $adminPassword = password_hash('password123', PASSWORD_DEFAULT);

    if ($username === $adminUsername && password_verify($password, $adminPassword)) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - TechHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #111827; /* gray-900 for dark mode */
            position: relative;
            z-index: 1;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(circle at top center, rgba(79, 70, 229, 0.25) 0%, rgba(17, 24, 39, 0) 60%);
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>
<body class="text-gray-200 relative min-h-screen">


    <main class="container mx-auto px-4 py-8 relative z-10">
        <section class="max-w-md mx-auto bg-gray-800 p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-center text-gray-100 mb-6">Admin Login</h1>
            <?php if (isset($error)): ?>
                <p class="bg-red-500 text-white px-4 py-2 rounded mb-4 text-center">
                    <?php echo htmlspecialchars($error); ?>
                </p>
            <?php endif; ?>
            <form method="POST" action="" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-300">Username</label>
                    <input type="text" id="username" name="username" required
                        class="w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Login
                </button>
            </form>
        </section>
    </main>

    
</body>
</html>