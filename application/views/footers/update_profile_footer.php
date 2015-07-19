</div><!-- ./wrapper -->

<!-- add new calendar event modal -->

<!-- Bootstrap -->
<script src="<?php echo $base_url; ?>resources/js/bootstrap.min.js" type="text/javascript"></script>
<!-- date-range-picker -->
<script src="<?php echo $base_url; ?>resources/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo $base_url; ?>resources/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>resources/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="<?php echo $base_url; ?>resources/js/AdminLTE/app.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>resources/js/file-input/bootstrap.file-input.js" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
    $(function() {

        //update_profile_page
        $('#date_of_birth').datepicker({autoclose: true, format: "yyyy-mm-dd", todayHighlight: true, todayBtn: true});
        $('#date_of_marriage').datepicker({autoclose: true, format: "yyyy-mm-dd", todayHighlight: true, todayBtn: true});
        
        addDatePickerToAllBG();

        $("#credit_limit_list").dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false,
            "aaSorting": []
    
        });
        
        
        $('#full_name').keyup(function(){
            var value = $(this).val();
           $('#proprietor').val(value);    
        });

    });


    jQuery(document).ready(function($) {
        $('.add-box').click(function() {
            var n = $('.security_group').length + 1;
            var box_html = $('<div class="security_group">' +
                    '<div class="checkbox">' +
                    '<label class="">' +
                    '<div class="input-group">' +
                    '<input type="radio" name="sc[' + n + '][security_item]" value="bank" class="bankG" checked/> &nbsp;Bank Gurantee' +
                    '&nbsp; &nbsp; &nbsp;' +
                    '<input type="radio" name="sc[' + n + '][security_item]" value="cheque" class="check"/> &nbsp;cheque' +
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
                    '<div class="form-group">' +
                    '<label for="bg_issue_date"><?php echo getFieldLabel("bg_issue_date"); ?> (Only for Bank Gurantee)</label>' +
                    '<input type="text" name="sc[' + n + '][bg_issue_date]" class="form-control bg_issue_date" placeholder="yyyy-mm-dd">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="bg_exp_date"><?php echo getFieldLabel("bg_exp_date"); ?> (Only for Bank Gurantee)</label>' +
                    '<input type="text" name="sc[' + n + '][bg_exp_date]" class="form-control bg_expiry_date" placeholder="yyyy-mm-dd">' +
                    '</div>' +
                    '<a href="#" class="remove-box btn btn-warning"><i class="fa fa-minus"></i> Remove This Security Item!</a>' +
                    '</div>');
            box_html.hide();
            $('.security_group:last').after(box_html);
            addDatePickerToAllBG();
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


    $('input.bankG').on('ifChecked ifUnchecked', function(event) {
        if (event.type.replace('if', '').toLowerCase() == "checked") {
            //$(this).parent().eq(4).children('.bg_issue_date').show();
            //alert("Bank");
        }
    });

    $('input.check').on('ifChecked ifUnchecked', function(event) {
        if (event.type.replace('if', '').toLowerCase() == "checked") {
            //$(this).parent().eq(4).children('.bg_issue_date').show();
            //alert("Check");
        }
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

    $('input[type=file]').bootstrapFileInput();


    function addDatePickerToAllBG() {
        $('.bg_issue_date').each(function() {
            $(this).datepicker({autoclose: true, format: "yyyy-mm-dd", todayHighlight: true, todayBtn: true});
        });
        $('.bg_expiry_date').each(function() {
            $(this).datepicker({autoclose: true, format: "yyyy-mm-dd", todayHighlight: true, todayBtn: true});
        });
    }
    
    
    /*########Profile Update Page############*/
    $("#zoneList").change(function() {
        var zoneid = $(this).val();

        $.post('users/getAreasOfParticularZone', {zoneID: zoneid}, function(data) {
            var dropdown = document.getElementById("areaList");
            dropdown.innerHTML = "";
            for (var i = 0; i < data.length; i++) {
                var opt = document.createElement('option');
                opt.value = data[i]["id"];
                opt.innerHTML = data[i]["area"];
                dropdown.appendChild(opt);
            }

        }, "json");
    }); // end of change


    var options = {
        target: '#output', // target element(s) to be updated with server response 
        beforeSubmit: beforeSubmit, // pre-submit callback 
        resetForm: true, // reset the form after successful submit
        success: afterCompletation
    };

    $('#MyUploadForm').submit(function() {
        $(this).ajaxSubmit(options);  //Ajax Submit form            
        // return false to prevent standard browser submit and page navigation 
        return false;
    });


    //function to check file size before uploading.
    function beforeSubmit() {
        //check whether browser fully supports all File API
        if (window.File && window.FileReader && window.FileList && window.Blob)
        {

            if (!$('#imageInput').val()) //check empty input filed
            {
                $("#output").html("You must select a photo to upload...");
                return false
            }

            var fsize = $('#imageInput')[0].files[0].size; //get file size
            var ftype = $('#imageInput')[0].files[0].type; // get file type


            //allow only valid image file types 
            switch (ftype)
            {
                case 'image/png':
                case 'image/gif':
                case 'image/jpeg':
                case 'image/pjpeg':
                    break;
                default:
                    $("#output").html("<b>" + ftype + "</b> Unsupported file type!");
                    return false
            }

            //Allowed file size is less than 1 MB (1048576)
            if (fsize > 1048576)
            {
                $("#output").html("<b>" + fsize + "</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                return false
            }

            $('#submit-btn').hide(); //hide submit button
            $('#loading-img').show(); //hide submit button
            $("#output").html("");
        }
        else
        {
            //Output error to older browsers that do not support HTML5 File API
            $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
            return false;
        }
    }

    function afterCompletation() {
        $('#submit-btn').show(); //hide submit button
        $('#loading-img').hide(); //hide submit button

    }

</script>

</script>
</body>
</html>