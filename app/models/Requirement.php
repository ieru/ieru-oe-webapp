<?php

Class Requirement extends Eloquent
{

    protected $table='requirements';
    protected $primaryKey='requirement_id';

    public function orcomposite()
    {
        return $this->hasMany('Orcomposite');
    }

    public function technical()
    {
        return $this->belongsTo('Technical');
    }

}