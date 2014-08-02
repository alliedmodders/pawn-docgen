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
	foreach( $Results as $Result )
	{
		if( $Result[ 'Comment' ] === '@endsection' )
		{
			echo '<div class="clearfix" style="height:100px"></div>';
			continue;
		}
		
		$Tags = json_decode( $Result[ 'Tags' ], true );
		
		if( Empty( $Result[ 'Constant' ] ) )
		{
			echo '<h2 class="sub-header">' . htmlspecialchars( $Result[ 'Comment' ] ) . '</h2>';
		}
		else
		{
			echo '<pre class="description" style="font-weight:bold">' . htmlspecialchars( $Result[ 'Comment' ] ) . '</pre>';
		}
		
		if( !Empty( $Tags ) )
		{
			foreach( $Tags as $Tag )
			{
				echo '<h4 class="sub-header2">' . ucfirst( $Tag[ 'Tag' ] ) . '</h4>';
				echo '<pre class="description">' . htmlspecialchars( $Tag[ 'Description' ] ) . '</pre>';
			}
		}
		
		if( !Empty( $Result[ 'Constant' ] ) )
		{
			echo '<pre>' . htmlspecialchars( $Result[ 'Constant' ] ) . '</pre><hr>';
		}
	}
?>

<?php
	require __DIR__ . '/footer.php';
?>
