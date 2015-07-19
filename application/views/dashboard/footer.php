</div><!-- ./wrapper -->

<!-- add new calendar event modal -->

<!-- Bootstrap -->
<script src="<?php echo $base_url; ?>resources/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo $base_url; ?>resources/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>resources/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo $base_url; ?>resources/js/AdminLTE/app.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>resources/js/file-input/bootstrap.file-input.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>resources/js/custom.js" type="text/javascript"></script>
<script type='text/javascript' src="http://twitter.github.com/typeahead.js/releases/latest/typeahead.bundle.min.js"></script>



   <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo $base_url; ?>resources/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo $base_url; ?>resources/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <!-- Page script -->
             
        
        
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
        
        
        //Inbox
         "use strict";

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass: 'iradio_minimal-blue'
                });

                //When unchecking the checkbox
                $("#check-all").on('ifUnchecked', function(event) {
                    //Uncheck all checkboxes
                    $("input[type='checkbox']", ".table-mailbox").iCheck("uncheck");
                });
                //When checking the checkbox
                $("#check-all").on('ifChecked', function(event) {
                    //Check all checkboxes
                    $("input[type='checkbox']", ".table-mailbox").iCheck("check");
                });
                //Handle starring for glyphicon and font awesome
                $(".fa-star, .fa-star-o, .glyphicon-star, .glyphicon-star-empty").click(function(e) {
                    e.preventDefault();
                    //detect type
                    var glyph = $(this).hasClass("glyphicon");
                    var fa = $(this).hasClass("fa");

                    //Switch states
                    if (glyph) {
                        $(this).toggleClass("glyphicon-star");
                        $(this).toggleClass("glyphicon-star-empty");
                    }

                    if (fa) {
                        $(this).toggleClass("fa-star");
                        $(this).toggleClass("fa-star-o");
                    }
                });

                //Initialize WYSIHTML5 - text editor
                $("#email_message").wysihtml5();
        
        
        
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


    jQuery(document).ready(function($) {
        $('.add-box').click(function() {
            var n = $('.security_group').length + 1;
            var box_html = $('<div class="security_group">' +
                    '<div class="checkbox">' +
                    '<label class="">' +
                    '<div class="input-group">' +
                    '<input type="radio" name="sc[' + n + '][security_item]" value="bank" checked/> &nbsp;Bank' +
                    '&nbsp; &nbsp; &nbsp;' +
                    '<input type="radio" name="sc[' + n + '][security_item]" value="cheque"/> &nbsp;cheque' +
                    '</div>' +
                    '</label>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="BankName">Bank Name with Branch Name (e.g Branch Name, Bank Name )</label>' +
                    '<input type="text" name="sc[' + n + '][bank_name]" class="form-control" id="bank-name" placeholder="Bank Name">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="AccountNumber">Account Number</label>' +
                    ' <input type="text" name="sc[' + n + '][account_no]" class="form-control" id="account-number" placeholder="Account Number">' +
                    '</div>' +
                    '<a href="#" class="remove-box btn btn-warning"><i class="fa fa-minus"></i> Remove This Security Item!</a>' +
                    '</div>');
            box_html.hide();
            $('.security_group:last').after(box_html);
            box_html.fadeIn('slow');
            return false;
        });
    });

    $('#update_prof').on('click', '.remove-box', function() {
        // $(this).parent().css('background-color', '#FF6C6C');
        $(this).parent().fadeOut("slow", function() {
            $(this).remove();
            $('.box-number').each(function(index) {
                $(this).text(index + 1);
            });
        });
        return false;
    });
    
    $('input[type=file]').bootstrapFileInput();
</script>

</script>
</body>
</html>