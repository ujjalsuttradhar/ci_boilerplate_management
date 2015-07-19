<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Update Profile
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $base_url; ?>users/profile/<?php echo $profile->id; ?>" >Back to Profile</a></li>
            <li class="active">Update Profile</li>
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
        </div>  

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
                    <form role="form" method="post" action="<?php echo $base_url; ?>users/update/<?php echo $user->id; ?>">
                        <div class="box-body" id="update_prof">

                            <!-- common fields for all user -->
                            <div class="form-group">
                                <label for="id"><?php echo getFieldLabel("id"); ?></label>
                                <?php $value = generateUserID($profile->id)." (".$profile->username.")"; ?>
                                <input type="text" name="id" class="form-control"  value = "<?php echo $value; ?>"  disabled>
                            </div>
                            <div class="form-group">
                                <label for="role"><?php echo getFieldLabel("role"); ?></label>
                                <input type="text" name="role" class="form-control"  value = "<?php echo $profile->role; ?>"  disabled>
                            </div> 
                            <div class="form-group">
                                <label for="name"><?php echo getFieldLabel("name"); ?></label>
                                <input type="text" name="name" class="form-control" id="full_name" value = "<?php echo $profile->name; ?>">
                                <?php echo form_error('name'); ?>
                            </div>

                                <div class="form-group">
                                    <label for="address"><?php echo getFieldLabel("address"); ?></label>
                                    <input type="text" name="address" class="form-control"  value = "<?php echo $profile->address; ?>">
                                </div> 

                                <div class="form-group">
                                    <label for="cell_no"><?php echo getFieldLabel("cell_no"); ?></label>
                                    <input type="text" name="cell_no" class="form-control"  value = "<?php echo $profile->cell_no; ?>">
                                </div> 

                            
                            <!-- fields for Employee And Customer  -->
                          
                        </div> <!--/.box-body-->
                        <div class = "box-footer">
                            <button type = "submit" class = "btn btn-primary">Update Profile</button>       <a href="<?php echo $base_url; ?>users/profile/<?php echo $profile->id; ?>" class ="btn btn-default">Back to Profile</a>
                        </div>
                    </form>
                </div>
            </div><!--/.box-->
            <div class = "col-md-4">

                <!--Form Element sizes-->
                <div class = "box box-success">
                    <div class = "box-header"></div>
                    <div class = "box-body">
                        <div class = "image" id="output">
                            <?php
                            // image url
                            $url = $base_url . "resources/uploads/profile_pics/" . $profile->photo;
                            $found = @getimagesize($url);

                            if ($profile->photo == null || $found == false)
                                $url = $base_url . "resources/img/avatar.png";
                            ?>
                            <img src = "<?php echo $url; ?>" class = "img-responsive center-block" alt = "User Image" />
                        </div>
                    </div><!--/.box-body-->
                    <div class = "box-footer info">
                        <form action="<?php echo $base_url; ?>users/upload_photo" method="post" enctype="multipart/form-data" id="MyUploadForm" class="text-center">
                            <div class = "form-group">
                                <input name="image_file" id="imageInput" type="file" title="Select Pofile Photo"/>
                            </div>  
                            <div class = "form-group">
                                <input type="submit"  class="btn btn-primary" value="Upload Photo" />
                            </div>
                            <img src="<?php echo $base_url; ?>resources/img/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
                            <input type="hidden" name="userid" value="<?php echo $user->id; ?>" />
                        </form>
                        <p class = "help-block1 text-center">A 320x360 photo less than 500KB is best!</p>

                        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.50/jquery.form.min.js"></script>
                    </div>
                </div><!--/.box-->
            </div>
        </div>

        </div>
    </section><!--/.content-->
</aside><!--/.right-side-->



<!--Modal Dialog-->
<div class = "modal fade" id = "confirmDelete" role = "dialog" aria-labelledby = "confirmDeleteLabel" aria-hidden = "true">
    <div class = "modal-dialog">
        <div class = "modal-content">
            <div class = "modal-header">
                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">&times;
                </button>
                <h4 class = "modal-title">Delete Parmanently</h4>
            </div>
            <div class = "modal-body">
                <p>Are you sure about this ?</p>
            </div>
            <div class = "modal-footer">
                <button type = "button" class = "btn btn-default" data-dismiss = "modal">Cancel</button>
                <button type = "button" class = "btn btn-danger" id = "confirm">Delete</button>
            </div>
        </div>
    </div>
</div>


