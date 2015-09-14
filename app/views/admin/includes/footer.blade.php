

<script src="<?php echo url(); ?>/app/views/admin/js/jquery-1.8.2.min.js"></script>
<!-- Ion Slider -->
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/ionslider/ion.rangeSlider.min.js" type="text/javascript"></script>
<script type="text/javascript">

    $(document).ready(function() {
//        var conHeight = $(".container").height();
//        var imgHeight = $(".container img").height();
//        var gap = (imgHeight - conHeight) / 2;
//        $(".container img").css("margin-top", -gap);
        $("#age_group_2").ionRangeSlider({
            min: '0',
            max: '100',
            max_postfix: "+",
            type: 'double',
            step: '1',
            prefix: "Age ",
            force_edges: true,
            prettify: true,
            grid: true,
        });
        $("#age_group").ionRangeSlider({
            min: '0',
            max: '100',
            max_postfix: "+",
            type: 'double',
            step: '1',
            prefix: "Age ",
            force_edges: true,
            prettify: true,
            grid: true,
        });
    });

</script>
<script src="<?php echo url(); ?>/app/views/admin/js/mradifund_pt.js" type="text/javascript"></script>
<script src="<?php echo url(); ?>/app/views/admin/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo url(); ?>/app/views/admin/js/jquery-ui.min.js" type="text/javascript"></script>

<!-- Input Mask -->
<!-- InputMask -->
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<!-- Morris.js charts -->
<script src="<?php echo url(); ?>/app/views/admin/js/raphael-min.js"></script>
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/morris/morris.min.js" type="text/javascript"></script>
<!-- Sparkline -->
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- datepicker -->
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="<?php echo url(); ?>/app/views/admin/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<!-- timepicker -->
<!-- AdminLTE App -->
<script src="<?php echo url(); ?>/app/views/admin/js/AdminLTE/app.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo url(); ?>/app/views/admin/js/AdminLTE/dashboard.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->

<script src="<?php echo url(); ?>/app/views/admin/js/AdminLTE/demo.js" type="text/javascript"></script>
<script src="<?php echo url(); ?>/app/views/admin/js/bootstrap-dialog.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript">
    var p_url = '<?php echo url(); ?>';
    var activetab = "{{ Session::get('activetab') }}";
    if (activetab != '')
    {
        $("#" + activetab).addClass('active');
        $("a[href='#" + activetab + "']").closest('li').addClass('active');
    }
    
    getTotalShares();
    $("[name='allocated_shares'],[name='unallocated_shares']").bind('change propertychange keyup input paste', function() {
        getTotalShares()
    });
    function getTotalShares()
    {
        $("[name='total_no_shares']").val(Number($("[name='allocated_shares']").val()) + Number($("[name='unallocated_shares']").val()));
    }
    $(function() {
        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();
    })
    getTotalInvestment();
    getMinMaxIndShares();
    getMinMaxInvestors();
    getBoardShares();
    $("[name='no_shares_on_offer'],[name='share_price'],[name='min_indie_investment'],[name='max_indie_investment'],[name='board_seat_investment']").bind('change propertychange keyup input paste', function() {
        getTotalInvestment();
        getMinMaxIndShares();
        getMinMaxInvestors();
        getBoardShares();
    });
    function getTotalInvestment()
    {
        $("[name='total_investment']").val(Number($("[name='no_shares_on_offer']").val()) * Number($("[name='share_price']").val()));
    }
    function getMinMaxIndShares()
    {
        $("[name='min_indv_shares']").val(Math.ceil(Number($("[name='total_investment']").val()) / Number($("[name='min_indie_investment']").val())));
        $("[name='max_indv_shares']").val(Math.ceil(Number($("[name='total_investment']").val()) / Number($("[name='max_indie_investment']").val())));
    }
    function getMinMaxInvestors()
    {
        $("[name='max_no_inv']").val(Math.ceil(Number($("[name='min_indie_investment']").val()) / Number($("[name='share_price']").val())));
        $("[name='min_no_inv']").val(Math.ceil(Number($("[name='max_indie_investment']").val()) / Number($("[name='share_price']").val())));
    }
    function getBoardShares()
    {
        $("[name='board_no_shares']").val(Math.ceil(Number($("[name='no_shares_on_offer']").val()) * Number($("[name='board_seat_investment']").val()) * 0.01));
    }
    $("[name='categories_list']").change(function() {
        $(this).closest('form').submit();
    });
    function submitAction(url)
    {
        if ($("[name='comment']").val() == '')
        {
            alert('Please enter comment');
            return false;
        } else
        {
            $("[name='campaignAction']").attr('action', url).submit();
        }
    }
    $("[name='incorporation_date']").datepicker(
        {
          minDate: new Date(1900,1-1,1), maxDate: '-18Y',
          dateFormat: 'yy/mm/dd',
          defaultDate: new Date(1990,1-1,1),
          changeMonth: true,
          changeYear: true,
          yearRange: '-110:-18'
        });
    $(".datefilter").datepicker(
            {
                dateFormat: 'yy/mm/dd',
                changeMonth: true,
                maxDate: '0',
                changeYear: true
            });
    $(".datefilterto").datepicker(
            {
                dateFormat: 'yy/mm/dd',
                changeMonth: true,
                maxDate: '0',
                changeYear: true
            });
    $('.Cpcomment').click(function(e)
    {
        e.preventDefault();
        BootstrapDialog.show({
            title: 'Campaign Action',
            message: $('{{Form::open(array("url"=>"","files"=>true, "name"=>"campaignAction"))}}' +
                    '{{Form::textarea("comment","",array("placeholder"=>"Comment on the action of this campaign...","class"=>"form-control","rows"=>"5")) }}' +
                    '<br/><a class="btn btn-success pull-right" href="' + $(this).attr('href') + '">Submit</a><br/><br/>' +
                    '{{Form::close()}}')
        });
    });
</script>
<script type="text/javascript">
    $(function() {

//        "use strict";

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
</script>
