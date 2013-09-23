<?php

class Token extends Eloquent 
{
	protected $table = 'tokens';
	protected $primaryKey='token_id';
	protected $connection = 'oauth';

	public function user ()
	{
	    return $this->belongsTo( 'User' );
	}
}