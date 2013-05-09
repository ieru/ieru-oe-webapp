<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Token extends Eloquent implements UserInterface, RemindableInterface {

	protected $table = 'tokens';

	protected $connection = 'oauth';

	public function user ()
	{
	    return $this->belongs_to( 'User', 'user_id' );
	}
}