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
	$InSection = 0;
	
	foreach( $Results as $Result )
	{
		if( substr( $Result[ 'Comment' ], 0, 8 ) === '@section' )
		{
			$InSection++;
			
			echo '<div class="panel panel-info"><div class="panel-heading">' . htmlspecialchars( substr( $Result[ 'Comment' ], 9 ) ) . '</div><div class="panel-body">';
			
			continue;
		}
		else if( $InSection > 0 && $Result[ 'Comment' ] === '@endsection' )
		{
			$InSection--;
			
			echo '</div></div>';
			
			continue;
		}
		
		echo '<div class="panel panel-primary"><div class="panel-heading">' . htmlspecialchars( $Result[ 'Comment' ] ) . '</div>';
		
		$Tags = json_decode( $Result[ 'Tags' ], true );
		
		if( !Empty( $Tags ) )
		{
			echo '<div class="panel-body">';
			
			foreach( $Tags as $Tag )
			{
				echo '<h4 class="sub-header2">' . ucfirst( $Tag[ 'Tag' ] ) . '</h4>';
				echo '<pre class="description">' . htmlspecialchars( $Tag[ 'Description' ] ) . '</pre>';
			}
			
			echo '</div>';
		}
		
		if( !Empty( $Result[ 'Constant' ] ) )
		{
			echo '<div class="panel-footer"><pre class="description"><code data-language="c">' . htmlspecialchars( $Result[ 'Constant' ] ) . '</code></pre></div>';
		}
		
		echo '</div>';
	}
	
	while( --$InSection > 0 )
	{
		echo '</div></div>';
	}
?>

<?php
	require __DIR__ . '/footer.php';
?>
