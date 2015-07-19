</div><!-- ./wrapper -->

<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script src="<?php echo $base_url; ?>resources/js/plugins/morris/morris.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="<?php echo $base_url; ?>resources/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo $base_url; ?>resources/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>resources/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="<?php echo $base_url; ?>resources/js/AdminLTE/app.js" type="text/javascript"></script>

<script>
    $('#chart_area').ready(function() {
        $.post("dashboard/home/getLastMonthsSaleData", function(sales) {
            var area = new Morris.Area({
                element: 'area-chart',
                resize: true,
                data: sales,
                xkey: 'selling_date',
                ykeys: ['total_cash', 'total_credit'],
                labels: ['Total Cash', 'Total Credit'],
                lineColors: ['#3c8dbc', '#f56954'],
                hideHover: 'auto',
                ymax: 'auto',
                ymin: 'auto',
                parseTime: false,
                fillOpacity : 0.6,
                behaveLikeLine: true,
                postUnits: ' BDT',
                    xLabelFormat: function(x){
                    var date = new Date(x['label']);
                    var month = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"][date.getMonth()];
                    return (month + ' '+date.getDate());
                }
            });

        }, "json");
    });

    $('#current_balance_sm_box').ready(function() {
        $.post("dashboard/home/getTotalCashOfProgati", function(cash) {
            $('#current_balance_sm_box h3').html(cash);
        });
    });

    $('#today_cash_sale_sm_box').ready(function() {
        $.post("dashboard/home/getTotalSaleOfProgatiByType", {sale_type: 1}, function(cash) {
            $('#today_cash_sale_sm_box h3').html(cash);
        });
    });

    $('#today_credit_sale_sm_box').ready(function() {
        $.post("dashboard/home/getTotalSaleOfProgatiByType", {sale_type: 2}, function(cash) {
            $('#today_credit_sale_sm_box h3').html(cash);
        });
    });

    $('#total_bank_balance_sm_box').ready(function() {
        $.post("dashboard/home/getTotalBankBalanceOfProgati", function(cash) {
            $('#total_bank_balance_sm_box h3').html(cash);
        });
    });
    
        $("#recent_order_table").dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false,
        });
</script>
</body>
</html>