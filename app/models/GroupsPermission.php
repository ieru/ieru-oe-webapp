<?php

class GroupsPermission extends Eloquent 
{
    protected $table = 'groups_permissions';
    protected $connection = 'oauth';

    public function permissions ()
    {
        return $this->hasMany('Permission');
    }

    public function groups ()
    {
        return $this->hasMany('Group');
    }
}