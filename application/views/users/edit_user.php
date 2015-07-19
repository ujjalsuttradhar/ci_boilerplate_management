


<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit User
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
                        <h3 class="box-title"> Edit <?php echo $user->username;?>'s info</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                     <form action="<?php echo $base_url; ?>users/edit/<?php echo $user->id; ?>" method="post">
                        <div class="box-body" id="update_prof">

                             <div class="form-group">
                                <?php
                                $options = array();
                                $options["-1"] = "Select User Role";
                                foreach ($roles as $role)
                                    $options[$role->id] = $role->role;

                                echo form_dropdown('role_id', $options, $user->role_id, 'class="form-control"');
                                ?> 
                                <?php echo form_error('role_id'); ?>

                            </div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $user->username; ?>" disabled/>
                                <?php echo form_error('username'); ?>

                            </div>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $user->email; ?>"/>
                                <?php echo form_error('email'); ?>

                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="New password"/>
                                <?php echo form_error('password'); ?>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password2" class="form-control" placeholder="Retype new password"/>
                                <?php echo form_error('password2'); ?>

                            </div>


                        </div> <!--/.box-body-->
                        <div class = "box-footer">
                             <input type="hidden" name ="username" value ="<?php echo $user->username; ?>">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="<?php echo $base_url; ?>users/list_all"><button type="button" class="btn btn-default">Back to User List</button></a>
                   
                        </div>
                    </form>
                </div>
            </div><!--/.box-->
            <div class="col-md-2"></div>
        </div>  
    </section><!-- /.content -->
</aside><!-- /.right-side -->