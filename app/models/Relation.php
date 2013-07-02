<?php


Class Relation extends Eloquent
{

    protected $table='relations';
    protected $primaryKey='relation_id';

    public function lom()
    {
        return $this->belongsTo('Lom');
    }

    public function resource()
    {
        return $this->hasOne('Resource');
    }

}