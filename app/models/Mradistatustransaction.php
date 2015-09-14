<?php
/*
 * 11	shares.select.permission	Finance	Shares	1	1	2	10	Shares	shares	1343412676
 * */
class Mradistatustransaction extends Eloquent{    
    protected $guarded = array('id');
    
    public function mraditransactionlog(){
		return $this->hasMany('Mraditransactionlog');
	}
	
	public function mradiwallettemplate(){
		return $this->hasMany('Mradiwallettemplate');
	}
    
    
}
