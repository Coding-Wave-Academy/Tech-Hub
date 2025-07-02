<!-- filepath: c:\Users\krisk\Documents\Web Projects\TechHub\conn.php -->
<?php
// Database connection
$host = 'sql105.infinityfree.com';
$dbname = 'if0_38903511_techub';
$username = 'if0_38903511';
$password = 'Googlefaf21';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>