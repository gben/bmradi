<?php
/*
 * 11	shares.select.permission	Finance	Shares	1	1	2	10	Shares	shares	1343412676
 * */
class Mradiwallettemplate extends Eloquent{    
    protected $guarded = array('id');
    
    public function mradistatustransaction(){
		return $this->belongsTo('Mradistatustransaction');
	}
}
