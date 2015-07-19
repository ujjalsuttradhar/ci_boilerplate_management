<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User
            <small>Administration</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $base_url; ?>users/list_all">Users</a></li>
            <li class="active">List Of All Users</li>
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
            <div class="col-xs-12">
                <div class="col-xs-6">
                    <?php
                    $disabled = (!isAdmin($currentUser->role_id)) ? "disabled" : "";
                    ?>
                    <a href="<?php echo $base_url; ?>users/create" class="btn btn-success btn-lg" <?php echo $disabled; ?>>Create New User</a>
                </div>
                <div class="col-xs-6">
                    <form action="#" method="post" class="sidebar-form">
                        <div class="input-group col-xs-12">
                            <input type="text" name="users" class="typeahead form-control" placeholder="Search by Name, Shop or Proprietor name...">
                            <span class="input-group-btn">
                                <button type="button" name="seach" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>  

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Filter User By</h3>

                        <form action="<?php echo $base_url; ?>users/list_all" method="post">     

                            <div class="form-group col-md-3 top_margin_5">
                                <?php
                                $options = array();
                                $options["-1"] = "Select User Role";
                                foreach ($roles as $role)
                                    $options[$role->id] = $role->role;

                                echo form_dropdown('role_id', $options, $filter_by_role, 'class="form-control"');
                                ?> 
                            </div> 

                            <?php //TODO Add other filtering options?> 
                            
                            <div class="col-md-1 top_margin_5">
                                <input type="submit" class="btn btn-success btn-block" value="Filter"/>
                            </div>
                            <input type="hidden" name="filter_form_submitted" value="1"/>
                        </form>

                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID </th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Creation Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($userList)
                                    foreach ($userList as $user) {
                                        echo '<tr>';
                                        echo '<td>' . $user->id . '</td>';
                                        echo '<td><a href="' . $base_url . 'users/profile/' . $user->id . '">' . $user->username . '</a></td>';
                                        echo '<td>' . $user->email . '</td>';
                                        echo '<td>' . $user->role . '</td>';
                                        echo '<td>' . $user->created_at . '</td>';
                                        echo '<td><a href="' . $base_url . 'users/edit/' . $user->id . '" class="btn btn-warning btn-sm" ' . $disabled . '>Edit</a>&nbsp;<button data-url="' . $base_url . 'users/delete/' . $user->id . '" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="The User <strong>' . $user->username . '</strong> may have lots of history. Are you sure you want to delete <strong>' . $user->username . '</strong> ?" ' . $disabled . '>Delete</button></td>';
                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Creation Date</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
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


