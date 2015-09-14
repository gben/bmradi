<?php include 'common/header.php'; ?>
<div>


    <?php
    /* array (size=1)
      0 =>
      object(stdClass)[152]
      public 'campaign_id' => int 1
      public 'campaign_trx_id' => string 'HSHJG7I78Y3HGDSJHD' (length=18)
      public 'title' => string 'Zikia Exhibitions' (length=17)
      public 'caption' => string 'Putting art on the walls' (length=24)
      public 'campaign_summary' => string 'Zikia is a Nairobi based gallery that aims to bring many artist together to find market for their artworks.' (length=107)
      public 'campaign_info' => string 'Zikia was started in the early 2012 by Pat Kariki and Monari Sammy. The concept was to raise the standards of prizing artworks for painters and sketch artist in Kenya as well as the wider East Africa.' (length=200)
      public 'amount_proposed' => float 300000
      public 'no_of_shares' => int 1000
      public 'share_value' => float 300
      public 'date_created' => string '2014-08-10 14:19:31' (length=19)
      public 'keywords' => string 'Art, Artist, Painting, Painters, Gallery, Exhibition' (length=52)
      public 'date_modified' => null
      public 'youtube_video_link' => null
      public 'promotional_image' => string 'f.jpg' (length=5)
      public 'share_bought' => int 500
      public 'amount_raised' => float 150000
      public 'campaign_status' => string 'ACTIVE' (length=6)
      public 'expiry_date' => string '2014-08-10 14:21:31' (length=19)
      public 'template_selected' => int 1
      public 'all_templates' => string '1,' (length=2)
      public 'account_id' => int 1
      public 'promotional_logo' => string 'f.jpg' (length=5)
     * */


    $campaign_info = '';
    $title = '';
    $amount_proposed = 0.0;
    $no_of_shares = 0;
    $shares_bought = 0;
    $caption = '';
    $percentage_share_completion = 0;

    foreach ($c_data as $c_item):

        $campaign_info = $c_item->campaign_info;
        $title = $c_item->title;
        $amount_proposed = $c_item->amount_proposed;
        $no_of_shares = $c_item->no_of_shares;
        $shares_bought = $c_item->share_bought;
        $caption = $c_item->caption;
        $percentage_share_completion = ($c_item->share_bought * 100) / $c_item->no_of_shares;

    endforeach;
    ?>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <div style="clear: both;">
        <center>

            <div class="row" style="width: 1000px;">
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search campaign...">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button"> <span class="glyphicon glyphicon-search"></span> Search Campaign</button> 
                        </span>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.col-lg-6 -->
    </div>

    <div class="row" style='width: 1000px; margin: 0 auto; margin-top: 30px;'>

        <div class="col-md-8">

            <div class="jumbotron col-md-12" style='background: url("<?php echo url() . "/_image/_Promotional_image/legal.jpg"; ?>") center no-repeat; background-color: #ccc;'>
                <div class="" style="width: 300px; padding: 10px; background-color: #333; opacity: 0.8; filter: alpha(opacity=60); /* For IE8 and earlier */  color: #FFF; text-shadow: none;">

                    <h4><?php echo $title; ?></h4>
                    <?php echo $caption; ?>


                </div>
            </div>


            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4>About <?php echo $title; ?></h4></div>
                    <div class="panel-body">
                        <?php echo $campaign_info; ?>
                    </div>
                </div>


                <br /><br />
                <div id="disqus_thread"></div>
                <script type="text/javascript">
                    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                    var disqus_shortname = 'mradifunds'; // required: replace example with your forum shortname

                    /* * * DON'T EDIT BELOW THIS LINE * * */
                    (function() {
                        var dsq = document.createElement('script');
                        dsq.type = 'text/javascript';
                        dsq.async = true;
                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
            </div>

        </div>


        <div class="col-md-4">
            <div>
                <h4><?php echo $title; ?></h4>
                <div class="progress">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage_share_completion; ?>%;">
                        <span class="sr-only"><?php echo $percentage_share_completion; ?>% Complete</span>
                    </div>
                </div>
                <p>
                <h4></h4>
                </p>
                <h3><?php echo number_format($no_of_shares); ?> Shares </h3>
                <h6><?php echo number_format($no_of_shares - $shares_bought); ?> Remaining |  Days Remaining</h6> <br />
                <button class="btn btn-success btn-sm">Buy equity</button><br />
            </div>
            
            <br />

            <div class="panel panel-default" style="clear: both;">
                <div class="panel-heading">Recent Contributors</div>
                <div class="panel-body">
                    458 Sam <br />
                    121 Joel Sang <br />
                    50 Sam <br />
                    125 Sam <br />
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Panel heading without title</div>
                <div class="panel-body">
                    Panel content
                </div>
            </div>
        </div>


        <div style="clear: both;"></div>
    </div>

</div>


<?php include 'common/footer.php'; ?>