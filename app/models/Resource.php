<?php


Class Resource extends Eloquent
{

    protected $table='resources';
    protected $primaryKey='resource_id';

    public function relation()
    {
        return $this->belongsTo('Relation');
    }

    public function identifier()
    {
        return $this->hasMany('Identifier');
    }

}