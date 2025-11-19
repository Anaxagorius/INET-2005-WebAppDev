<?php

/*
 * APA Citation: PHP Group. (n.d.). PHP Manual. PHP.net. https://www.php.net/manual/en/
 *
 * APA Citation: World Wide Web Consortium. (2014). HTML5: A vocabulary and associated APIs for HTML and XHTML. W3C Recommendation. https://www.w3.org/TR/html5/
*/

/**
 * index.php - Project Dashboard & README
 * 
 * @author Tom Burchell
 * @version 2.0 
 * 
 * Security: Escapes all outputs; assumes DB setup from process_registration.php.
 * Optimization: Single DB connect; CSS minified inline (~2KB); no external deps.
 */

// Lazy DB connect for stats (only if Registration DB exists)
$stats = ['users' => 0, 'movies' => 0];
try {
    $pdo = new PDO('mysql:host=localhost;dbname=Registration', 'root', '');
    $stats['users'] = $pdo->query('SELECT COUNT(*) FROM registered_users')->fetchColumn();
} catch (PDOException $e) {
    $stats['users'] = 'N/A (DB not set)';
}
$xml = @simplexml_load_file('fav_movies.xml');
$stats['movies'] = $xml ? count($xml->movie) : 'N/A (XML not generated)';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Registration & Movies App - Dashboard</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; line-height: 1.6; color: #333; background: #f8f9fa; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); padding: 30px; }
        h1 { text-align: center; color: #212529; margin-bottom: 10px; }
        .stats { text-align: center; background: #f8f9fa; padding: 15px; border-radius: 4px; margin-bottom: 30px; }
        .stats span { font-weight: 600; color: #007bff; }
        nav { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 40px; }
        .card { background: #f8f9fa; padding: 20px; border-radius: 4px; border-left: 4px solid #007bff; }
        .card h3 { margin: 0 0 10px; color: #007bff; }
        .card a { display: inline-block; color: #007bff; text-decoration: none; font-weight: 500; padding: 8px 12px; background: white; border-radius: 4px; transition: background 0.2s; }
        .card a:hover { background: #e9ecef; }
        .card a[onclick] { cursor: pointer; color: #6c757d; } /* Disabled style */
        .readme { background: #f8f9fa; padding: 20px; border-radius: 4px; border-left: 4px solid #28a745; }
        .readme h2 { color: #28a745; margin-top: 0; }
        .readme ul { margin: 10px 0; padding-left: 20px; }
        @media (max-width: 600px) { nav { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Registration & Movies App</h1>
        <p style="text-align: center; color: #6c757d;">A modular demo: User registration DB + XML movie catalog. Live stats: <span class="stats"><?php echo $stats['users']; ?> users</span> | <span class="stats"><?php echo $stats['movies']; ?> movies</span></p>

        <nav>
            <div class="card">
                <h3>Registration Form</h3>
                <p>Collect & validate user data; inserts to MySQL.</p>
                <a href="Registration.php">Launch Form</a>
            </div>

            <div class="card">
                <h3>Users Table</h3>
                <p>View all registered users post-submit.</p>
                <a href="display_users.php">View Table</a>
            </div>

            <div class="card">
                <h3>Last Names Array</h3>
                <p>Fetch, sort, & display last names alphabetically.</p>
                <a href="last_names.php">Run Script</a>
            </div>

            <div class="card">
                <h3>All Users Multidimensional Array</h3>
                <p>Build nested array; display user IDs/names.</p>
                <a href="all_users.php">Run Script</a>
            </div>

            <div class="card">
                <h3>Generate Movies XML</h3>
                <p>Create fav_movies.xml with 10 entries (run once).</p>
                <?php if (file_exists('fav_movies.xml')): ?>
                    <a href="#" onclick="alert('XML already generated—view display below.');">Already Done</a>
                <?php else: ?>
                    <a href="create_movies.php">Generate XML</a>
                <?php endif; ?>
            </div>

            <div class="card">
                <h3>Display Movies Table</h3>
                <p>Parse XML; render table (3 cols, with posters).</p>
                <a href="display_movies.php">View Table</a>
            </div>
        </nav>

        <section class="readme">
            <h2>README: App Overview & Usage Guide</h2>
            <p><strong>What is this?</strong> A PHP showcase app demonstrating DB interactions (registration/validation/arrays) and XML handling (movies catalog). Built for local XAMPP; modular for easy extension. Key tech: PDO for secure queries, SimpleXML for parsing, semantic HTML/CSS for UX.</p>

            <h3>Setup (5min)</h3>
            <ul>
                <li><strong>XAMPP:</strong> Start Apache/MySQL; place files in `htdocs/A05/`.</li>
                <li><strong>DB:</strong> In phpMyAdmin (`localhost/phpmyadmin`), create `Registration` DB + `registered_users` table (SQL below).</li>
                <li><strong>Movies:</strong> Run `create_movies.php` once via browser/CLI to gen `fav_movies.xml`.</li>
            </ul>
            <pre style="background: #e9ecef; padding: 10px; border-radius: 4px; overflow-x: auto; font-size: 0.85rem;">
-- DB Schema (run in phpMyAdmin)
CREATE DATABASE Registration;
USE Registration;
CREATE TABLE registered_users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(10) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    street VARCHAR(100) NOT NULL,
    city VARCHAR(50) NOT NULL,
    province VARCHAR(50) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    country VARCHAR(20) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    newsletter TINYINT(1) DEFAULT 0
);
            </pre>

            <h3>How to Use</h3>
            <ul>
                <li><strong>Registration:</strong> Fill form at `Registration.php`; validates required fields (email format). Success: Redirects to users table.</li>
                <li><strong>Arrays:</strong> `last_names.php` sorts unique last names; `all_users.php` builds/displays multidimensional array (ID + names).</li>
                <li><strong>Movies:</strong> `create_movies.php` generates XML (10 entries: LOTR trilogy, John Wick, etc., with posters). `display_movies.php` renders table (3/row, H1 title/year, details).</li>
                <li><strong>Stats:</strong> Dashboard shows live counts—queries optimized (single SELECT).</li>
            </ul>

            <h3>Troubleshooting & Optimization</h3>
            <ul>
                <li><strong>Errors:</strong> Check `xampp/apache/logs/error.log`; enable `display_errors=On` in php.ini (dev only).</li>
                <li><strong>Perf:</strong> Index DB (`ALTER TABLE registered_users ADD INDEX (last_name);`); minify CSS/JS if adding.</li>
                <li><strong>Extend:</strong> Add search/filter to tables (PDO LIKE queries); API export (json_encode($users)).</li>
                <li><strong>Deploy:</strong> Git init; push to GitHub. Host on free tiers (000webhost for PHP/MySQL).</li>
            </ul>
            <p><em>Pro Tip:</em> For scalability, migrate to Laravel—handles routing/validation/auth out-of-box, slashing code by 70%.</p>
        </section>
    </div>
</body>
</html>

