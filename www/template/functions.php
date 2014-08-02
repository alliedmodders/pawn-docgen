<?php
	require __DIR__ . '/header.php';
?>

<ol class="breadcrumb">
	<li><a href="<?php echo $BaseURL . $CurrentOpenFile; ?>"><?php echo $CurrentOpenFile; ?>.inc</a></li>
	<li class="active">Functions</li>
	
	<li class="pull-right"><a href="<?php echo $BaseURL . $CurrentOpenFile; ?>/__raw">File</a></li>
	<li class="pull-right"><a href="<?php echo $BaseURL . $CurrentOpenFile; ?>">Constants</a></li>
</ol>

<h1 class="page-header">List of functions in <?php echo htmlspecialchars( $CurrentOpenFile ); ?>.inc</h1>

<div class="table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
			<th>Function</th>
			<th>Description</th>
		</thead>
		<?php
			foreach( $PageFunctions as $Function )
			{
				echo '<tr><td><a href="' . $BaseURL . $CurrentOpenFile . '/' . $Function[ 'Function' ] . '">' . $Function[ 'Function' ] . '</a></td><td><pre class="description">' . htmlspecialchars( $Function[ 'Comment' ] ) . '</pre></td></tr>';
			}
		?>
	</table>
</div>

<?php
	require __DIR__ . '/footer.php';
?>
