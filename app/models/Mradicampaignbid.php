<?php
/*
 * 11	shares.select.permission	Finance	Shares	1	1	2	10	Shares	shares	1343412676
 * */
class Mradicampaignbid extends Eloquent{    
    protected $guarded = array('id');
    
    public function mraditransactiontype(){
		return $this->belongsTo('Mraditransactiontype');
	}
	
	public function mradiwallettransaction(){
		return $this->hasMany('Mradiwallettransaction');
	}
    
}
