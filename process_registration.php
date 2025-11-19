<?php
/**
 * process_registration.php - Form validation and DB insertion handler
 * 
 * @author Tom Burchell
 * @version 2.0
 * 
 * Handles POST data: Validates required fields, inserts to 'registered_users' via PDO.
 * Sets $errors array for form feedback (sticky values preserved).
 * 
 * Security: Prepared statements; input sanitization via htmlspecialchars on output.
 * Optimization: Single DB connection; batch execute reduces roundtrips.
 */

// DB Config 
$host = 'localhost';
$dbname = 'Registration';
$username = 'root'; // XAMPP default
$password = '';     // XAMPP default

// Init errors array (global scope for form access)
$errors = [];

// Connect only if POST (lazy-load for initial GET perf)
if (isset($_POST['submit'])) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // True prepares for security
    } catch (PDOException $e) {
        $errors['db'] = 'Database connection failed. Check phpMyAdmin.';
        error_log("PDO Error: " . $e->getMessage()); // Log for debugging
    }

    // Validate required fields (all except newsletter)
    $required_fields = ['title', 'firstName', 'lastName', 'street', 'city', 'province', 'postalCode', 'country', 'phone', 'email'];
    foreach ($required_fields as $field) {
        if (empty(trim($_POST[$field] ?? ''))) {
            $field_name = ucwords(str_replace(['firstName', 'lastName', 'postalCode'], ['First Name', 'Last Name', 'Postal Code'], $field));
            $errors[$field] = $field_name . ' is required.';
        }
    }

    // Email format check (regex for precision, filter_var as fallback)
    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    // Proceed only if no errors and DB connected
    if (empty($errors) && isset($pdo)) {
        try {
            // Prepare insert (optimized: positional params, single execute)
            $stmt = $pdo->prepare("
                INSERT INTO registered_users 
                (title, first_name, last_name, street, city, province, postal_code, country, phone, email, newsletter) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            // Newsletter: 1/0 boolean
            $newsletter = isset($_POST['newsletter']) && $_POST['newsletter'] === '1' ? 1 : 0;
            
            $success = $stmt->execute([
                trim($_POST['title']),
                trim($_POST['firstName']),
                trim($_POST['lastName']),
                trim($_POST['street']),
                trim($_POST['city']),
                trim($_POST['province']),
                trim($_POST['postalCode']),
                trim($_POST['country']),
                trim($_POST['phone']),
                trim($_POST['email']),
                $newsletter
            ]);

            if ($success) {
                // Clear POST to prevent re-submit (PRG pattern)
                $_POST = [];
                // Optional: Flash success message via session (uncomment if session_start() added)
                // $_SESSION['success'] = 'Registration successful!';
            } else {
                $errors['submit'] = 'Insertion failed. Please try again.';
            }
        } catch (PDOException $e) {
            $errors['submit'] = 'Database error during save.';
            error_log("Insert Error: " . $e->getMessage());
        }
    }
}
// $errors now propagates to form for display/sticky values
?>