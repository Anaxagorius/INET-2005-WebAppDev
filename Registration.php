<?php

// APA Citation: World Wide Web Consortium. (2014). HTML5: A vocabulary and associated APIs for HTML and XHTML. W3C Recommendation. https://www.w3.org/TR/html5/

// APA Citation: PHP Group. (n.d.). PDO. PHP Manual. https://www.php.net/manual/en/book.pdo.php

// Registration.php - Optimized form handler with embedded processing
// Security: All outputs escaped; prepared statements in process_registration.php.
$errors = []; // Global for form display
if (isset($_POST['submit'])) {
    include 'process_registration.php'; // Handles validation/insert
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        /* Reset & Base - Clean slate for consistency */
        * { box-sizing: border-box; }
        body { 
            font-family: system-ui, -apple-system, sans-serif; /* Native fonts for speed */
            line-height: 1.6; 
            color: #333; 
            background: #f8f9fa; 
            padding: 20px; 
            margin: 0; 
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: white; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.05); /* Minimal elevation */
        }

        /* Typography & Header */
        h2 { 
            text-align: center; 
            margin-bottom: 30px; 
            font-size: 1.5rem; 
            color: #212529; 
        }

        /* Form Layout - Simple flex for labels/fields */
        form { display: flex; flex-direction: column; gap: 20px; }
        .field { display: flex; flex-direction: column; gap: 5px; }
        @media (min-width: 768px) { 
            .field-row { display: grid; grid-template-columns: auto 1fr; align-items: start; gap: 10px; }
            .field-row label { text-align: right; padding-top: 12px; }
        }
        label { 
            font-weight: 600; 
            font-size: 0.9rem; 
            color: #495057; 
        }
        input, select { 
            padding: 10px; 
            border: 1px solid #ced4da; 
            border-radius: 4px; 
            font-size: 1rem; 
        }
        input:focus, select:focus { 
            outline: none; 
            border-color: #007bff; 
            box-shadow: 0 0 0 2px rgba(0,123,255,0.25); 
        }
        input[type="checkbox"] { width: auto; margin-right: 8px; }
        .newsletter { display: flex; align-items: center; gap: 8px; }

        /* Button - Clean call-to-action */
        button[type="submit"] { 
            background: #007bff; 
            color: white; 
            border: none; 
            padding: 12px; 
            border-radius: 4px; 
            font-size: 1rem; 
            cursor: pointer; 
            transition: background 0.2s; 
        }
        button[type="submit"]:hover { background: #0056b3; }

        /* Errors - Clear and concise */
        .error { 
            color: #dc3545; 
            font-size: 0.85rem; 
            margin-top: 4px; 
        }

        /* Table - Readable with stripes */
        .users-section { margin-top: 40px; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            padding: 12px; 
            text-align: left; 
            border-bottom: 1px solid #dee2e6; 
        }
        th { background: #f8f9fa; font-weight: 600; }
        tr:hover { background: #f8f9fa; }
        @media (max-width: 768px) { 
            table { font-size: 0.9rem; }
            th, td { padding: 8px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration Form</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="field field-row">
                <label for="title">Title:</label>
                <select id="title" name="title" required>
                    <option value="">Select...</option>
                    <option value="Mr" <?php echo (isset($_POST['title']) && $_POST['title'] == 'Mr') ? 'selected' : ''; ?>>Mr</option>
                    <option value="Mrs" <?php echo (isset($_POST['title']) && $_POST['title'] == 'Mrs') ? 'selected' : ''; ?>>Mrs</option>
                    <option value="Ms" <?php echo (isset($_POST['title']) && $_POST['title'] == 'Ms') ? 'selected' : ''; ?>>Ms</option>
                    <option value="Dr" <?php echo (isset($_POST['title']) && $_POST['title'] == 'Dr') ? 'selected' : ''; ?>>Dr</option>
                </select>
                <?php if (isset($errors['title'])): ?><div class="error"><?php echo $errors['title']; ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>" required>
                <?php if (isset($errors['firstName'])): ?><div class="error"><?php echo $errors['firstName']; ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>" required>
                <?php if (isset($errors['lastName'])): ?><div class="error"><?php echo $errors['lastName']; ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label for="street">Street:</label>
                <input type="text" id="street" name="street" value="<?php echo isset($_POST['street']) ? htmlspecialchars($_POST['street']) : ''; ?>" required>
                <?php if (isset($errors['street'])): ?><div class="error"><?php echo $errors['street']; ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>" required>
                <?php if (isset($errors['city'])): ?><div class="error"><?php echo $errors['city']; ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label for="province">Province:</label>
                <input type="text" id="province" name="province" value="<?php echo isset($_POST['province']) ? htmlspecialchars($_POST['province']) : ''; ?>" required>
                <?php if (isset($errors['province'])): ?><div class="error"><?php echo $errors['province']; ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label for="postalCode">Postal Code:</label>
                <input type="text" id="postalCode" name="postalCode" value="<?php echo isset($_POST['postalCode']) ? htmlspecialchars($_POST['postalCode']) : ''; ?>" required>
                <?php if (isset($errors['postalCode'])): ?><div class="error"><?php echo $errors['postalCode']; ?></div><?php endif; ?>
            </div>

            <div class="field field-row">
                <label for="country">Country:</label>
                <select id="country" name="country" required>
                    <option value="">Select...</option>
                    <option value="Canada" <?php echo (isset($_POST['country']) && $_POST['country'] == 'Canada') ? 'selected' : ''; ?>>Canada</option>
                    <option value="USA" <?php echo (isset($_POST['country']) && $_POST['country'] == 'USA') ? 'selected' : ''; ?>>USA</option>
                </select>
                <?php if (isset($errors['country'])): ?><div class="error"><?php echo $errors['country']; ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                <?php if (isset($errors['phone'])): ?><div class="error"><?php echo $errors['phone']; ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                <?php if (isset($errors['email'])): ?><div class="error"><?php echo $errors['email']; ?></div><?php endif; ?>
            </div>

            <div class="field newsletter">
                <input type="checkbox" id="newsletter" name="newsletter" value="1" <?php echo (isset($_POST['newsletter']) && $_POST['newsletter'] == '1') ? 'checked' : ''; ?>>
                <label for="newsletter">Subscribe to Newsletter</label>
            </div>

            <button type="submit" name="submit">Submit</button>
        </form>

        <?php
        // Display table only post-submit and if no errors (success state)
        if (isset($_POST['submit']) && (!isset($errors) || empty($errors))) {
            echo '<div class="users-section">';
            include 'display_users.php';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
</php>