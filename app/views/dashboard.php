<?php include 'common/dashboard_header.php'; ?>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo url(); ?>">Mradi Dashboard</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <?= link_to('/', 'logout'); ?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-2">
                
                <?php include 'common/dashboard_nav.php'; ?>
            </div>

            <div class="col-md-10">

                <div class="thumbnail" style='border: none;'>
                    <div class="text-right">
                        <?php 
                        
                        $acc_type = Session::get('account_type'); 
                        
                        if($acc_type == 'ENTREPRENEUR'){ ?>
                        <button class="btn btn-primary ">Create Campaign</button> 
                            <?php } ?>
                    </div>
                    <!--<img class="img-responsive" src="http://placehold.it/800x300" alt=""> -->

                    <!--<div class="ratings">
                        <p class="pull-right">3 reviews</p>
                        <p>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            4.0 stars
                        </p>
                    </div> -->
                </div>

                <div class="">

                    <hr>

                    <?php 
                    
                    $campaign = Campaign::get_campaign_by_account_id(Session::get('account_id'));
                         
                    
                    
                    if($acc_type == 'ENTREPRENEUR'){
                        ?>
                    <h3>Create a campaign</h3>
                            <form role="form">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Name</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Name">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Description</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Description">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">New / Existing</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Description">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Share Value(Ksh)</label>
                              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Enterpreneur Information</label>
                              <textarea class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                          </form>
                        <?php
                    } else {
                        ?>
                    <h3>Fund a campaign</h3>        
                    <form role="form">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Investor name</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Name">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Current Business</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Current business">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Select Categoery</label>
                              <select class="form-control">
                                  <option>Agriculture</option>
                                  <option>Business</option>
                                  <option>Manufacturing</option>
                              </select>
                            </div>
                            
                            <button type="submit" class="btn btn-default">Submit</button>
                          </form>
                        <?php
                    }
                    
                        
                    ?>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>
        <?php include 'common/dashboard_footer.php'; ?>