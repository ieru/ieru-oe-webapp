<?php

class Permission extends Eloquent {

	protected $table = 'permissions';
	protected $primaryKey='permission_id';
	protected $connection = 'oauth';

    public function groups ()
    {
    	return $this->belongsToMany( 'Group', 'groups_permissions' );
    }
}