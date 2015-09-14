<section class="content-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h1>
        Enter Bid for {{'<mark>'.@strtoupper(Helpers::getCampaignID($campaignID,true)).'</mark>'}}
    </h1>
</section>


<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="view">
			<div class="modal-body">
				{{ Form::open(array('url'=>'bid', 'files' => true)) }}
				<div class="row">
					<div class="col-sm-8 col-md-10 ">
						<table class="table table-striped">
                             <tbody>  
                                 <tr class="dl-horizontal">
                                      <td style="text-align: left; white-space:normal; ">{{ Form::label('business', 'Business Name') }}:</td>
                                      <td style="color:rgb(49, 29, 142)" >{{ $campaign[0]->business_name .  Form::hidden('business_name', $campaign[0]->business_name, ['readonly']) }}</td>
                                  </tr>
                                  
                                  <tr class="dl-horizontal">
                                      <td style="text-align: left; white-space:normal; ">{{ Form::label('days_ongoing', 'Days Ongoing') }}:</td>
                                      <td style="color:rgb(49, 29, 142)" >
											<?php
												$datetime1 = date_create($campaign[0]->completion_time);
												$datetime2 = date_create(date('Y-m-d'));
												$interval = date_diff($datetime1, $datetime2);
												echo $interval->format('%R%a days');
											?>
										    {{
												
											    Form::hidden('days_ongoing', $campaign[0]->completion_time, ['readonly'])
											}}
									  </td>
                                  </tr>
                                  
                                  <tr class="dl-horizontal">
                                      <td style="text-align: left; white-space:normal; ">{{ Form::label('min_investment', 'Min Investment') }}:</td>
                                      <td style="color:rgb(49, 29, 142)" >{{ number_format($campaign[0]->min_investment,2) . Form::hidden('min_investment', $campaign[0]->min_investment, ['readonly']) }}</td>
                                  </tr>
                                  
                                  <tr class="dl-horizontal">
                                      <td style="text-align: left; white-space:normal; ">{{ Form::label('max_investment', 'Max Investment') }}:</td>
                                      <td style="color:rgb(49, 29, 142)" >{{ number_format($campaign[0]->max_investment,2) . Form::hidden('max_investment', $campaign[0]->max_investment, ['readonly']) }}</td>
                                  </tr>
                                                                    
                                  <tr class="dl-horizontal">
                                      <td style="text-align: left; white-space:normal; ">{{ Form::label('total_bidded', 'Total Bidded') }}:</td>
                                      <td style="color:rgb(49, 29, 142)" >{{ number_format($totalBid,2) . Form::hidden('total_bidded', $totalBid, ['readonly']) }}</td>
                                  </tr>
                                  
                                  <tr class="dl-horizontal">
                                      <td style="text-align: left; white-space:normal; ">{{ Form::label('amt_remaining', 'Amount Remaining') }}:</td>
                                      <td style="color:rgb(49, 29, 142)" >{{ number_format(($cValue - $totalBid),2) . Form::hidden('amt_remaining', ($cValue - $totalBid), ['readonly']) }}</td>
                                  </tr>
                                  
                                  <tr class="dl-horizontal">
                                      <td style="text-align: left; white-space:normal; ">{{ Form::label('investor_balance', 'Account Balance') }}:</td>
                                      <td style="color:rgb(49, 29, 142)" >{{ number_format($investor_balance,2) . Form::hidden('investor_balance', $investor_balance, ['readonly']) }}</td>
                                  </tr>
                                  
                                  <tr class="dl-horizontal">
                                      <td style="text-align: left; white-space:normal; ">{{ Form::label('bid_amt', 'Enter Amount') }}:</td>
                                      <td style="color:rgb(49, 29, 142)" >
										  <?php
												$cbal = $cValue - $totalBid;
												if(($cbal > 0) && $cbal > $campaign[0]->min_investment){
													if($cbal >= $campaign[0]->max_investment){
														$max_bid = ($investor_balance < $campaign[0]->max_investment) ? $investor_balance : $campaign[0]->max_investment;
														$min_bid = $campaign[0]->min_investment;
													}else{
														$max_bid = ($investor_balance < $cbal) ? $investor_balance : $cbal;
														$min_bid = $campaign[0]->min_investment;
													}
												}elseif(($cbal > 0) && $cbal < $campaign[0]->min_investment){
													$max_bid = ($investor_balance < $cbal) ? $investor_balance : $cbal;
													$min_bid = ($investor_balance < $cbal) ? $investor_balance : $cbal;
												}
										  
										  ?>
										{{
										  Form::input('number', 'bid_amt', Input::old('bid_amt'), ['required'=>'true', 'min'=>$min_bid, 'max'=>$max_bid]) 
									    }}
									  </td>
                                  </tr>
                                  
                                   <tr class="">
                                      <td style="" colspan="2">{{ Form::hidden('campaign_id', $campaignID)}}</td>
                                  </tr>
                                  
                             </tbody>
                        </table>
					</div>					
				</div>

				<div class="modal-footer" style="padding:10px;">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button class="btn btn-primary">Submit Bid</button>
				</div>
			</div>

		</div>
	</div>
</section>

