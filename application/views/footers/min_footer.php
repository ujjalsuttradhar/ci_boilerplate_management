</div><!-- ./wrapper -->

<!-- Bootstrap -->
<script src="<?php echo $base_url; ?>resources/js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo $base_url; ?>resources/js/AdminLTE/app.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>resources/js/custom.js" type="text/javascript"></script>
        
        
<!-- page script -->
<script type="text/javascript">
    $(function() {
        $("#example1").dataTable();
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });

    $('#confirmDelete').on('show.bs.modal', function(e) {
        $message = $(e.relatedTarget).attr('data-message');
        $(this).find('.modal-body p').html($message);
        $title = $(e.relatedTarget).attr('data-title');
        $(this).find('.modal-title').text($title);
        // Pass form reference to modal for submission on yes/ok
        var url = $(e.relatedTarget).attr('data-url');
        $(this).find('.modal-footer #confirm').data('url', url);
    });

    $('#confirmDelete').find('.modal-footer #confirm').on('click', function() {
        window.location.href = $(this).data('url');
    });

</script>

</script>
</body>
</html>