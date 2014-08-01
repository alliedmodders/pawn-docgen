<?php
	echo '<pre>';
	
	set_time_limit( 300 );
	
	$IncludeGLOB = __DIR__ . '/include/*.inc';
	
	/**
	 * @section Parse files and construct arrays of functions and constants
	 */
	
	$IncludeList = glob( $IncludeGLOB );
	
	$BigListOfFunctions = Array();
	$BigListOfConstants = Array();
	
	foreach( $IncludeList as $FileName )
	{
		$File = file_get_contents( $FileName );
		
		$FileName = basename( $FileName );
		
		if( empty( $File ) )
		{
			continue;
		}
		
		// Normalize line endings
		$File = str_replace( "\r\n", "\n", $File );
		$File = str_replace( "\r", "\n", $File );
		
		$File = explode( "\n", $File );
		
		$Lines = Count( $File );
		$Count = 0;
		
		$OpenComment = false;
		$FunctionUntilNextCommentBlock = false;
		$CommentBlock = Array();
		$FunctionBuffer = Array();
		
		$Functions = Array();
		$Constants = Array();
		
		foreach( $File as $Line )
		{
			++$Count;
			
			/*if( trim( $Line ) === '' && $Count < $Lines )
			{
				continue;
			}*/
			
			$Beginning = substr( $Line, 0, 2 );
			
			if( $Beginning === '//' )
			{
				//throw new Exception( 'Invalid comment type: ' . $Line );
			}
			
			$IsCommentOpening = $Beginning === '/*';
			
			if( $FunctionUntilNextCommentBlock )
			{
				$IsFunction = preg_match( '/^(stock|functag|native|forward)/', $Line ) === 1 && strpos( $Line, ' const ' ) === false;
				
				if( $IsFunction || $IsCommentOpening || $Count === $Lines )
				{
					$Comment = implode( "\n", $CommentBlock );
					$Comment = ParseCommentBlock( $Comment );
					$Comment = SplitCommentBlock( $Comment );
					
					$Function = Array(
						'Comment' => $Comment[ 0 ],
						'CommentTags' => ParseTags( $Comment[ 1 ] )
					);
					
					if( $IsFunction )
					{
						$FunctionBuffer[ ] = $Line;
						
						$Function[ 'FunctionName' ] = GetFunctionName( $Line );
						$Function[ 'Function' ] = implode( "\n", $FunctionBuffer );
						
						$Functions[ ] = $Function;
					}
					else
					{
						$Function[ 'Constant' ] = trim( implode( "\n", $FunctionBuffer ) );
						
						$Constants[ ] = $Function;
					}
					
					$CommentBlock = Array();
					$FunctionBuffer = Array();
					
					$FunctionUntilNextCommentBlock = false;
				}
				else
				{
					$FunctionBuffer[ ] = $Line;
				}
			}
			
			if( $IsCommentOpening )
			{
				if( $OpenComment )
				{
					throw new Exception( 'Found a comment opening while having a comment open already: ' . $Line );
				}
				
				$OpenComment = true;
			}
			
			if( $OpenComment )
			{
				$CommentBlock[ ] = $Line;
				
				if( substr( rtrim( $Line ), -2 ) === '*/' )
				{
					$OpenComment = false;
					$FunctionUntilNextCommentBlock = true;
				}
			}
		}
		
		// If first comment contains 'All rights reserved.', it's probably copyright nonsense
		if( !empty( $Constants ) && strpos( $Constants[ 0 ][ 'Comment' ], 'All rights reserved.' ) !== false )
		{
			if( preg_match( '/#define (?!_)/', $Constants[ 0 ][ 'Constant' ] ) === 1 )
			{
				$Constants[ 0 ][ 'Comment' ] = 'Unclassified';
			}
			else
			{
				array_shift( $Constants );
			}
		}
		
		$BigListOfFunctions[ $FileName ] = $Functions;
		$BigListOfConstants[ $FileName ] = $Constants;
	}
	
	unset( $Functions, $Constants, $Line, $File, $IncludeList, $CommentBlock, $FunctionBuffer );
	
	/**
	 * @endsection
	 */
	
	/**
	 * @section Functions used for parsing comment blocks and stuff
	 *
	 * @note Some of the functions were shamelessly copied from https://github.com/phpDocumentor/ReflectionDocBlock/
	 */
	
	function ParseCommentBlock( $Comment )
	{
		$Comment = trim(
			preg_replace(
				'#[ \t]*(?:\/\*\*|\*\/|\*)?[ \t]{0,1}(.*)?#u',
				'$1',
				$Comment
			)
		);
		
		if( substr( $Comment, -2 ) === '*/' )
		{
			$Comment = trim(substr( $Comment, 0, -2 ) );
		}
		
		if( substr( $Comment, 0, 2 ) === '/*' )
		{
			$Comment = trim(substr( $Comment, 2 ) );
		}
		
		return $Comment;
	}
	
	function SplitCommentBlock( $Comment )
	{
		if( strpos( $Comment, '@' ) === 0 )
		{
			$matches = array( $Comment, '' );
		}
		else
		{
			// clears all extra horizontal whitespace from the line endings to prevent parsing issues
			$Comment = preg_replace( '/\h*$/Sum', '', $Comment );
			
			preg_match(
				'/
				\A (?:
				\s* # first seperator (actually newlines but it\'s all whitespace)
				(?! @\pL ) # disallow the rest, to make sure this one doesn\'t match,
				#if it doesn\'t exist
				(
				[^\n]+
				(?: \n+
				(?! [ \t]* @\pL ) # disallow second seperator (@param)
				[^\n]+
				)*
				)
				)?
				(\s+ [\s\S]*)? # everything that follows
				/ux',
				$Comment,
				$matches
			);
			
			array_shift( $matches );
			
			while( count( $matches ) < 2 )
			{
				$matches[] = '';
			}
		}
		
		return $matches;
	}
	
	function ParseTags( $tags )
	{
		$result = array();
		$tags = trim( $tags );
		
		if( $tags !== '' )
		{
			if( $tags[0] !== '@' )
			{
				throw new Exception( 'A tag block started with text instead of an actual tag, this makes the tag block invalid: ' . $tags );
			}
			
			foreach( explode("\n", $tags) as $tag_line )
			{
				if( isset( $tag_line[0] ) && $tag_line[0] === '@' )
				{
					$result[] = $tag_line;
				}
				else
				{
					$result[count($result) - 1] .= "\n" . $tag_line;
				}
			}
			
			foreach( $result as $key => $tag_line )
			{
				if( preg_match( '/^@([\w\-\_\\\\]+)(?:\s*([^\s].*)|$)?/us', trim( $tag_line ), $Matches ) !== 1 )
				{
					throw new Exception( 'Invalid tag_line detected: ' . $tag_line );
				}
				
				$result[ $key ] = ParseTag( $Matches );
			}
		}
		
		return $result;
	}
	
	function ParseTag( $Matches )
	{
		$Tag = $Matches[ 1 ];
		$Line = isset( $Matches[ 2 ] ) ? $Matches[ 2 ] : '';
		
		$Return = Array(
			'Tag' => $Tag
		);
		
		// https://github.com/phpDocumentor/ReflectionDocBlock/tree/master/src/phpDocumentor/Reflection/DocBlock/Tag
		switch( $Tag )
		{
			case 'param':
			{
				$Parts = preg_split( '/(\s+)/Su', $Line, 2 );
				
				if( isset( $Parts[ 0 ] ) )
				{
					$Return[ 'Variable' ] = $Parts[ 0 ];
				}
				
				if( isset( $Parts[ 1 ] ) )
				{
					$Return[ 'Description' ] = $Parts[ 1 ];
				}
				
				break;
			}
			case 'error':
			case 'deprecated':
			case 'note':
			case 'return':
			{
				$Return[ 'Description' ] = $Line;
				
				break;
			}
			case 'noreturn':
			{
				if( !empty( $Line ) )
				{
					throw new Exception( '@noreturn must not contain any text: ' . $Line );
				}
				
				break;
			}
			case 'extra':
			{
				$Return[ 'Tag' ] = 'param';
				$Return[ 'Variable' ] = '...';
				$Return[ 'Description' ] = $Line;
				
				break;
			}
			default:
			{
				throw new Exception( 'Unknown tag: ' . $Tag );
			}
		}
		
		return $Return;
	}
	
	function GetFunctionName( $Line2 )
	{
		$Line = substr( $Line2, 0, strpos( $Line2, '(' ) );
		
		$PositionStart = strrpos( $Line, ':' );
		
		if( $PositionStart === false )
		{
			$PositionStart = strrpos( $Line, ' ' );
			
			if( $PositionStart === false )
			{
				throw new Exception( 'WTF: ' . $Line2 );	
			}
		}
		
		return trim( substr( $Line, $PositionStart ) );
	}
	
	/**
	 * @endsection
	 */
	
