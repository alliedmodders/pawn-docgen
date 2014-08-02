<?php
	require __DIR__ . '/header.php';
?>

<ol class="breadcrumb">
	<li><a href="<?php echo $BaseURL . $CurrentOpenFile; ?>"><?php echo $CurrentOpenFile; ?>.inc</a></li>
	<li class="active">Constants</li>
	
	<li class="pull-right"><a href="<?php echo $BaseURL . $CurrentOpenFile; ?>/__raw">File</a></li>
	<li class="pull-right"><a href="<?php echo $BaseURL . $CurrentOpenFile; ?>/__functions">Functions</a></li>
</ol>

<h1 class="page-header">List of constants in <?php echo htmlspecialchars( $PageName ); ?>.inc</h1>

<?php
 	$Count = 0;
 	
	echo '<ul>';
	
	foreach( $Results as $Result )
	{
		echo '<li><a href="#constant-' . ++$Count . '">' . htmlspecialchars( $Result[ 'Comment' ] ) . '</a></li>';
	}
	
	echo '</ul>';
	
	$Count = 0;
	
	foreach( $Results as $Result )
	{
		echo '<h2 class="sub-header" id="constant-' . ++$Count . '">' . htmlspecialchars( $Result[ 'Comment' ] ) . '</h2>';
		echo '<pre>' . htmlspecialchars( $Result[ 'Constant' ] ) . '</pre>';
	}
?>

<?php
	require __DIR__ . '/footer.php';
?>
