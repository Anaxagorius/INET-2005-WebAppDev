<?php

/*
 * APA Citation: PHP Group. (n.d.). Arrays. PHP Manual. https://www.php.net/manual/en/language.arrays.php
 *
 * APA Citation: PHP Group. (n.d.). PDO. PHP Manual. https://www.php.net/manual/en/book.pdo.php
*/

// all_users.php - Builds multidimensional array of users and displays

try {
    $pdo = new PDO("mysql:host=localhost;dbname=Registration", 'root', '');
    $stmt = $pdo->query("SELECT user_id, first_name, last_name FROM registered_users ORDER BY last_name");
    $all_users = []; // Multidimensional array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user_array = [
            'id' => $row['user_id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name']
        ];
        $all_users[] = $user_array; // Push inner array to outer
    }
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<h2>All Users</h2>
<table>
    <tr><th>ID</th><th>First Name</th><th>Last Name</th></tr>
    <?php foreach ($all_users as $user): ?>
    <tr>
        <td><?php echo htmlspecialchars($user['id']); ?></td>
        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
    </tr>
    <?php endforeach; ?>
</table>

