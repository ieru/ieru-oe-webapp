<?php


Class Lifecycle extends Eloquent
{

    protected $table='lifecycles';
    protected $primaryKey = 'lifecycle_id';

    public function contribute()
    {
        return $this->hasMany('Contribute');
    }

    public function lom()
    {
        return $this->hasOne('Lom');
    }

}