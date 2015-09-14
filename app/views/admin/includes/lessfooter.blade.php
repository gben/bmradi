<script src="<?php echo url(); ?>/app/views/admin/js/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('[name="updatebtn"]').click(function() {
            var dataString = $(this).closest("form").serialize();
            $.ajax({
                type: 'post',
                headers: {'X-CSRF-Token': $('[name=_token]').attr('value')},
                url: $(this).closest("form").attr("action"),
                data: dataString,
                success: function(result) {
                    if($.trim(result)=='OK')
                        {
                            location.reload();
                        }
                },
                complete: function() {
                }
            });
        });
        $("[name='update'],[name='delete']").click(function() {
           
            var dataString = $(this).closest("form").serialize() + "&action="+$(this).attr("name");
            $.ajax({
                type: 'post',
                headers: {'X-CSRF-Token': $('[name=_token]').attr('value')},
                url: $(this).closest("form").attr("action"),
                data: dataString,
                success: function(result) {
                    $("#gridTable").hide();
                    $("#gridForm").show();
                    $('#gridForm').html(result);
                },
                complete: function() {
                }
            });
        });
        $("[name='cancel']").click(function() {
            $("#gridTable").show();
            $("#gridForm").empty();
            $("#gridForm").hide();
        });
        $(':checkbox[name="permission[]"]').live('click',function()
            {  //'onChange',
                if ($(this).attr("value") == "all")
                {
                    var checked = ($(this).attr('checked') == 'checked') ? 'true' : false;
                    $(':checkbox[name="permission[]"]').each(function() {
                        if($(this).attr('disabled')!="disabled") {
                            $(this).attr('checked', checked);
                        };
                    });
                }
            });                    
    });
    
</script>        