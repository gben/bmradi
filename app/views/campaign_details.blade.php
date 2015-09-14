<section class="content-header">
    <h1>
        Details
    </h1>
    
</section>
<!-- Main content -->
<section class="content">
    <h2 class="page-header"></h2>
    <div class="row">
        <div class="view">

            <div class="box box-solid">

                <div class="box-body row">
                    <div class="col-xs-9"> 
                        <dl class="dl-horizontal">
                            <dt style="text-align: left; white-space:normal; ">
                            <div style="float: left; width:100px; margin-top: 1px; margin-left: 20px; border-radius: 10px; height:100px; background-color: #fff;">
                                {{''; $file = Helpers::getUploadedFileDetails($myDetails[0]->listing_logo);
                                $file_name = '';
                                if(empty($file))
                                $file_name = 'no-image.png';
                                else
                                $file_name = $file[0]->file_alias;
                                }}
                                {{HTML::image('assets/'.$file_name, $myDetails[0]->business_name,array("width"=>"200px","height"=>"100px"))}}
                            </div>
                            </dt>
                            <dd>
                                <table class="table table-striped">
                                    <tbody>  
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Business Name:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $myDetails[0]->business_name }}</td>
                                        </tr>
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Business Summary:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $myDetails[0]->business_summary }}</td>
                                        </tr>
                                        
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Min Investment:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $myDetails[0]->min_investment }}</td>
                                        </tr>
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Max Investment:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $myDetails[0]->max_investment }}</td>
                                        </tr>
                                        
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Video:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $myVideo[0]->video_url }}</td>
                                        </tr>
                                        
                                        <tr class="dl-horizontal">
                                            <td align="center" colspan="2" style="color:rgb(49, 29, 142)" >
                                            <button class="btn-primary" ><a  href="login" >Place Bid</a></button>
                                            
                                            <button class="btn-warning"><a  href="<?=URL::previous();?>" >Cancel</a></button>
                                            
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                            </dd>
                        </dl>

                    </div>
                </div>
            </div>


        </div>

    </div> 
    
 


</section><!-- /.content -->

