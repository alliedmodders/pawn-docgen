<?php
header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');

require __DIR__ . '/header.php';

echo '<h1 class="page-header">Nothing found</h1>';

require __DIR__ . '/footer.php';
