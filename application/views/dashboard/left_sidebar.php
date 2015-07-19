<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <?php
                    $url = $base_url . "resources/uploads/profile_pics/" . $currentUser->photo;
                    $found = @getimagesize($url);

                    if ($currentUser->photo == null || $found == false)
                        $url = $base_url . "resources/img/avatar.png";
                    ?>      
                    <img src="<?php echo $url; ?>" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>Hello, <?php echo $currentUser->username; ?></p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search..."/>
                    <span class="input-group-btn">
                        <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <?php
             $menuList = array();
            ;?>
            
            
            <ul class="sidebar-menu">
                <li <?php echo ifActiveUrl($currentMenu, 'dashboard');?>>
                    <a href="<?php echo $base_url; ?>dashboard">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <!--                 <li>
                                     <a href="<?php echo $base_url; ?>resources/pages/widgets.html">
                                         <i class="fa fa-th"></i> <span>Widgets</span> <small class="badge pull-right bg-green">new</small>
                                     </a>
                                 </li>-->
                <?php if ($currentUser->role_id == isAdmin() ) { ?>
                    <li class="treeview <?php echo ifHasActiveUrl($currentMenuParent,'users');?>">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span>Users</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php echo ifActiveUrl($currentMenu,'user_all');?>><a href="<?php echo $base_url; ?>users/list_all"><i class="fa fa-angle-double-right"></i><span>List All</span></a></li>
                            <li <?php echo ifActiveUrl($currentMenu, 'user_1');?>><a href="<?php echo $base_url; ?>users/list_all/1"><i class="fa fa-angle-double-right"></i><span>Super Admin</span></a></li>
                            <li <?php echo ifActiveUrl($currentMenu, 'user_2');?>><a href="<?php echo $base_url; ?>users/list_all/2"><i class="fa fa-angle-double-right"></i><span>Admin</span></a></li>
                            <li <?php echo ifActiveUrl($currentMenu, 'user_3');?>><a href="<?php echo $base_url; ?>users/list_all/3"><i class="fa fa-angle-double-right"></i><span>Basic</span></a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

