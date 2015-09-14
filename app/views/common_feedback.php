<?php include 'common/header.php'; ?>
<div>
    <div class="row" style='width: 1000px; margin: 0 auto; margin-top: 30px;'>


        <div class="row">

            <div class="col-sm-12 blog-main">

                <div class="blog-post">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="blog-header">
                                <h1 class="blog-title"><?= (Session::get('common_title')==''?'Thank you for your feedback':Session::get('common_title')); ?></h1>
                            </div>
                        </div>
                        <div class="panel-body" style="padding-top: 50px;">
                            <?= Session::get('common_feedback'); ?>                            
                            <br />
                        </div>
                      </div>
                </div>
            </div><!-- /.blog-main -->

            <div class="col-sm-2 col-sm-offset-1 blog-sidebar">
                <!--<div class="sidebar-module sidebar-module-inset">
                    <h4>About</h4>
                    <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                </div>
                <div class="sidebar-module">
                    <h4>Archives</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">March 2014</a></li>
                        <li><a href="#">February 2014</a></li>
                        <li><a href="#">January 2014</a></li>
                        <li><a href="#">December 2013</a></li>
                        <li><a href="#">November 2013</a></li>
                        <li><a href="#">October 2013</a></li>
                        <li><a href="#">September 2013</a></li>
                        <li><a href="#">August 2013</a></li>
                        <li><a href="#">July 2013</a></li>
                        <li><a href="#">June 2013</a></li>
                        <li><a href="#">May 2013</a></li>
                        <li><a href="#">April 2013</a></li>
                    </ol>
                </div>
                <div class="sidebar-module">
                    <h4>Elsewhere</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                    </ol>
                </div>
            </div><!-- /.blog-sidebar -->

        </div><!-- /.row -->


    </div>

</div>


<?php include 'common/footer.php'; ?>