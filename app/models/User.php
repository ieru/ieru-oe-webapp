<?php

class User extends Eloquent 
{
	protected $table = 'users';
	protected $primaryKey='user_id';
	protected $connection = 'oauth';

    private $_perms = null;

    public function tokens()
    {
        return $this->hasMany( 'Token' );
    }

    public function groups ()
    {
    	return $this->belongsToMany( 'Group', 'groups_users' );
    }

    public function check_permission ( $perm )
    {
        if ( is_null( $this->_perms ) )
        {
            $this->_perms = array();
            foreach ( $this->groups as $group )
            {
                foreach ( $group->permissions as $permission )
                {
                    $this->_perms[] = $permission->permission_id;
                }
            }
        }

        return in_array( $perm, $this->_perms );
    }
}