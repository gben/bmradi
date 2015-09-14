@extends('admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Profile
    </h1>
    <ol class="breadcrumb">
        <!-- <li><a href="#"><i class="fa fa-dashboard"></i> Profile</a></li> -->
        <li><a><i class="fa fa-edit"></i>
			{{HTML::linkRoute('profile.edit','Edit',Session::get('account_id'), ['data-toggle'=>'modal','data-target'=>'#myModal'])}}
        </a></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <h2 class="page-header"></h2>
    <div class="row">
        <div class="view">
            <?php
            $profileDetails = Helper::getProfileDetails(Input::get('acc'));

            if (((empty($profileDetails) || count($profileDetails) == 0 ) || Input::old())) { // if((count($campaignSummary[0])<=0 && Input::old()))
                $profileDetails[0] = new stdClass();
                $profileDetails[0]->firstname = Input::old('firstname');
                $profileDetails[0]->lastname = Input::old('lastname');
                $profileDetails[0]->country = Input::old('country');
                $profileDetails[0]->phone = Input::old('phone');
                $profileDetails[0]->email_address = Input::old('email_address');
                $profileDetails[0]->account_type = Input::old('account_type');
                $profileDetails[0]->date_created = Input::old('date_created');
                $profileDetails[0]->account_status = Input::old('account_status');
                $profileDetails[0]->location = Input::old('location');
                $profileDetails[0]->gender = Input::old('gender');
                $profileDetails[0]->date_of_birth = Input::old('date_of_birth');
                $profileDetails[0]->id_passport = Input::old('id_passport');
                $profileDetails[0]->pin_number = Input::old('pin_number');
                $profileDetails[0]->address = Input::old('address');
                $profileDetails[0]->profile_pic = Input::old('prof_pic');
            }
            ?>

            <div class="box box-solid">

                <div class="box-body row">
                    <div class="col-xs-8"> 
                        <dl class="dl-horizontal">
                            <dt style="text-align: left; white-space:normal; ">
                            <div style="float: left; width:100px; margin-top: 1px; margin-left: 20px; border-radius: 10px; height:100px; background-color: #fff;">
                                {{''; $file = Helpers::getUploadedFileDetails($profileDetails[0]->profile_pic);
                                $file_name = '';
                                if(empty($file))
                                $file_name = 'no-image.png';
                                else
                                $file_name = $file[0]->file_alias;
                                }}
                                {{HTML::image('assets/'.$file_name, $profileDetails[0]->firstname,array("width"=>"200px","height"=>"100px"))}}
                            </div>
                            </dt>
                            <dd>
                                <table class="table table-striped">
                                    <tbody>  
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Name:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->firstname .' '. $profileDetails[0]->lastname }}</td>
                                        </tr>
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Country:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->country }}</td>
                                        </tr>
                                        @if(strtoupper(Session::get('account_type'))=='ADMIN'||Session::get('account_id')==Input::get('acc'))
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Email Address:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->email_address }}</td>
                                        </tr>
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Phone Number:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->phone }}</td>
                                        </tr>
                                        @endif
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Gender:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->gender }}</td>
                                        </tr>
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Date of Birth:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->date_of_birth }}</td>
                                        </tr>
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Account Type:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->account_type }}</td>
                                        </tr>
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Account Status:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->account_status }}</td>
                                        </tr>
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Member Since:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->date_created }}</td>
                                        </tr>
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">PIN No.:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->pin_number }}</td>
                                        </tr>
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">ID No./Passport:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->id_passport }}</td>
                                        </tr>
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Address:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->address }} </td>
                                        </tr>
                                        <tr class="dl-horizontal">
                                            <td style="text-align: left; white-space:normal; ">Location:</td>
                                            <td style="color:rgb(49, 29, 142)" >{{ $profileDetails[0]->location }} </td>
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
    
    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


</section><!-- /.content -->
@stop
