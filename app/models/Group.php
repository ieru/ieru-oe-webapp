<?php

class Group extends Eloquent 
{
    protected $table = 'groups';
    protected $primaryKey='group_id';
    protected $connection = 'oauth';

    public function users ()
    {
        return $this->belongsToMany( 'User', 'groups_users' );
    }

    public function permissions ()
    {
    	return $this->belongsToMany( 'Permission', 'groups_permissions' );
    }
}