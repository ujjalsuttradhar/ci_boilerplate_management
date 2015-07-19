<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Profile
            <small>Administration</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $base_url; ?>users/list_all">Users</a></li>
            <li class="active">my profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php if ($success_status || $error_status) : ?>
                <div class="alert <?php echo ($success_status) ? "alert-success" : "alert-danger"; ?> alert-dismissable">
                    <i class="fa fa-check"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $action_status; ?>
                </div>
            <?php endif; ?>

            <div class="col-xs-6">
                <a href="<?php echo $base_url; ?>users/update/<?php echo $profile->id ?>" class="btn btn-success btn-lg">Update Profile</a>
                <?php if ($user->role_id == 2): // only fo customers?>
                <a href="<?php echo $base_url; ?>users/updateCreditLimit/<?php echo $profile->id ?>" class="btn btn-success btn-lg">Update Credit Limit</a>
                <?php endif;?>
            </div>
        </div>  
        <br/>

        <div class="row">

            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"> 
                            <?php
                               echo '<p><strong>'.$profile->name.'</strong></p>'; 
                               echo '<p>'.$profile->address.'</p>';?>
                        </h3>
                    </div><!-- /.box-header -->
                    
                    <!-- form start -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <!-- THE MESSAGES -->
                            <table class="table table-hover">
                                <tbody>
                                    <!-- common fields for all -->
                                    <tr >
                                        <td class="small-col">
                                            <i class="<?php echo getFieldIcon("id"); ?>"></i>
                                        </td>
                                        <td ><?php echo getFieldLabel("id") ?></td>
                                        <td class=""><?php echo validateProfileData($profile->id)." (".$profile->username.")"; ?></td>
                                    </tr>

                                    <tr >
                                        <td class="small-col">
                                            <i class="<?php echo getFieldIcon("role"); ?>"></i>
                                        </td>
                                        <td ><?php echo getFieldLabel("role") ?></td>
                                        <td class=""><?php echo validateProfileData($profile->role); ?></td>
                                    </tr>
                                    <tr >
                                        <td class="small-col">
                                            <i class="<?php echo getFieldIcon("name"); ?>"></i>
                                        </td>
                                        <td ><?php echo getFieldLabel("name") ?></td>
                                        <td class=""><?php echo validateProfileData($profile->name); ?></td>
                                    </tr>


                                        <tr >
                                            <td class="small-col">
                                                <i class="<?php echo getFieldIcon("address"); ?>"></i>
                                            </td>
                                            <td ><?php echo getFieldLabel("address") ?></td>
                                            <td class=""><?php echo validateProfileData($profile->address); ?></td>
                                        </tr>

                                        <tr >
                                            <td class="small-col">
                                                <i class="<?php echo getFieldIcon("cell_no"); ?>"></i>
                                            </td>
                                            <td ><?php echo getFieldLabel("cell_no") ?></td>
                                            <td class=""><?php echo validateProfileData($profile->cell_no); ?></td>
                                        </tr>
         
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">

                    </div>
                </div><!-- /.box -->
            </div>
            <div class="col-md-4">

                <!-- Form Element sizes -->
                <div class="box box-success">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        <div class="image">
                            <?php
                            // image url
                            $url = $base_url . "resources/uploads/profile_pics/" . $profile->photo;
                            $found = @getimagesize($url);

                            if ($profile->photo == null || $found == false)
                                $url = $base_url . "resources/img/avatar.png";
                            ?>

                            <img src="<?php echo $url; ?>" class="img-responsive center-block" alt="User Image" />
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer info text-center">
                        <i class="fa fa-signal"></i>  Active since <?php echo changeDateTimeFormat($profile->created_at); ?>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->



<!-- Modal Dialog -->
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Delete Parmanently</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure about this ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm">Delete</button>
            </div>
        </div>
    </div>
</div>


