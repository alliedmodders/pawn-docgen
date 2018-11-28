<?php
require __DIR__ . '/header.php';
?>

<h1 class="page-header">Welcome to the <?= $Project; ?> Scripting API Reference</h1>

<p>For more information, see the <a
            href="http://wiki.alliedmods.net/Category:<?= str_replace(' ', '_', $Project); ?>_Scripting"><?= $Project; ?>
        Scripting Wiki</a>, which contains tutorials on specific topics.</p>
<hr>
<p>Enter a search term on the left to look for symbols in the <?= $Project; ?> include files.</p>
<p>Alternately, click a file on the left to browse its functions/symbols or see its contents.</p>

<?php
require __DIR__ . '/footer.php';
?>
