<?php


Class Right extends Eloquent
{

    protected $table='rights';
    protected $primaryKey='right_id';

    public function lom()
    {
        return $this->belongsTo('Lom');
    }

}