(function()
{
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
		
		var visibleNav = $( '.nav-sidebar.show' );
		
		if( !visibleNav.is( nav ) )
		{
			visibleNav.removeClass( 'show' );
		}
		
		if( nav.hasClass( 'show' ) )
		{
			nav.removeClass( 'show' );
		}
		else
		{
			nav.addClass( 'show' );
		}
	} );
}());
