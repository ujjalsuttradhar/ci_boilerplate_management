


<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User
            <small>Administration</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Users</a></li>
            <li class="active">List Of All Users</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <?php if ($success_status || $error_status) : ?>
                    <div class="alert <?php echo ($success_status) ? "alert-success" : "alert-danger"; ?> alert-dismissable">
                        <i class="fa fa-check"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $action_status; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"> Create New User</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="<?php echo $base_url; ?>users/create">
                        <div class="box-body" id="update_prof">

                            <div class="form-group">
                                <?php
                                $options = array();
                                $options["-1"] = "Select User Role";
                                foreach ($roles as $role)
                                    $options[$role->id] = $role->role;

                                echo form_dropdown('role_id', $options, "-1", 'class="form-control"');
                                ?> 
                                <?php echo form_error('role_id'); ?>

                            </div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" id="username" placeholder="Username" autocomplete="off" value="<?php echo set_value('username'); ?>"/>
                                <?php echo form_error('username'); ?>

                            </div>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo set_value('email'); ?>"/>
                                <?php echo form_error('email'); ?>

                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password" value="123456"/>
                                <?php echo form_error('password'); ?>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password2" class="form-control" placeholder="Retype password" value="123456"/>
                                <?php echo form_error('password2'); ?>
                            </div>

                        </div> <!--/.box-body-->
                        <div class = "box-footer">
                            <button type="submit" class="btn btn-primary" value="1" name="create_user_edit_profile">Create User</button>
                            <button type="submit" class="btn btn-success" value="2" name="create_user_edit_profile">Create User & Edit Profile</button>
                            <a href="<?php echo $base_url; ?>users/list_all"><button type="button" class="btn btn-default">Back to User List</button></a>
                        </div>
                    </form>
                </div>
            </div><!--/.box-->
            <div class="col-md-2"></div>
        </div>  
    </section><!-- /.content -->
</aside><!-- /.right-side -->