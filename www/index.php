<?php
	require __DIR__ . '/../settings.php';
	
	$RenderLayout = !isset( $_SERVER[ 'HTTP_X_PJAX' ] ) || $_SERVER[ 'HTTP_X_PJAX' ] !== 'true';
	
	if( $RenderLayout )
	{
		$CurrentOpenFile = false;
		$CurrentOpenFunction = false;
		
		$Includes = $Database->query( 'SELECT `ID`, `IncludeName` FROM `' . $Columns[ 'Files' ] . '` ORDER BY `IncludeName` ASC' )->fetchAll( PDO :: FETCH_KEY_PAIR );
		
		$Functions = Array();
		
		$STH = $Database->query( 'SELECT `Function`, `Type`, `Comment`, `IncludeName` FROM `' . $Columns[ 'Functions' ] . '` ORDER BY `Type` ASC, `Function` ASC' );
		
		while( $Function = $STH->fetch() )
		{
			$Functions[ $Function[ 'IncludeName' ] ][ ] = Array(
				'Function' => $Function[ 'Function' ],
				'Comment' => $Function[ 'Comment' ],
				'Type' => $Function[ 'Type' ],
			);
		}
	}
	
	$Path = isset( $_SERVER[ 'QUERY_STRING' ] ) ? trim( $_SERVER[ 'QUERY_STRING' ], '/' ) : '';
	
	if( $Path )
	{
		$Path = explode( '/', $Path );
		
		$Action = !empty( $Path[ 1 ] ) ? filter_var( $Path[ 1 ], FILTER_SANITIZE_STRING ) : false;
		
		if( isset( $Path[ 0 ] ) )
		{
			$IncludeName = filter_var( $Path[ 0 ], FILTER_SANITIZE_STRING );
			
			$HeaderTitle = $CurrentOpenFile = $IncludeName;
			
			if( $Action )
			{
				if( $Action === '__raw' )
				{
					$STH = $Database->prepare( 'SELECT `Content` FROM `' . $Columns[ 'Files' ] . '` WHERE `IncludeName` = :includeName' );
					$STH->bindValue( ':includeName', $IncludeName, PDO :: PARAM_STR );
					$STH->execute();
					
					$PageFile = $STH->fetch();
					
					if( Empty( $PageFile ) )
					{
						require __DIR__ . '/template/404.php';
						
						exit;
					}
					
					require __DIR__ . '/template/raw.php';
				}
				else if( $Action === '__functions' )
				{
					$STH = $Database->prepare( 'SELECT `Function`, `Comment` FROM `' . $Columns[ 'Functions' ] . '` WHERE `IncludeName` = :includeName' );
					$STH->bindValue( ':includeName', $IncludeName, PDO :: PARAM_STR );
					$STH->execute();
					
					$PageFunctions = $STH->fetchAll();
					
					if( Empty( $PageFunctions ) )
					{
						header( 'Location: ' . $BaseURL . $IncludeName . '/__raw' ); // There are no functions, but maybe file exists?
						//require __DIR__ . '/template/404.php';
						
						exit;
					}
					
					$HeaderTitle = 'Functions · ' . $HeaderTitle;
					
					require __DIR__ . '/template/functions.php';
				}
				else
				{
					$STH = $Database->prepare( 'SELECT `Function`, `FullFunction`, `Comment`, `Tags`, `IncludeName` FROM `' . $Columns[ 'Functions' ] . '` WHERE `Function` = :functionName AND `IncludeName` = :includeName' );
					$STH->bindValue( ':includeName', $IncludeName, PDO :: PARAM_STR );
					$STH->bindValue( ':functionName', $Action, PDO :: PARAM_STR );
					$STH->execute();
					
					$PageFunction = $STH->fetch();
					
					if( Empty( $PageFunction ) )
					{
						require __DIR__ . '/template/404.php';
						
						exit;
					}
					
					$CurrentOpenFunction = $PageFunction[ 'Function' ];
					
					$HeaderTitle = $PageFunction[ 'Function' ] . ' · ' . $HeaderTitle;
					
					require __DIR__ . '/template/function.php';
				}
			}
			else
			{
				$STH = $Database->prepare( 'SELECT `Constant`, `Comment`, `Tags` FROM `' . $Columns[ 'Constants' ] . '` WHERE `IncludeName` = :includeName' );
				$STH->bindValue( ':includeName', $IncludeName, PDO :: PARAM_STR );
				$STH->execute();
				
				$Results = $STH->fetchAll();
				
				if( Empty( $Results ) )
				{
					header( 'Location: ' . $BaseURL . $IncludeName . '/__functions' ); // There are no constants, but maybe there are functions?
					//require __DIR__ . '/template/404.php';
					
					exit;
				}
				
				$PageName = $IncludeName;
				
				$HeaderTitle = 'Constants · ' . $HeaderTitle;
				
				require __DIR__ . '/template/constants.php';
			}
		}
		else
		{
			require __DIR__ . '/template/404.php';
		}
		
		exit;
	}
	
	require __DIR__ . '/template/main.php';
