(function()
{
	var previousTab = <?php echo isset( $CurrentOpenFile ) ? '$( \'#file-' . $CurrentOpenFile . '\' )' : 'false'; ?>;
	
	$( '.function' ).popover(
	{
		container: 'body',
		placement: 'right',
		trigger: 'hover'
		
	} );
	
	$( document )
		.pjax( 'a', '#pjax-container' )
		.on( 'pjax:start', function() { NProgress.start(); } )
		.on( 'pjax:end',   function() { NProgress.done();  } );
	
	$( '.file > a' ).on( 'click', function()
	{
		var nav = $( '#file-' + $( this ).text() );
		
		if( previousTab !== nav )
		{
			previousTab.hide( );
			
			previousTab = nav;
		}
		
		if( nav.is( ':hidden' ) )
		{
			nav.show();
		}
		else
		{
			nav.hide();
		}
	} );
}());
