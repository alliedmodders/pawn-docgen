<?php if( $RenderLayout ): ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?php echo ( empty( $HeaderTitle ) ? '' : ( $HeaderTitle . ' · ' ) ) . $Project; ?> Scripting API Reference</title>
	
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $BaseURL; ?>style.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
				<div class="header"><?php echo $Project; ?> API</div>
				
				<input class="form-control typeahead" type="text" placeholder="Search functions">
				
				<noscript>
					<style>
						.typeahead {
							display: none;
						}
						
						.bg-primary {
							padding: 10px;
							text-align: center;
						}
					</style>
					
					<p class="bg-primary">Search requires javascript to work</p>
				</noscript>
				
				<div id="sidebar-files-search"></div>
				<div id="sidebar-files">
					<?php require __DIR__ . '/sidebar.php'; ?>
				</div>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="pjax-container">
<?php else: ?>
	<title><?php echo ( empty( $HeaderTitle ) ? '' : ( $HeaderTitle . ' · ' ) ) . $Project; ?> Scripting API Reference</title>
<?php endif; ?>
