<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green-gradient">
                    <div class="inner" id="current_balance_sm_box">
                        <h3></h3>
                        <p>Current Cash Balance</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="<?php echo $base_url; ?>dashboard/expenditure/show" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua-gradient">
                    <div class="inner" id="today_cash_sale_sm_box">
                        <h3></h3>
                        <p>
                            Today's Total Cash Sale
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                     <a href="<?php echo $base_url; ?>dashboard/expenditure/show" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red-gradient">
                    <div class="inner"  id="today_credit_sale_sm_box">
                        <h3></h3>
                        <p>
                             Today's Total Credit Sale
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                     <a href="<?php echo $base_url; ?>dashboard/expenditure/show" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow-gradient">
                    <div class="inner" id="total_bank_balance_sm_box">
                        <h3></h3>
                        <p>
                            Current Bank Balance
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                     <a href="<?php echo $base_url; ?>dashboard/accounts/" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
        </div><!-- /.row -->


        <!-- Main row -->
        <div class="row" id="chart_area">
            <div class="col-xs-12">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="nav-tabs-custom">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#area-chart" data-toggle="tab">Sales</a></li>
                    <!--    <li><a href="#sales-chart" data-toggle="tab">Donut</a></li> -->
                        <li class="pull-left header"><i class="fa fa-inbox"></i> Sales of Last 30 days</li>
                    </ul>
                    <div class="tab-content no-padding">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="area-chart" style="position: relative; height: 300px;"></div>
                      <!--  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div> -->
                    </div>
                </div><!-- /.nav-tabs-custom -->


            </div>
        </div>   

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Recent 5 Orders</h3>
                        <div class="box-tools">
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table id="recent_order_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Order No </th>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Stock No</th>
                                    <th>Selling Quantity</th>
                                    <th>Total Price</th>
                                    <th>Payment</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Order_ID</td>
                                    <td>Order_Date</td>
                                    <td>Product_Type</td>
                                    <td>Stock_No</td>
                                    <td>Selling_Quantity</td>
                                    <td>Total_Price</td>
                                    <td>Payment</td>
                                    <td>Type</td>
                                    <td>Action</td>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Order No </th>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Stock No</th>
                                    <th>Selling Quantity</th>
                                    <th>Total Price</th>
                                    <th>Payment</th>
                                    <th>Type</th>
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