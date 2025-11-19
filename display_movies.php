<?php

/*
 * APA Citation: PHP Group. (n.d.). SimpleXML. PHP Manual. https://www.php.net/manual/en/book.simplexml.php
 *
 * APA Citation: World Wide Web Consortium. (2014). HTML5: A vocabulary and associated APIs for HTML and XHTML. W3C Recommendation. https://www.w3.org/TR/html5/
*/

// display_movies.php - Parses XML and displays in table (3 per row)

if (file_exists('fav_movies.xml')) {
    $xml = simplexml_load_file('fav_movies.xml');
    if ($xml === false) {
        die('Error loading XML.');
    }
} else {
    die('XML file not found.');
}
?>

<table>
    <?php $col = 1; foreach ($xml->movie as $movie): ?>
        <?php if ($col % 3 == 1): ?><tr><?php endif; ?>
        <td style="width: 33%; vertical-align: top;">
<img src="<?php echo htmlspecialchars((string)$movie->picture); ?>" alt="<?php echo htmlspecialchars((string)$movie->title); ?>" width="150" height="225" loading="lazy" style="max-width: 100%; height: auto;">            <h1><?php echo htmlspecialchars((string)$movie->title . ' (' . $movie->year . ')'); ?></h1>
            <p>Director: <?php echo htmlspecialchars((string)$movie->director); ?></p>
            <p>Main Actor/Actress: <?php echo htmlspecialchars((string)$movie->main_actor); ?></p>
            <p>Genre: <?php echo htmlspecialchars((string)$movie->genre); ?></p>
            <a href="<?php echo htmlspecialchars((string)$movie->imdb); ?>">IMDB</a>
        </td>
        <?php if ($col % 3 == 0): ?></tr><?php endif; $col++; ?>
    <?php endforeach; ?>
    <?php if ($col % 3 != 1): ?></tr><?php endif; // Close incomplete row ?>
</table>

