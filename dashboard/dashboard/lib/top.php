<?php $xml=simplexml_load_file($folder."data/version.xml") or die("Error: Cannot create object");;?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Dashboard Builder</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?php echo $folder;?>favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" href="<?php echo $folder;?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $folder;?>css/font-awesome.min.css">
<!-- <link rel="stylesheet" href="<?php //echo $folder;?>css/style_v1.css"> -->
<link rel="stylesheet" href="<?php echo $folder;?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo $folder;?>css/layoutsetting.css"> 
<style>
/* Paste this css to your style sheet file or under head tag */
/* This only works with JavaScript, 
if it's not present, don't show loader */
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(<?php echo $folder;?>assets/img/preloader_1.gif) center no-repeat rgba(255, 255, 255, 1);
	 background-size: 150px 150px;
}

.se-pre-modal {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(<?php echo $folder;?>assets/img/preloader_1.gif) center no-repeat rgba(255, 255, 255, 1);
	 background-size: 150px 150px;
	 display:none;
}
</style>

<script src="<?php echo $folder;?>assets/js/jquery.min.js"></script>
<script src="<?php echo $folder;?>assets/js/jquery-ui.js"></script>
<script src="<?php echo $folder;?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo $folder;?>assets/js/modernizr.js"></script>
<script>
	//paste this code under head tag or in a seperate js file.
	// Wait for window load
	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
</script>

</head>

<body>
<div class="se-pre-con"></div>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
					
			
			<button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed">
			MENU
			</button>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#" style="margin-top:-20px;">
				<img src="<?php echo $folder;?>assets/img/dashboardbuilder_logo.png"/>
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">  

		
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown ">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						<span class="fa fa-question-circle" style="font-size:2em; " ></span>
						<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class=""><a href="https://dashboardbuilder.net/documentation" target="_blank">Documentation</a></li>
							<li class=""><a href="https://dashboardbuilder.net/support" target="_blank">Support</a></li>
							<li class=""><a href="https://dashboardbuilder.net/contact-us" target="_blank">Contact us</a></li>
							<li><a href="https://dashboardbuilder.net" target="_blank">Visit Site</a></li>
							<li class="divider"></li>
							<li><a href="#" style="pointer-events: none;">Version:<?php echo $xml->version; ?></a></li>
							<li><a href="#" style="pointer-events: none;">Type:<?php echo $xml->type; ?></a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav> 
