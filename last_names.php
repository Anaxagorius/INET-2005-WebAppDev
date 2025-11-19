<?php

/*
 * APA Citation: PHP Group. (n.d.). Arrays. PHP Manual. https://www.php.net/manual/en/language.arrays.php
 *
 * APA Citation: PHP Group. (n.d.). PDO. PHP Manual. https://www.php.net/manual/en/book.pdo.php
*/

// last_names.php - Retrieves, sorts, and displays last names alphabetically

try {
    $pdo = new PDO("mysql:host=localhost;dbname=Registration", 'root', '');
    $stmt = $pdo->query("SELECT last_name FROM registered_users");
    $last_names = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); // Efficient: single column fetch
    $last_name_array = array_unique($last_names); // Remove duplicates if needed
    sort($last_name_array, SORT_STRING | SORT_FLAG_CASE); // Case-insensitive alpha sort
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<h2>Sorted Last Names</h2>
<ul>
<?php foreach ($last_name_array as $name): ?>
    <li><?php echo htmlspecialchars($name); ?></li>
<?php endforeach; ?>
</ul>

