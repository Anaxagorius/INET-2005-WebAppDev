<?php

/*
 * APA Citation: PHP Group. (n.d.). PDO. PHP Manual. https://www.php.net/manual/en/book.pdo.php
 *
 * APA Citation: World Wide Web Consortium. (2014). HTML5: A vocabulary and associated APIs for HTML and XHTML. W3C Recommendation. https://www.w3.org/TR/html5/
*/

// display_users.php - Retrieves and displays all users in a table

try {
    $pdo = new PDO("mysql:host=localhost;dbname=Registration", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM registered_users ORDER BY user_id DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>Title</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Street</th>
            <th>City</th>
            <th>Province</th>
            <th>Postal Code</th>
            <th>Country</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Newsletter</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
            <td><?php echo htmlspecialchars($user['title']); ?></td>
            <td><?php echo htmlspecialchars($user['first_name']); ?></td>
            <td><?php echo htmlspecialchars($user['last_name']); ?></td>
            <td><?php echo htmlspecialchars($user['street']); ?></td>
            <td><?php echo htmlspecialchars($user['city']); ?></td>
            <td><?php echo htmlspecialchars($user['province']); ?></td>
            <td><?php echo htmlspecialchars($user['postal_code']); ?></td>
            <td><?php echo htmlspecialchars($user['country']); ?></td>
            <td><?php echo htmlspecialchars($user['phone']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo $user['newsletter'] ? 'Yes' : 'No'; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>

</table>

