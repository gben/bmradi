<div class="row well mid_footer">
    <div style="color: #000; width: 80%; margin: 0 auto;">

        <div style="width: 20%; float: left; margin: 10px;">
            <ul style="list-style: none;">
                <li><img src='<?php echo url(); ?>/media/img/social_media/facebook.png'><a href="#"> Facebook.com</a></li>
                <li><img src='<?php echo url(); ?>/media/img/social_media/twitter-bird.png'> Twitter</li>
                <li><img src='<?php echo url(); ?>/media/img/social_media/google-plus.png'> Google Plus</li>
                <li><img src='<?php echo url(); ?>/media/img/social_media/youtube.png'> Youtube</li>
                <li><img src='<?php echo url(); ?>/media/img/social_media/rss.png'> RSS Feeds</li>
            </ul>
        </div>

        <div style="width: 20%; float: left; margin: 10px;">
            <ul style="list-style: none; padding: 5px;">
                <li><strong>Quick Links</strong></li>
                <li>Start Campaign</li>
                <li>How it works</li>
                <li>About Us</li>
                <li>Careers</li>

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
                <li>Tel: (+254)700825555</li>
                <li>Email: info@fundcentral.com</li>
                <li>Facebook</li>
                <li>Twitter</li>
            </ul>

        </div> <br /><br />


        <div style='width: 100%;  padding: 3px; clear: both; margin: 0; font-size: 14px; border-top: 1px solid #ccc; text-align: right;'>
            All rights reserved &copy;2014 MradiFund
        </div>


    </div>
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

<script type="text/javascript">
        $(document).ready(function(){
                $("#textExample").verticaltabs({speed: 500,slideShow: false,activeIndex: 2});
                $("#imageExample").verticaltabs({speed: 1000,slideShow: true,slideShowSpeed: 3000,activeIndex: 0,playPausePos: "topRight"});
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