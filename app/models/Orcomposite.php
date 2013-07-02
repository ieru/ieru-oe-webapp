<?php


Class Orcomposite extends Eloquent
{

    protected $table='orcomposites';
    protected $primaryKey='orcomposite_id';

    public function requirement()
    {
        return $this->belongsTo('Requirement');
    }
}