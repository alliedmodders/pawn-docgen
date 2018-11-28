<?php
require __DIR__ . '/header.php';
?>

<ol class="breadcrumb">
    <li><a href="<?= $BaseURL . $CurrentOpenFile; ?>"><?= $CurrentOpenFile; ?>.inc</a></li>
    <li class="active">Raw</li>

    <li class="pull-right"><a href="<?= $BaseURL . $CurrentOpenFile; ?>/__functions">Functions</a></li>
    <li class="pull-right"><a href="<?= $BaseURL . $CurrentOpenFile; ?>">Constants</a></li>
</ol>

<h1 class="page-header"><?= htmlspecialchars($CurrentOpenFile); ?>.inc</h1>

<pre><?= htmlspecialchars($PageFile['Content']); ?></pre>

<?php
require __DIR__ . '/footer.php';
?>
