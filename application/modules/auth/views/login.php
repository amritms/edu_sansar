  <!DOCTYPE HTML>
  <html lang="en">
  <head>
  <meta charset="utf-8">
  <title>Login panel of Education Sansar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Admin Panel V 2.0">
  <meta name="author" content="Amrit Man Shrestha">
  <!-- styles -->
  <link href="<?php echo site_url("assets/admin/css/bootstrap.css"); ?>" rel="stylesheet">
  <link href="<?php echo site_url("assets/admin/css/styles.css"); ?>" rel="stylesheet">
  <link href="<?php echo site_url("assets/admin/css/bootstrap-responsive.css"); ?>" rel="stylesheet">
  <link href="<?php echo site_url("assets/admin/css/icons-sprite.css"); ?>" rel="stylesheet">
  <link id="themes" href="<?php echo site_url("assets/admin/css/themes.css"); ?>" rel="stylesheet">
  <!--[if IE 7]>
  <link rel="stylesheet" type="text/css" href="css/ie/ie7.css" />
  <![endif]-->
  <!--[if IE 8]>
  <link rel="stylesheet" type="text/css" href="css/ie/ie8.css" />
  <![endif]-->
  <!--[if IE 9]>
  <link rel="stylesheet" type="text/css" href="css/ie/ie9.css" />
  <![endif]-->
  <body>
  <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
          <div class="container-fluid">
              <div class="branding">
                  <div class="logo">
                      <a href="index.html">Logo</a>
                  </div>
                              <div>Login panel of Education Sansar</div>
              </div>
              <ul class="nav pull-right">
                  <li><a href="#"><i class="icon-share-alt icon-white"></i> Go to Main Site</a></li>
              </ul>
          </div>
      </div>
  </div>
  <div class="login-container">
          <div id="infoMessage"><?php echo $message;?></div>
      <?php echo form_open("auth/login");?>
      <div class="well-login">
          <div class="control-group">
              <div class="controls">
                  <div>
                  	<?php 
                            $identity['class'] = 'login-input user-name';
                            $identity['placeholder'] = 'Username or Email';
			?>
                      <?php echo form_input($identity);?>
                  </div>
              </div>
          </div>
          <div class="control-group">
              <div class="controls">
                  <div>
                  	<?php
                            $password['class'] = 'login-input user-pass';
                            $password['placeholder'] = 'Password';
			?>
                      <?php echo form_password($password);?>
                  </div>
              </div>
          </div>

          <div>
    <p><?php echo form_submit(array(
                      'class'	=> 'btn btn-inverse login-btn',
                      'name'	=> 'Login',
                      'value'	=> 'Login'
                  ));?></p>
      <div class="remember-me">
      	<div class="checker" id="uniform-undefined">
              <span class="">
					<?php echo form_checkbox('remember', '1', FALSE, 'id="remember" class="rem_me"');?>
      		  </span>
              Remember Me
         </div>
      </div>
      </div></div>
  <?php echo form_close();?>
      <p><a href="forgot_password">Forgot your password?</a></p>
  		</div>
	</div>
</div>