<?php
/*
 * 11	shares.select.permission	Finance	Shares	1	1	2	10	Shares	shares	1343412676
 * */
class Mradiwallettransaction extends Eloquent{    
    protected $guarded = array('id');
    
    public function mraditransactiontype(){
		return $this->belongsTo('Mraditransactiontype');
	}
	
	public function mraditransactionlog(){
		return $this->hasOne('Mraditransactionlog', 'id', 'mraditransactionlog_id');
	}
	
	public function mradicampaignbid(){
		return $this->belongsTo('Mradicampaignbid', 'mradicampaignbid_id', 'id');
	}
}
