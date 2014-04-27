<?php

class GroupsUser extends Eloquent 
{
    protected $table = 'groups_users';
    protected $connection = 'oauth';

    public function users ()
    {
        return $this->hasMany('User');
    }

    public function groups ()
    {
        return $this->hasMany('Group');
    }
}