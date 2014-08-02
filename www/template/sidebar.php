<?php
	foreach( $Includes as $File )
	{
		echo '<h4 class="file"><a href="' . $BaseURL . $File . '">' . $File . '</a></h4><ul class="nav nav-sidebar" id="file-' . $File . '"' . ( $CurrentOpenFile === $File ? ' style="display:block"' : '' ) . '>';
		
		if( isset( $Functions[ $File ] ) )
		{
			foreach( $Functions[ $File ] as $Function )
			{
				echo '<li class="function" data-title="' . $Function[ 'Function' ] . '" data-content="' . $Function[ 'Comment' ] . '">';
				echo '<a href="' . $BaseURL . $File . '/' . $Function[ 'Function' ] . '">' . $Function[ 'Function' ] . '</a>';
				echo '</li>';
			}
		}
		
		echo '</ul>';
	}
