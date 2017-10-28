<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?php echo get_bloginfo( 'name' ); ?></title>



	<link rel="shortcut icon" href="<?php echo plugin_dir_url( __FILE__ ).'..'; ?>/favicon.ico" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<?php wp_head();?>
</head>

<body>
	<?php
		if(!isset($_SESSION['locale'])) {
		    $_SESSION['locale']=1;
		}
	?>

 		<div class="bte-masthead container">
			<table border="0">
			<tr>
			<td><img width="100px" src="<?php echo plugin_dir_url( __FILE__ ).'..';?>/favicon.png"></td>
			<td><h1 class="bte-title"><?php echo get_bloginfo( 'name' ); ?></h1></td>
			<td><img width="100px" src="<?php echo plugin_dir_url( __FILE__ ).'..';?>/favicon.png"></td>
			</tr>
			</table>
			<nav class="navbar navbar-default">
			  <div class="container-fluid">
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			    </div>
			    <div id="navbar" class="navbar-collapse collapse">
			      <ul class="nav navbar-nav">
			          <li><a href="<?php echo get_permalink( get_page_by_path('faculty'))?>">People</a></li>
			          <li><a href="<?php echo get_permalink( get_page_by_path('research'))?>">Research</a></li>
					  <li><a href="<?php echo get_permalink( get_page_by_path('projects'))?>">Projects</a></li>
					  <li><a href="<?php echo get_permalink( get_page_by_path('publications'))?>">Publications</a></li>
					  <li><a href="<?php echo get_permalink( get_page_by_path('positions'))?>">Open Positions</a></li>
					  <li><a href="<?php echo get_permalink( get_page_by_path('contact'))?>">Contact</a></li>
			      </ul>
			      <ul class="nav navbar-nav navbar-right">
					  <li><button class="navbar-btn locale-picker " onclick="wpri_change_locale('1')"> English</button></li>
					  <li><button class="navbar-btn locale-picker " onclick="wpri_change_locale('2')"> Turkish</button></li>
			      </ul>
			    </div><!--/.nav-collapse -->
			  </div><!--/.container-fluid -->
			</nav>
		</div>

	<div class="container" style="background-image: url('http://bte.gtu.edu.tr/wp-content/uploads/2016/03/bg2.jpg'); ">
