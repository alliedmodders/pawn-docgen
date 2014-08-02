<?php
	foreach( $Includes as $File )
	{
		echo '<h4 class="file"><a href="' . $BaseURL . $File . '">' . $File . '</a></h4>';
		echo '<ul class="nav nav-sidebar ' . ( $CurrentOpenFile === $File ? ' show' : '' ) . '" id="file-' . $File . '">';
		
		if( isset( $Functions[ $File ] ) )
		{
			foreach( $Functions[ $File ] as $Function )
			{
				$Function[ 'Function' ] = htmlspecialchars( $Function[ 'Function' ] );
				
				echo '<li class="function" data-title="' . $Function[ 'Function' ] . '" data-content="' . htmlspecialchars( $Function[ 'Comment' ] ) . '">';
				echo '<a href="' . $BaseURL . $File . '/' . $Function[ 'Function' ] . '">' . $Function[ 'Function' ] . '</a>';
				echo '</li>';
			}
		}
		
		echo '</ul>';
	}
