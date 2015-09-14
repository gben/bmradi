                                                                                                                                                                                                <div class="row well mid_footer">
    <div style="color: #000; width: 80%; margin: 0 auto;">

        <div style="width: 20%; float: left; margin: 10px;">
            <ul style="list-style: none;">
                 <li><img src='<?php echo url(); ?>/media/img/social_media/facebook.png'><a href="https://www.facebook.com/Mradifund/info" target="_blank" > Facebook</a></li>
                <li><img src='<?php echo url(); ?>/media/img/social_media/twitter-bird.png'> <a href="https://twitter.com/mradifund" target="_blank" > Twitter</a></li>
               <li><img src='<?php echo url(); ?>/media/img/social_media/google-plus.png'> Google Plus</li>
                <li><img src='<?php echo url(); ?>/media/img/social_media/youtube.png'> Youtube</li>
                <li><img src='<?php echo url(); ?>/media/img/social_media/rss.png'> RSS Feeds</li>
            </ul>
        </div>

        <div style="width: 20%; float: left; margin: 10px;">
            <ul style="list-style: none; padding: 5px;">
                <li><strong>Quick Links</strong></li>
                <a href='<?= route('login'); ?>'><li>Start Campaign</li> </a>
                <a href='<?= route('howitworks'); ?>'><li>How it works</li></a>
                <a href='<?= route('about'); ?>'><li>About Us</li></a>
                <a href='<?= route('contact_us'); ?>'><li>Contact Us</li></a>

            </ul>
        </div>
        <div style="width: 20%; float: left; margin: 10px;">
            <ul style="list-style: none; padding: 5px;">
                <li><strong>Popular categories</strong></li>
                <li>Agriculture</li>
                <li>Technology</li>
                <li>Health</li>
                <li>Entertainment</li>
                <li>SME</li>
                <li>Real Estates</li>
            </ul>
        </div>
        <div style="width: 20%; float: left; margin: 10px;">
            <ul style="list-style: none; padding: 5px;">
                <li><strong>Talk to us</strong></li>
                <li>Tel: 020 42 11 000</li>
                <li>Email: info@mradifund.com</li>
               <li><a href="https://www.facebook.com/Mradifund/info" target="_blank" > Facebook </a></li>
                <li><a href="https://twitter.com/mradifund" target="_blank" > Twitter</a></li>
            </ul>

        </div> <br /><br />


        <div style='width: 100%;  padding: 3px; clear: both; margin: 0; font-size: 14px; border-top: 1px solid #ccc; text-align: right;'>
            All rights reserved &copy;2014 MradiFund
        </div>


    </div>
</div>
<div class="contact_mradi" style="cursor:pointer">Contact us</div>
<div class="contact_mradi_frame" id="contact_frame" style="margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 10px; border: 0px; overflow: hidden; position: fixed; z-index: 16000002; right: 10px; bottom: 0px; border-top-left-radius: 5px; border-top-right-radius: 5px; display: none; width: 300px; /*height: 400px;*/ -webkit-box-shadow: rgba(0, 0, 0, 0.0980392) 0px 0px 3px 2px; box-shadow: rgba(0, 0, 0, 0.0980392) 0px 0px 3px 2px; background: white /*transparent*/;">
		<form name="feedback" method="post">
					<div class="form_description">
			<h2>Feedback</h2>
			<p>We would like to hear from you.</p>
		</div>
		<label class="description">Names * </label>
		<div class="input-group" style="display: block !important; width:">
			<input id="names" name="names" class="form-control required" style="height:30px;" type="text" maxlength="30" value=""> 
		</div> 	
		<label class="description">Email Address * </label>
		<div class="input-group" style="display: block !important; width:">
			<input id="email_address" name="email_address" class="form-control required email" style="height:30px;" type="text" maxlength="40" value=""> 
		</div> 
		
		<label class="description">Message * </label>
		<div class="input-group" style="display: block !important; width:">
                    <textarea id="description" name="description" class="form-control required" rows="4"></textarea> 
		</div> 
			    <span class="input-group-btn" style="padding-top: 10px">
                    <button class="btn btn-default" id="submit_" type="button" style="height:30px; padding-top: 1px">Send</button>
                </span>	<span class="input-group-btn" style="padding-top: 10px"> <?=Form::token();?>
                    <button class="btn btn-default" id="close" type="button" style="height:30px; padding-top: 1px">Close</button>
                </span>	
		</form>
</div>

<script type="text/javascript" src="<?php echo url(); ?>/media/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/jquery.sticky.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/fontsmoothie.min.js" async></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/jquery.scrollTo.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/jquery.countdown.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/main.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/retina.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/jquery.vegas.min.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/pseudo.jquery.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/verticaltabs.pack.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo url(); ?>/media/js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
                $("#textExample").verticaltabs({speed: 500,slideShow: false,activeIndex: 0});
                $("#textExample2").verticaltabs({speed: 500,slideShow: false,activeIndex: 0});
                $("#imageExample").verticaltabs({speed: 1000,slideShow: true,slideShowSpeed: 3000,activeIndex: 0,playPausePos: "topRight"});
                $("body").css("margin-top",$("#header").outerHeight());
        });
        function sticky_relocate() {
          var window_top = $(window).scrollTop();
          var div_top = $('#sticky-anchor').offset().top;
          if (window_top > div_top) {
            $('#becks').addClass('stick');
          } else {
            $('#becks').removeClass('stick');
          }
        }

        $(function() {
            var nav = $('#sticky-anchor');
            if(nav.length)
            {
                $(window).scroll(sticky_relocate);
                sticky_relocate();  
            }
          
        });
        $(".contact_mradi").click(function()
        {
            $('#contact_frame').slideDown();
        });
        $("#close").click(function()
        {
            $('#contact_frame').slideUp();
        });
        $("[name='date_of_birth']").datepicker(
        {
          minDate: new Date(1900,1-1,1), maxDate: '-18Y',
          dateFormat: 'yy/mm/dd',
          defaultDate: new Date(1990,1-1,1),
          changeMonth: true,
          changeYear: true,
          yearRange: '-110:-18'
        });
//        $("[name='date_of_birth']").datepicker({ dateFormat: "yy-mm-dd" ,maxDate: '0'});
	$('a[href="#ent_mradi"],a[href="#invest_mradi"]').on('click',function (e) {
	    e.preventDefault();
            if($(this).attr("href")=='#ent_mradi')
                {
                    $("#investing_mradi").hide();
                    $("#entre_mradi").show();
                }
            else
                {
                    $("#entre_mradi").hide();
                    $("#investing_mradi").show();  
                }
	    var target = this.hash,
	    $target = $(target);
            var targetOffset = $target.offset().top;
	    $('html,head,body').stop().animate({
	        'scrollTop': targetOffset - $("#header").outerHeight() }, 900, 'swing', function () {
	        window.location.hash = target;
	    });
        return false;
	});
      $("[name='account_type']").bind("change",function(){            
            checkAcc = $(this).val();  
            $("#submit_form").show();
            if(checkAcc == 'ENTREPRENEUR')
            {
                $("#investor_qns").hide();
                $("#ent_qns").show();
                
            }
            else if(checkAcc == 'INVESTOR')
            {
                $("#investor_qns").show();
                $("#ent_qns").hide();
            }
        
});
$('#submit_formxx').click(function(){
$('#submit_formxx').closest("form").validate({
        rules: {
          password: { 
                required: true, minlength: 6
          }, 
          confirm_password: { 
                required: true, equalTo: "#password", minlength: 6
          }, 
        email: {
          required: true, email: true
          },
      ent_qns_1: {
          required: true
          },      
      ent_qns_7: {
          required: true
          },
        firstname: {
          required: true, minlength: 2
          },
        middlename: {
         required: true, minlength: 1
        },
        lastname: {
          required: true, minlength: 2
        },
        username: {
          required: true , minlength: 5
        },
        gender: {
             required: true
          }      
        },
     // Specify the validation error messages
        messages: {
            firstname: "Please enter your first name",
            lastname: "Please enter your last name",
            middlename: "Please enter your middle name",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            username: "Please enter your preferred username",
            email: "Please enter a valid email address",
            gender: "Please select your gender",
            agree: "Please accept our policy"
        },
        /*errorLabelContainer: '#errors',*/
        submitHandler: function(form) {
            form.submit();
        }
      });
});
$('#submit_').click(function(){
            $('[name="' + $('#submit_').closest("form").attr("name") + '"] .required').each(function(i, obj) {
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
            url: '<?php echo url(); ?>/sendmessage',
            data: dataString,
            success: function(result) {
                $('#contact_frame').html(result);
            },
            complete: function() {
            }
        });
        });
   
</script>



<?php if (isset($sticky) && $sticky == false) { ?>

<script type="text/javascript">
                  
        $(window).load(function() {
            $("#header").sticky({topSpacing: 0});
        });
               
        
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
        
      
</script>
    
<?php } ?> 


<script>/*
    var url = '<?php //echo url(); ?>/media/images/icons.svg';
    var c = new XMLHttpRequest();
    c.open('GET.html', url, false);
    c.setRequestHeader('Content-Type', 'text/xml');
    c.send();
    document.body.insertBefore(c.responseXML.firstChild, document.body.firstChild)*/
</script>


<!-- Demo Switcher JS -->
<script type="text/javascript" src="<?php echo url(); ?>/media/js/fswit.js"></script>
</body>
</html>
                            
                            
                            
                            
                            
                            