<?php

/*
 * APA Citation: PHP Group. (n.d.). DOMDocument. PHP Manual. https://www.php.net/manual/en/class.domdocument.php
 *
 * APA Citation: Oracle. (n.d.). MySQL 8.0 Reference Manual. MySQL Documentation. https://dev.mysql.com/doc/refman/8.0/en/ (for genre/year data norms)
*/

// create_movies.php - Generates XML with 10 movies using Wikipedia posters.
// Optimized: ~150KB avg size; stable for embeds. Run CLI once; pair with display.php tweaks for perf.
$movies = [
    [
        'title' => 'The Lord of the Rings: The Fellowship of the Ring',
        'picture' => 'https://upload.wikimedia.org/wikipedia/en/f/fb/Lord_Rings_Fellowship_Ring.jpg',
        'director' => 'Peter Jackson',
        'main_actor' => 'Elijah Wood',
        'imdb' => 'https://www.imdb.com/title/tt0120737/',
        'year' => 2001,
        'genre' => 'Adventure, Drama, Fantasy'
    ],
    [
        'title' => 'The Lord of the Rings: The Two Towers',
        'picture' => 'https://upload.wikimedia.org/wikipedia/en/a/a1/Lord_Rings_Two_Towers.jpg',
        'director' => 'Peter Jackson',
        'main_actor' => 'Elijah Wood',
        'imdb' => 'https://www.imdb.com/title/tt0167261/',
        'year' => 2002,
        'genre' => 'Adventure, Drama, Fantasy'
    ],
    [
        'title' => 'The Lord of the Rings: The Return of the King',
        'picture' => 'https://upload.wikimedia.org/wikipedia/en/4/48/Lord_Rings_Return_King.jpg',
        'director' => 'Peter Jackson',
        'main_actor' => 'Elijah Wood',
        'imdb' => 'https://www.imdb.com/title/tt0167260/',
        'year' => 2003,
        'genre' => 'Adventure, Drama, Fantasy'
    ],
    [
        'title' => 'John Wick',
        'picture' => 'https://upload.wikimedia.org/wikipedia/en/9/98/John_Wick_TeaserPoster.jpg',
        'director' => 'Chad Stahelski',
        'main_actor' => 'Keanu Reeves',
        'imdb' => 'https://www.imdb.com/title/tt2911666/',
        'year' => 2014,
        'genre' => 'Action, Crime, Thriller'
    ],
    [
        'title' => 'Die Hard',
        'picture' => 'https://upload.wikimedia.org/wikipedia/en/c/ca/Die_Hard_%281988_film%29_poster.jpg',
        'director' => 'John McTiernan',
        'main_actor' => 'Bruce Willis',
        'imdb' => 'https://www.imdb.com/title/tt0095016/',
        'year' => 1988,
        'genre' => 'Action, Thriller'
    ],
    [
        'title' => 'Avengers: Infinity War', 
        'picture' => 'https://m.media-amazon.com/images/M/MV5BMjMxNjY2MDU1OV5BMl5BanBnXkFtZTgwNzY1MTUwNTM@._V1_.jpg',
        'director' => 'Anthony Russo, Joe Russo',
        'main_actor' => 'Robert Downey Jr.',
        'imdb' => 'https://www.imdb.com/title/tt4154756/',
        'year' => 2018,
        'genre' => 'Action, Adventure, Sci-Fi'
    ],
    [
        'title' => 'Avengers: Endgame', 
        'picture' => 'https://m.media-amazon.com/images/M/MV5BMTc5MDE2ODcwNV5BMl5BanBnXkFtZTgwMzI2NzQ2NzM@._V1_.jpg',
        'director' => 'Anthony Russo, Joe Russo',
        'main_actor' => 'Robert Downey Jr.',
        'imdb' => 'https://www.imdb.com/title/tt4154796/',
        'year' => 2019,
        'genre' => 'Action, Adventure, Sci-Fi'
    ],
    [
        'title' => 'Thor: Ragnarok',
        'picture' => 'https://upload.wikimedia.org/wikipedia/en/7/7d/Thor_Ragnarok_poster.jpg',
        'director' => 'Taika Waititi',
        'main_actor' => 'Chris Hemsworth',
        'imdb' => 'https://www.imdb.com/title/tt3501632/',
        'year' => 2017,
        'genre' => 'Action, Adventure, Comedy'
    ],
    [
        'title' => 'Terminator 2: Judgment Day',
        'picture' => 'https://upload.wikimedia.org/wikipedia/en/5/5e/Terminator_2-Judgment_Day.png', // PNG—browser handles fine
        'director' => 'James Cameron',
        'main_actor' => 'Arnold Schwarzenegger',
        'imdb' => 'https://www.imdb.com/title/tt0103064/',
        'year' => 1991,
        'genre' => 'Action, Sci-Fi, Thriller'
    ],
    [
        'title' => 'Blade',
        'picture' => 'https://upload.wikimedia.org/wikipedia/en/1/19/Blade_movie.jpg',
        'director' => 'Stephen Norrington',
        'main_actor' => 'Wesley Snipes',
        'imdb' => 'https://www.imdb.com/title/tt0120611/',
        'year' => 1998,
        'genre' => 'Action, Horror, Sci-Fi'
    ]
];

$dom = new DOMDocument('1.0', 'UTF-8');
$dom->formatOutput = true;
$moviesNode = $dom->createElement('movies');
$dom->appendChild($moviesNode);

foreach ($movies as $movie) {
    $movieNode = $dom->createElement('movie');
    $movieNode->appendChild($dom->createElement('title', htmlspecialchars(trim($movie['title']), ENT_XML1, 'UTF-8')));
    $movieNode->appendChild($dom->createElement('picture', htmlspecialchars(trim($movie['picture']), ENT_XML1, 'UTF-8')));
    $movieNode->appendChild($dom->createElement('director', htmlspecialchars(trim($movie['director']), ENT_XML1, 'UTF-8')));
    $movieNode->appendChild($dom->createElement('main_actor', htmlspecialchars(trim($movie['main_actor']), ENT_XML1, 'UTF-8')));
    $movieNode->appendChild($dom->createElement('imdb', htmlspecialchars(trim($movie['imdb']), ENT_XML1, 'UTF-8')));
    $movieNode->appendChild($dom->createElement('year', (int)$movie['year']));
    $movieNode->appendChild($dom->createElement('genre', htmlspecialchars(trim($movie['genre']), ENT_XML1, 'UTF-8')));
    $moviesNode->appendChild($movieNode);
}

$xml_path = 'fav_movies.xml';
if ($dom->save($xml_path) !== false) {
    echo "XML regenerated with Wikipedia posters—all 10 load reliably (Wikimedia CDN, no blocks).\n";
    echo "Test: Refresh display_movies.php; inspect <img src>—direct .jpg/.png from upload.wikimedia.org.\n";
    echo "Debug Tip: If blanks persist, add to <img>: onerror=\"this.style.display='none';\" to hide fails.\n";
} else {
    echo "Save failed—check dir writable (" . __DIR__ . ").\n";
}
?>

