/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

 $(document).ready(function() {
$("#report tr:odd").addClass("odd");
$("#report tr:even").addClass("even");
$("#report tr:not(.odd)").hide();
$("#report tr:first-child").show();

$("#report tr.odd").click(function() {
    var cell = this.title;
    var view = $("#report").attr("title");

    if ($(this).next("tr").is(":hidden"))
    {
        $("#report tr:not(.odd)").hide();
        $("#report tr:first-child").show();
        $('#loading' + cell).show();
        $('div[id^=ajaxcontent]').empty(); //Empty All elements starting with ajaxcontent
        $.ajax({
            type: 'post',
            headers: { 'X-CSRF-Token' : $('[name=_token]').attr('value') },
            url: p_url + '/fetchview',
            data: 'key=' + cell + '&view=' + view + '&id=' + $('#page_id').val(),
            success: function(result) {
                $('#ajaxcontent' + cell).html(result);
            },
            complete: function() {
                $('#loading' + cell).hide();
            }
        });
    }
    else
    {
        $('#ajaxcontent' + cell).empty();
    }
    $(this).next("tr").toggle(); // $(this).find(".arrow").toggleClass("up");
});

$('[name="updatebtn"]').click(function(){
            $('[name="' + $(this).closest("form").attr("name") + '"] .required').each(function(i, obj) {
		if($(this).is(":visible"))
		{
        if ($(this).val() == "")
        {
            $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
            $(this).attr("placeholder", "Please complete");
            ret = false;
            return false;

        }
		else if ($(this).hasClass("email") &&  !($(this).val().match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/)))
		{
			$(this).attr("value", "");
            $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
            $(this).attr("placeholder", "Please provide a valid email address");
            ret = false;
            return false;
		}
        else if ($(this).hasClass("decimal") && !$.isNumeric($(this).val()))
        {
            $(this).attr("value", "");
            $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
            $(this).attr("placeholder", "Please provide a decimal number");
            ret = false;
            return false;
        }
		else if ($(this).hasClass("msisdn")  && !($(this).val().match(/^(2547)/) && $(this).val().length==12 && $.isNumeric($(this).val())))
        {
            $(this).attr("value", "");
            $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
            $(this).attr("placeholder", "Please enter phone number in the format 25472XXXXXXXX");
            ret = false;
            return false;
        }
		else if ($(this).hasClass("password")  && !($(this).val().length>=6 && $(this).val().length<=32))
        {
            $(this).attr("value", "");
            $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
            $(this).attr("placeholder", "Password must be at least 6 characters and no more than 32 characters long");
            ret = false;
            return false;
        }
		else if ($(this).hasClass("shortcode")  && !($(this).val().length>=5 && $(this).val().length<=20))
        {
            $(this).attr("value", "");
            $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
            $(this).attr("placeholder", "Shortcode must be at least 5 characters and no more than 20 characters long");
            ret = false;
            return false;
        }		
        else
        {
            $(this).attr("style", "border: 1px inset rgb(89, 189, 69);");
            $(this).attr("placeholder", "Please complete");
            ret = true;
        }
    }
	});

    if (ret == false) //Hault script execution if check above returns false
        return ret;
    
     var dataString = $(this).closest("form").serialize();
    $.ajax({
            type: 'post',
            headers: { 'X-CSRF-Token' : $('[name=_token]').attr('value') },
            url: $(this).closest("form").attr("action"),
            data: dataString,
            success: function(result) {
                $('#contact_frame').html(result);
            },
            complete: function() {
            }
        });
        });

});
