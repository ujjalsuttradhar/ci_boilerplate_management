<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>ProgatiSoft | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo $base_url;?>resources/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo $base_url;?>resources/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo $base_url;?>resources/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Progati Creative (Pvt.) Ltd.</div>
            <form action="<?php echo $base_url;?>users/login" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <?php
                            if($login_error)
                                echo '<div class="error text-red">'.$login_error_message.'</div>';
                          ?>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo set_value('username'); ?>"/>
                        <?php echo form_error('username'); ?>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo set_value('password'); ?>"/>
                        <?php echo form_error('password'); ?>
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                    <p><a href="#">I forgot my password</a></p>
                </div>
            </form>
        </div>

        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo $base_url;?>resources/js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>