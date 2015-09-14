<section class="content-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h1>
        Edit Profile {{'<mark>'.@strtoupper($myProfile->firstname . ' ' . $myProfile->lastname).'</mark>'}}
    </h1>
</section>


<!-- Main content -->
<section class="content">
    <h2 class="page-header"></h2>
    <div class="row">
        <div class="view">

			<div class="modal-body">
				{{ Form::open(array('route'=>'profile.update', 'files' => true)) }}
				<div class="row">
					<div class="col-sm-8 col-md-10 ">
						<table class="table table-striped">
                             <tbody>  
                                 <tr class="dl-horizontal">
                                      <td style="text-align: left; white-space:normal; ">{{ Form::label('phone', 'Phone') }}:</td>
                                      <td style="color:rgb(49, 29, 142)" >{{ Form::text('phone', $myProfile->phone, ['required']) }}</td>
                                  </tr>
                                  
                                  <tr class="dl-horizontal">
                                      <td style="text-align: left; white-space:normal; ">{{ Form::label('address', 'Address') }}:</td>
                                      <td style="color:rgb(49, 29, 142)" >{{ Form::text('address', $myProfile->address, ['required']) }}</td>
                                  </tr>
                                  
                                  <tr class="dl-horizontal">
                                      <td style="text-align: left; white-space:normal; ">{{ Form::label('location', 'Location') }}:</td>
                                      <td style="color:rgb(49, 29, 142)" >{{ Form::text('location', $myProfile->location, ['required']) }}</td>
                                  </tr>
                                  
                                  <tr class="dl-horizontal">
                                      <td style="text-align: left; white-space:normal; ">{{ Form::label('photo', 'Upload/Change Profile Image:') }}</td>
                                      <td style="color:rgb(49, 29, 142)" >{{ Form::file('photo') }}</td>
                                  </tr>
                                  
                                   <tr class="">
                                      <td style="" colspan="2">{{ Form::hidden('user_id', $user_id)}}</td>
                                  </tr>
                                  
                             </tbody>
                        </table>
					</div>					
				</div>

				<div class="modal-footer" style="padding:10px;">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
					<button class="btn btn-primary">Save changes</button>
				</div>
			</div>

		</div>
	</div>
</section>

