<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Education Sansar : Admin Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Admin Panel Template">
<meta name="author" content="Westilian: Kamrujaman Shohel">
    <!-- styles -->
  <?php if(isset($output)): ?>
    <?php foreach($output->css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php endif; ?>

    <link href="<?php echo site_url("assets/admin/css/bootstrap.css"); ?>" rel="stylesheet">
    <link href="<?php echo site_url("assets/admin/css/jquery-ui-1.8.16.custom.css"); ?>" rel="stylesheet">
    <link href="<?php echo site_url("assets/admin/css/jquery.jqplot.css"); ?>" rel="stylesheet">
    <link href="<?php echo site_url("assets/admin/css/prettify.css"); ?>" rel="stylesheet">
    <link href="<?php echo site_url("assets/admin/css/elfinder.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo site_url("assets/admin/css/elfinder.theme.css"); ?>" rel="stylesheet">
    <link href="<?php echo site_url("assets/admin/css/fullcalendar.css"); ?>" rel="stylesheet">
    <link href="<?php echo site_url("assets/admin/js/plupupload/jquery.plupload.queue/css/jquery.plupload.queue.css"); ?>" rel="stylesheet">
    <link href="<?php echo site_url("assets/admin/css/styles.css"); ?>" rel="stylesheet">
    <link href="<?php echo site_url("assets/admin/css/bootstrap-responsive.css"); ?>" rel="stylesheet">
    <link href="<?php echo site_url("assets/admin/css/icons-sprite.css"); ?>" rel="stylesheet">
    <link id="themes" href="<?php echo site_url("assets/admin/css/themes.css"); ?>" rel="stylesheet">
    <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/admin/css/ie/ie7.css");?>" />
    <![endif]-->
    <!--[if IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/admin/css/ie/ie8.css");?>" />
    <![endif]-->
    <!--[if IE 9]>
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/admin/css/ie/ie9.css");?>" />
    <![endif]-->
    <!--fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo site_url("ico/apple-touch-icon-144-precomposed.png");?>">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo site_url("ico/apple-touch-icon-114-precomposed.png");?>">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo site_url("ico/apple-touch-icon-72-precomposed.png");?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo site_url("ico/apple-touch-icon-57-precomposed.png");?>">

	<?php if(isset($output)): ?>
	  	<?php foreach($output->js_files as $file): ?>
			<script src="<?php echo $file; ?>"></script>
		<?php endforeach; ?>
	<?php endif; ?>
	</head>
<body>
    <div class="navbar navbar-fixed-top">
  <div class="navbar-inner top-nav">
    <div class="container-fluid">
      <div class="branding">
        <div class="logo" style="float:left"> <img src='<?php echo site_url("assets/img/logo.png"); ?>' style="padding-top:4px;"/> </div>
      	<div style="padding-top:10px; padding-left:60px; color:#FFFFFF; float:left; font-size:14px;"> Welcome to Education Sansar Admin !!!!</div>
      </div>
      <ul class="nav pull-right">
        <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#">Anthony <span class="alert-noty">25</span><i class="white-icons admin_user"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="icon-inbox"></i> Inbox <span class="alert-noty">10</span></a></li>
            <li><a href="#"><i class="icon-envelope"></i> Notifications <span class="alert-noty">15</span></a></li>
            <li><a href="#"><i class="icon-briefcase"></i> My Account</a></li>
            <li><a href="#"><i class="icon-file"></i> View Profile</a></li>
            <li><a href="#"><i class="icon-pencil"></i> Edit Profile</a></li>
            <li><a href="#"><i class="icon-cog"></i> Account Settings</a></li>
            <li class="divider"></li>
            <li><?php echo anchor('auth/logout','<i class="icon-off"></i><strong> Logout</strong>'); ?></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>